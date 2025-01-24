<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ZohoController;

use App\Models\IncomeSource;
use App\Models\PaymentFrequency;
use App\Models\State;
use App\Rules\ValidStateRule;

class MultiStepForm extends Component
{
    public $step = 1;

    public $approvalID = '';
    public $showMessage = false;

    public $merchantId = '';
    public $total = '';
    public $products = [];

    public $firstName = '';
    public $lastName = '';
    public $email = '';

    public $street = '';
    public $city = '';
    public $state = '';
    public $zipcode = '';

    public $phone = '';
    public $ssn = '';
    public $dob = '';

    public $sourceOfIncome = '';

    public $employerName = '';
    public $employerStreet = '';
    public $employerCity = '';
    public $employerState = '';
    public $employerZipcode = '';
    public $employerPhone = '';

    public $paidFrequency = '';
    public $nextPayday = '';
    public $directDeposit = '';
    public $bankName = '';

    /*******************
     *** Validations ***
     *******************/

    protected function rules()
    {
        return [
            // 'approvalID' => 'required|digits:19',
            'merchantId' => 'required',
            'total' => 'required',
            'products' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'dob' => 'required|date|before:18 years ago',
            'street' => 'required',
            'city' => 'required',
            'state' => ['required', new ValidStateRule($this->state)],
            'zipcode' => 'required|digits:5',
            'ssn' => 'required|size:11',
            'sourceOfIncome' => 'required',
            'employerName' => 'required',
            'employerStreet' => 'required',
            'employerCity' => 'required',
            'employerState' => 'required',
            'employerZipcode' => 'required|digits:5',
            'employerPhone' => 'required|digits:10',
            'paidFrequency' => 'required',
            'nextPayday' => 'required|date',
            'directDeposit' => 'required',
            'bankName' => 'required',
        ];
    }

    protected $messages = [
        'dob.before' => 'You must be older than 18 years old',
        'ssn.size' => 'SSN must meet the following format xxx-xx-xxxx',
    ];

    private $fieldGroups = [
        1 => ['merchantId'],
        2 => [
            'total',
            'products',
            'firstName',
            'lastName',
            'email',
            'phone',
            'dob',
        ],
        3 => ['street', 'city', 'state', 'zipcode'],
        4 => ['ssn', 'sourceOfIncome'],
        5 => [
            'employerName',
            'employerStreet',
            'employerCity',
            'employerState',
            'employerZipcode',
            'employerPhone',
        ],
        6 => ['paidFrequency', 'nextPayday', 'directDeposit', 'bankName'],
    ];

    /**********************
     *** Select options ***
     **********************/

    public $states;
    public $sourcesOfIncome;
    public $paymentFrequencies;

    /**********************
     *** Helper Methods ***
     **********************/

    /**
     * Returns the validation rules for the fields of
     * the given step of the form.
     *
     * @return array of rules to validate.
     */
    private function getRulesToValidate($step)
    {
        $rulesToValidate = collect([]);

        foreach ($this->fieldGroups[$step] as $key => $field) {
            $rulesToValidate->put($field, $this->rules()[$field]);
        }

        return $rulesToValidate->toArray();
    }

    /**********************
     *** Render Methods ***
     **********************/

    public function mount()
    {
        $this->merchantId = app('request')->input('merchantId');
        $this->total = app('request')->input('total');
        $this->products = app('request')->input('products');
        $this->states = State::all();
        $this->incomeSources = IncomeSource::all();
        $this->paymentFrequencies = PaymentFrequency::all();
        if($this->merchantId == 4342803000333236237){
            // total and product needs to have some value to pass through required validate step
            $this->total = app('request')->input('total') ?? '0';
            $this->products = app('request')->input('products') ?? 'New deal';
            $this->firstName = app('request')->input('firstName') ?? '';
            $this->lastName = app('request')->input('lastName') ?? '';
            $this->email = app('request')->input('email') ?? '';
            $this->phone = app('request')->input('phone') ?? '';
            $this->dob = app('request')->input('dob') ?? '';
            $this->street = app('request')->input('street') ?? '';
            $this->city = app('request')->input('city') ?? '';
            $this->state = app('request')->input('state') ?? '';
            $this->zipcode = app('request')->input('zipcode') ?? '';
        }
    }

    public function nextStep($step)
    {
        $this->validate($this->getRulesToValidate($step));
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function gotoStep($step)
    {
        if ($step > $this->step) {
            $this->validate($this->getRulesToValidate($this->step));
        }

        $this->step = $step;
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function submitForm()
    {
        $data = collect($this->fieldGroups)
            ->flatten()
            ->mapWithKeys(function ($field, $key) {
                return [$field => $this->$field];
            })
            ->toArray();
        $this->validate();

        $zohoController = new ZohoController();
        $dealId = $zohoController->insertDealRecord($data);

        if ($dealId) {
            return redirect()->route('plaid', [
                'deal_id' => $dealId,
                'total' => $this->total,
                'products' => $this->products,
            ]);
        }

        return redirect()->route('denied');
    }

    public function submitApprovalID() {
        $deal = '';

        try {
            $zohoController = new ZohoController();
            $deal = $zohoController->getDeal($this->approvalID);

            if(number_format((float) $this->total / 100, 2, '.', '') <= (int)$deal['Progressive_Amount']
                && $deal['Amount'] == NULL){
                // Deal exists and approval amount is greater than total amount.
                // proceed to initial payment.
                return redirect()->route('payment', [
                    'deal_id' => $this->approvalID,
                    'total' => $this->total,
                    'products' => $this->products,
                ]);

            } else {
                // when total is greater than approval amount, redirect to failed page
                // go back to shopify cart.
                // $deal = 'your cart total is more than your approval amount';
                
                return redirect()->route('dealDenied');
            }

            // return redirect()->route('display', ['deal' => $deal]);
        } catch (\Throwable $th) {
            // show message for deal not exists and ask to continue with the application.
            $this->showMessage = true;
        }
    }

    public function render()
    {
        return view('livewire.forms.multi-step-form', compact($this->showMessage));
    }
}
