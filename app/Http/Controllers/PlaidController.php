<?php



namespace App\Http\Controllers;



use Carbon\Carbon;

use PlaidConsts;



use App\Http\Controllers\ZohoController; 

use App\Models\PlaidAssetReportToken;



use Asciisd\Zoho\Facades\ZohoManager;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use TomorrowIdeas\Plaid\Plaid;

use TomorrowIdeas\Plaid\PlaidRequestException;



class PlaidController extends Controller

{

    private $plaid;



    public function __construct()

    {

        $this->plaid = new Plaid(

            env('PLAID_CLIENT_ID'),

            env('PLAID_CLIENT_SECRET'),

            env('PLAID_ENV')

        );

    }



    public function index(Request $request)

    {

        $dealId = $request->deal_id;

        return view('gateway.plaid', [

            'deal_id' => $dealId,

            'total' => $request->total,

            'products' => $request->products,

        ]);

    }



    /**

     * Once the report from plaid is generated,

     * it stores the PDF of the report and sends

     * them to Zoho.

     *

     * @return Response

     */

    public function webhook(Request $request)

    {

        if ($request->webhook_type == 'TRANSACTIONS') {

            return response('Success', 200);

        }



        $zohoController = new ZohoController();



        Log::info($request->all());



        $token = PlaidAssetReportToken::where(

            'asset_report_id',

            $request->asset_report_id

        )->first();



        try {

            // Get PDF of the report

            $reportPDF = $this->plaid->reports->getAssetReportPdf(

                $token->asset_report_token

            );

        } catch (PlaidRequestException $e) {

            Log::error($e . ' Plaid Error Processing PDF');

            dd($e->getResponse());

        }



        try {

            $url = 'plaid/Plaid_Assets' . date('m-d-Y_hia') . '.pdf';

            $path = Storage::put($url, $reportPDF->getBody());



            $zohoController->uploadDealAttachment($token->deal_id, $url);

        } catch (Exception $e) {

            Log::error($e . ' Plaid Error Processing PDF2');

            dd($e);

        }



        return response('Success', 200);

    }



    /**

     * Returns an approval status for the Plaid step

     * of the gateway and calculates the approval

     * amount.

     */

    public function checkPlaidToken(Request $request)

