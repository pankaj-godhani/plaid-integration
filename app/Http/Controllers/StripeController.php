<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ZohoController;
use Stripe\StripeClient;

class StripeController extends Controller
{
    private $zohoController;

    public function __construct()
    {
        $this->zohoController = new ZohoController();
    }

    public function index(Request $request)
    {
        $amount = $this->calculateAmount($request->deal_id, $request->total);
        return view('gateway.payment', [
            'deal_id' => $request->deal_id,
            'amount' => number_format((float) $amount / 100, 2, '.', ''),
            'total' => $request->total,
            'products' => $request->products,
        ]);
    }

    /**
     * Creates the charge by calling the Stripe API and
     * sends the card information to Zoho.
     */
    public function chargeCard(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|min:15',
            'expYear' => 'required|size:4',
            'expMonth' => 'required|size:2|lte:12',
            'cvc' => 'required|min:3',
        ]);

        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

        $deal = $this->zohoController->getDeal($request->deal_id);
        $email = $deal['Email'];
        $approvalAmount = $deal['Progressive_Amount'];
        $total = $request->total / 100;

        $amount = $this->calculateAmount($request->deal_id, $request->total);

        // Check if customer exists or create it.
        $customer = $stripe->customers->create([
            'email' => $email,
        ]);

        try {
            $token = $stripe->tokens->create([
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->expMonth,
                    'exp_year' => $request->expYear,
                    'cvc' => $request->cvv,
                ],
            ]);
        } catch (Exception $e) {
            return response($e->message, 400);
        }

        if (!empty($token)) {
            $card = $stripe->customers->createSource($customer['id'], [
                'source' => $token['id'],
            ]);
        }

        $charge = $stripe->charges->create([
            'amount' => (int) $amount,
            'currency' => 'usd',
            'customer' => $customer['id'],
            'description' => 'One time charge for service.',
            'metadata' => [],
        ]);

        $this->zohoController->updateDealCardInfo(
            $request->deal_id,
            $request->number,
            $request->expMonth . '/' . $request->expYear,
            $request->cvc
        );

        return $charge;
    }

    /**
     * Calculates the Amount to pay based on the
     * deal information.
     */
    private function calculateAmount($deal_id, $total)
    {
        $deal = $this->zohoController->getDeal($deal_id);

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
            $amount = ($total * 2) / $interval;
        } else {
            $amount = ($total * 2.2) / $interval;
        }

        return round($amount, 2) + 1000;
    }

    public function success(Request $request)
    {
        $dealId = $request->deal_id;
        $total = (int) $request->total / 100;
        $products = json_decode(
            htmlspecialchars_decode(str_replace('_', ' ', $request->products))
        );

        $zohoController = new ZohoController();
        $this->zohoController->updateDealTotalAndDevice(
            $dealId,
            $total,
            implode(', ', $products)
        );
        return view('gateway.success', ['deal_id' => $dealId]);
    }
}