    {

        $zohoController = new ZohoController();



        $dealId = $request->dealId;

        $total = (int) $request->total / 100;

        $token = $this->plaid->items->exchangeToken($request->public_token)

            ->access_token;



        $deal = $zohoController->getDeal($dealId);

        $contactId = $deal['Contact_Name']->getEntityId();

        $contact = $zohoController->getContact($contactId);



        $plaidData = [

            'webhook' => env('PLAID_WEBHOOK'),

            'user' => [

                'first_name' => $contact['First_Name'],

                'last_name' => $contact['Last_Name'],

                // 'dealer_id' => $dealId,

                // 'ssn' => $deal['Social_Security_Number'],

                'email' => $deal['Email'],

                'phone_number' => '+1' . $deal['Phone'],

                'client_user_id' => $contactId,

            ],

        ];



        $approvalAmount = 0;

        



        // Calculate transactions detail to get an approval amount.

        try {

            // Get transactions.

            sleep(3); //allow time for transactions list to populate - RC

            $transactions = $this->plaid->transactions->list(

                $token,

                Carbon::now()->subDays(30), //only 1 months (used days for accuracy) worth of transactions are guaranteed on api-call -- if you want more than 2 months you have to wait for the transactions update webhook - RC

                Carbon::now()

            );



            // Create asset report.

            $assetReport = $this->plaid->reports->createAssetReport(

                [$token],

                PlaidConsts::DAYS_AMOUNT_FOR_ASSET_REPORT,

                $plaidData

            );



            // Store report token.

            PlaidAssetReportToken::create([

                'asset_report_id' => $assetReport->asset_report_id,

                'asset_report_token' => $assetReport->asset_report_token,

                'deal_id' => $dealId,

            ]);



            // Get approval amount.

            $approvalAmount = $this->calculateApprovalAmount(

                $transactions->transactions

            );

        } catch (PlaidRequestException $e) {

            dd($e->getResponse());

        }



        // If approval amount is higher than invoice amount

        if ($approvalAmount < $total) {

            // Prevent continuing to payment and return error response.

            //$this->sendEmail();

            $zohoController->updateDealApprovalAmount($dealId, $approvalAmount); //sending approval even if it's not enough to cover invoice - RC

            return response(

                [

                    'approved' => false,

                    'approvalAmount' => $approvalAmount,

                    'today' => 0,

                    'recurring' => 0,

                    'firstName' => $contact['First_Name'],

                    'lastName' => $contact['Last_Name'],

                    'email' => $contact['Email'],

                    'dealId' => $dealId,

                    'smaller_than_invoice' => true,

                ],

                200

            );

        }



        // Send email data of the math to admin.

        //$this->sendEmail();



        // Set payment intervals

        switch ($deal['How_Often_Do_you_get_Paid']) {

            case 'Weekly':

                $interval = 52;

                break;

            case 'Bi-Weekly':

                $interval = 26;

                break;

            case 'Monthly':

                $interval = 12;

                break;

            case 'Semi-Monthly':

                $interval = 24;

                break;

            default:

                $interval = 12;

                break;

        }



        // Rules.

        if (

            $deal['State'] == 'Connecticut' ||

            $deal['State'] == 'Ohio' ||

            $deal['State'] == 'Vermont' ||

            $deal['State'] == 'Iowa' ||

            $deal['State'] == 'Maine' ||

            $deal['State'] == 'Hawaii'

        ) {

            $recurring = ($total * 2) / $interval;

        } else {

            $recurring = ($total * 2.2) / $interval;

        }



        $recurring = round($recurring, 2);

        

        

        //determine the appropriate application fee

        $appfee = 10;

        

        if($deal['State'] == 'Michigan'){

            $appfee = 0;

        }

        else if($deal['State'] == 'North Carolina'){

            $appfee = 5;

        }

        else{

            $appfee = 10;

        }



        // Update deal

        $zohoController->updateDealApprovalAmount($dealId, $approvalAmount);



        // Redirect to payment.

        return response(

            [

                'approved' => $approvalAmount != 0,

                'approvalAmount' => $approvalAmount,

                'today' => $recurring + $appfee,

                'recurring' => $recurring,

                'firstName' => $contact['First_Name'],

                'lastName' => $contact['Last_Name'],

                'email' => $contact['Email'],

                'dealId' => $dealId,

                'smaller_than_invoice' => false,

            ],

            200

        );

    }



    /**

     * Calculates approval amount taking into account

     * the defined conditions for transactions.

     * 

     * SSI/SSA code was added by Hemil on 06/03/2024.

     *

     * @param array $transactions | array of transactions.

     * @return number Approval amount.

     **/

    private function calculateApprovalAmount($transactions)

    {

        $dataArr = [];              // array to hold transaction dates

        $tranAmountArray = [];      // array to hold transaction amounts

        $ssiArray = [];             // array to hold SSI/SSA transaction amounts

        $total = 0;

        $approvalAmount = 0;



        for ($i = 0; $i < count($transactions); $i++) {

            $tranDate = $transactions[$i]->date;

            $tranCategories = $transactions[$i]->category;



            if (isset($tranCategories)) {

                $dataArr[] = $tranDate;



                if ($this->matchesTransactionCondition($tranCategories, 0)) {

                    $tranAmount = $transactions[$i]->amount;

                    // Maximum one can make on social security is ~$3,900 a month

                    if (

                        abs($tranAmount) <

                            PlaidConsts::MAXIMUM_SOCIAL_SECURITY_AMOUNT_PER_MONTH &&

                        isValidTransaction($tranAmount)

                    ) {

                        $ssiArray[] = $transactions[$i]->amount;

                    }

                }

                //'Benefits' (the category for Unemployment and Stimulus Checks)

                elseif (

                    ($this->matchesTransactionCondition($tranCategories, 1) &&

                        (array_key_exists(2, $transactions[$i]->category) &&

                            $transactions[$i]->category[2] != 'Benefits')) ||

                    $this->matchesTransactionCondition($tranCategories)

                ) {

                    $tranAmount = $transactions[$i]->amount;

                    if ($this->isValidTransaction($tranAmount)) {

                        $tranAmountArray[] = $transactions[$i]->amount;

                    }

                }

            }

        }



        $tranAmount = count($tranAmountArray);



        if ($tranAmount <= 14) {

            $total = array_sum($tranAmountArray);

        } else {

            sort($tranAmountArray);

            $tranAmountArray = array_slice($tranAmountArray, 0, 14);

            $total = array_sum($tranAmountArray);

        }

        

        $regApprovalAmount = 0;

        $ssiApprovalAmount = 0;



        if (is_numeric(abs($total)) && $total != 0) {

            usort($dataArr, [

                'App\Http\Controllers\PlaidController',

                'compareByTimeStamp',

            ]);

            // total months of income from Transactions

            $totalMonth = 1;

            // the average income of a period of days

            $monthlyIncome = abs($total) / $totalMonth;

            // approval is based on 40% of monthly average income - changed to 30% of monthly income on 4/25 - RC

            $regApprovalAmount = ($monthlyIncome * 30) / 100;

            // rounds approval up, to the nearest 10

            $regApprovalAmount = ceil($regApprovalAmount / 10) * 10;

        } 

        // calculate approval based on SSI/SSA payments

        if(count($ssiArray) != 0) {

            //sum the payments then divide by the amount of transactions

            $total = array_sum($ssiArray) / count($ssiArray);

            //take 20% of the sum

            $ssiApprovalAmount = (abs($total) * 20) / 100;

            //round UP to the nearest 10

            $ssiApprovalAmount = ceil($ssiApprovalAmount / 10) * 10;

            

        }

        

        $approvalAmount = $regApprovalAmount + $ssiApprovalAmount;



        // 1200 is the maximum for an approval

        if ($approvalAmount > 1200) {

            $approvalAmount = 1200;

        }



        // if approval is less than $250 OR the account has less than 2 transactions, amount pushed to Zoho and UW and Dealer is $0 (changed to < 2 transaction amt - RC)

        if ($approvalAmount < 250 || $tranAmount < 2) { 

            $approvalAmount = 0;

        }



        return $approvalAmount;

    }



    /**

     * Sends transactions info to admin.

     **/

    private function sendEmail()

    {

        $htmlMessage = '<p>Shopify Deal <br> Deal Id : ' . $dealId . ' </p>'; //added text to indicate deal is from Shopify --RC

        $htmlMessage .=

            "<p>Total deposited transactions greater than $ 100 : " .

            count($tranAmountArray) .

            ' </p>';



        if (count($tranAmountArray) <= 14) {

            $total = array_sum($tranAmountArray);

            $htmlMessage .=

                '<p>Sum of ' .

                count($tranAmountArray) .

                ' Transactions: ' .

                array_sum($tranAmountArray) .

                ' </p>';

        } else {

            sort($tranAmountArray);

            $tranAmountArray = array_slice($tranAmountArray, 0, 14);

            $total = array_sum($tranAmountArray);

            $htmlMessage .=

                '<p>Sum of 14 Transactions: ' .

                array_sum($tranAmountArray) .

                ' </p>';

        }



        if (is_numeric(abs($total)) && $total != 0) {

            $totalMonth = 1; //total months of income from Transactions

            $htmlMessage .= '<p>Total Months: ' . $totalMonth . ' </p>';

            $monthlyIncome = abs($total) / $totalMonth; //the average income of a period of days

            $htmlMessage .=

                '<p>Monthly Income (total/months): ' . $monthlyIncome . ' </p>';

            $approvalAmount = ($monthlyIncome * 30) / 100; //approval is based on 40% of monthly average income -- changed to 30% - RC

            $htmlMessage .=

                '<p>Approval Amount (Monthly Income x 30/100) : ' .

                $approvalAmount .

                ' </p>';

            $approvalAmount = ceil($approvalAmount / 10) * 10; //rounds approval up, to the nearest 10

            $htmlMessage .=

                '<p>Final Approval Amount Nearest to 10 : ' .

                $approvalAmount .

                ' </p>';

        } else {

            //$total is not numeric OR $total = 0

            $approvalAmount = 0;

        }



        if (count($tranAmountArray) < 2) { //changed to 2 transactions -- RC

            $tranCount = count($tranAmountArray);

            $htmlMessage .=

                '<p>Number of transactions: ' .

                $tranCount .

                " Customer has less than 2 transactions on record. Approval will be $ 0 on Zoho.</p>";

        }



        // searching to see if customer has current lease for this particular deal

        $access_token_crm = getZohoCrmAccessToken2($con);

        $url = 'https://www.zohoapis.com/crm/v2/Deals/' . $id;

        $searchDeal = curlCallGetReq2($access_token_crm, $url);

        $cynergiStatus = $searchDeal['data'][0]['CynergiStatus'];



        if ($cynergiStatus == 'Current Lease') {

            $approvalAmount = '';

        }



        // Send Email

        

        //setting headers to send HTML - RC

        $headers[] = 'MIME-Version: 1.0';

        $headers[] = 'Content-type: text/html; charset=UTF-8';

        

        $headers[] = 'To: Admin <admin@mypayvantage.com>';

        $headers[] = 'From: Shopify APP <support@mypayvantage.com>';

        

        mail("admin@mypayvantage.com","New Shopify Deal", $htmlMessage, implode("\r\n", $headers) ); // using PHP mail function - RC

    }



    /**********************

     *** Helper methods ***

     **********************/



    /**

     * Checks constant array of transactions conditions and

     * returns True or False depending if it matches any

     * condition.

     *

     * @param array $categories | Array of categories of the

     * transaction.

     * @param number $idx | Index of the specific condition

     * to match

     * @return boolean

     **/

    private function matchesTransactionCondition($categories, $idx = null)

    {

        $result = false;



        // Check for specific index conditions.

        if (isset($idx)) {

            if (array_key_exists(1, $categories)) {

                $result =

                    PlaidConsts::TRANSACTIONS_CONDITIONS[$idx][0] ==

                        $categories[0] &&

                    PlaidConsts::TRANSACTIONS_CONDITIONS[$idx][1] ==

                        $categories[1];

            } else {

                $result =

                    PlaidConsts::TRANSACTIONS_CONDITIONS[$idx][0] ==

                    $categories[0];

            }

        } else {

            // Matches both conditions on any index of the constants list.

            $result = in_array(

                array_slice($categories, 0, 2),

                PlaidConsts::TRANSACTIONS_CONDITIONS

            );

        }



        return $result;

    }



    /**

     * Returns if amount is from a valid Transaction

     * to take into account.

     *

     * @param number $amount

     * @return boolean

     **/

    private function isValidTransaction($amount)

    {

        return abs($amount) >

            PlaidConsts::MINIMUM_TRANSACTION_POSITIVE_AMOUNT && $amount < 0;

    }



    /**

     * Helper method to sort transactions.

     **/

    private static function compareByTimeStamp($time1, $time2)

    {

        if (strtotime($time1) < strtotime($time2)) {

            return 1;

        } elseif (strtotime($time1) > strtotime($time2)) {

            return -1;

        } else {

            return 0;

        }

    }

}

