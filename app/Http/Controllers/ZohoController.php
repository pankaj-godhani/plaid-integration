<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Asciisd\Zoho\Facades\ZohoManager;
use zcrmsdk\crm\exception\ZCRMException;
use AylesSoftware\ZohoDesk\Facades\ZohoDesk;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ZohoController extends Controller
{
    private $description = 'Loan Application Submitted By Shopify Integration';

    public function insertDealRecord($data)
    {
        // Check Cynergi Status
        $status = $this->checkCynergiStatus($data['ssn']);

        if ($status) {
            try {
                $contactId = $this->getContactId($data['email']);
            } catch (ZCRMException $e) {
                // An exception will be catched if contact doesn't exist
                // previously. This is the Zoho SDK default behaviour.
                // We'll create a new contact and continue.
                $contactId = $this->createContact($data)
                    ->getData()
                    ->getEntityId();
            }

            // Creates the Deal record.
            try {
                $dealId = $this->createDeal($data, $contactId, $status)
                    ->getData()
                    ->getEntityId();
            } catch (ZCRMException $e) {
                dd($e);
            }

            return $dealId;
        }

        return null;
    }

    /**
     * TEST - Get contact records.
     */
    public function getRecords()
    {
        // we can now deals with leads module
        $lead = ZohoManager::useModule('Contacts')->searchRecordsByEmail(
            'oscar@team.northtwofive.com'
        );

        return response($lead, 200);
    }

    /**
     * Gets the Zoho contact ID of the provided email.
     */
    private function getContactId($email)
    {
        // Check if contact already exists...
        $existingContact = ZohoManager::useModule(
            'Contacts'
        )->searchRecordsByEmail($email);
        // Gets contact_id.
        return $existingContact[0]->getEntityId();
    }

    /**
     * Zoho create Contact.
     */
    private function createContact($data)
    {
        // Creates contact.
        $contacts = ZohoManager::useModule('Contacts');
        // Initiating a new empty instance of contacts.
        $record = $contacts->getRecordInstance();
        $record->setFieldValue('First_Name', $data['firstName']);
        $record->setFieldValue('Last_Name', $data['lastName']);
        $record->setFieldValue('Email', $data['email']);
        $record->setFieldValue('Phone', $data['phone']);
        // create the record into zoho crm then get the created instance data
        return $record->create();
    }

    /**
     * Creates the deal record in CRM.
     *
     * @param array $data
     * @param string $contactId
     * @param string $status
     * @return void
     */
    private function createDeal($data, $contactId, $status)
    {
        /***********************
         *** Formatting data ***
         ***********************/

        $employerAddress =
            $data['employerStreet'] .
            ', ' .
            $data['employerCity'] .
            ', ' .
            $data['employerState'] .
            ' ' .
            $data['employerZipcode'];
        $dob = Carbon::createFromFormat('d/m/Y', $data['dob'])->format('Y-m-d');
        $nextPayday = Carbon::createFromFormat(
            'm/d/Y',
            $data['nextPayday']
        )->format('Y-m-d');

        /*********************
         *** Create record ***
         *********************/

        // Creates deal.
        $deals = ZohoManager::useModule('Deals');
        // Initiating a new empty instance of deals.
        $record = $deals->getRecordInstance();

        // Fixed Shopify type
        $record->setFieldValue('Deal_Type', 'Shopify');

        $record->setFieldValue('Phone', $data['phone']);
        $record->setFieldValue('Contact_Name', $contactId);
        $record->setFieldValue('Email', $data['email']);
        $record->setFieldValue('Cynergi_Status', $status);
        $record->setFieldValue(
            'Deal_Name',
            'APP_' .
                $data['firstName'] .
                $data['lastName'] .
                '@' .
                $data['phone']
        );
        $record->setFieldValue('subject', '');
        $record->setFieldValue('Social_Security_Number', $data['ssn']);
        $record->setFieldValue('Date_Of_Birth', $dob);
        $record->setFieldValue('Stage', 'Loan Application');
        $record->setFieldValue(
            'Source_of_primary_Income',
            $data['sourceOfIncome']
        );
        $record->setFieldValue('Employer_Name', $data['employerName']);
        $record->setFieldValue('cf_employer_address', $employerAddress);
        $record->setFieldValue('Employer_Phone_No', $data['employerPhone']);
        $record->setFieldValue(
            'How_Often_Do_you_get_Paid',
            $data['paidFrequency']
        );
        $record->setFieldValue('Bank_Name', $data['bankName']);
        $record->setFieldValue('pay', $data['directDeposit']);
        $record->setFieldValue('Next_Payday', $nextPayday);
        $record->setFieldValue('Street_Adress', $data['street']);
        $record->setFieldValue('City', $data['city']);
        $record->setFieldValue('State', $data['state']);
        $record->setFieldValue('Zip', $data['zipcode']);
        $record->setFieldValue(
            'Employer_Street_Adress',
            $data['employerStreet']
        );
        $record->setFieldValue('Employer_City', $data['employerCity']);
        $record->setFieldValue('Employer_State', $data['employerState']);
        $record->setFieldValue('Employer_Zip', $data['employerZipcode']);

        return $record->create();
    }

    /**
     * Search CRM deal info.
     **/
    public function getDeal($dealId)
    {
        $deal = ZohoManager::useModule('Deals')
            ->getRecord($dealId)
            ->getData();
        return $deal;
    }

    /**
     * Search CRM deal info.
     **/
    public function getContact($contactId)
    {
        $contact = ZohoManager::useModule('Contacts')
            ->getRecord($contactId)
            ->getData();
        return $contact;
    }

    /**
     * Updates the approved amount in the deal info.
     *
     * @param number $dealId
     * @param number $approvalAmount
     * @return void
     * */
    public function updateDealApprovalAmount($dealId, $approvalAmount)
    {
        try {
            $deal = ZohoManager::useModule('Deals')->getRecord($dealId);
            $deal->setFieldValue(
                'Progressive_Amount',
                (string) $approvalAmount
            );
            $deal = $deal->update();
        } catch (ZCRMException $e) {
            dd($e);
        }
    }

    /**
     * Updates the total invoice amount and the device info in the deal.
     *
     * @param number $dealId
     * @param number $total
     * @param string $device
     * @return void
     * */
    public function updateDealTotalAndDevice($dealId, $total, $device)
    {
        try {
            $deal = ZohoManager::useModule('Deals')->getRecord($dealId);
            $deal->setFieldValue('Amount', (string) $total);
            $deal->setFieldValue('Phone_Name', $device);
            $deal = $deal->update();
        } catch (ZCRMException $e) {
            dd($e);
        }
    }

    /**
     * Updates the card information in the Deal.
     *
     * @param number $dealId
     * @param File $fileUrl
     * @return void
     * */
    public function updateDealCardInfo($dealId, $number, $exp, $cvc)
    {
        try {
            $deal = ZohoManager::useModule('Deals')->getRecord($dealId);
            $deal->setFieldValue('Card_Number', $number);
            $deal->setFieldValue('Expiration', $exp);
            $deal->setFieldValue('CVC', $cvc);
            $deal = $deal->update();
        } catch (ZCRMException $e) {
            dd($e);
        }
    }

    /**
     * Attaches PDF tot he deal.
     *
     * @param number $dealId
     * @param File $fileUrl
     * @return void
     * */
    public function uploadDealAttachment($dealId, $fileUrl)
    {
        try {
            $deal = ZohoManager::useModule('Deals')->getRecord($dealId);
            $deal->uploadAttachment(Storage::path($fileUrl));
        } catch (ZCRMException $e) {
            dd($e);
        }
    }

    /**
     * Returns CynergiStatus value if the contact has a valid
     * Cynergi Status for lease approval. False otherwise.
     *
     * @param string $ssn
     * @return string|boolean
     * */
    public function checkCynergiStatus($ssn)
    {
        try {
            // Look for contact coincidence.
            $contactQuery = ZohoManager::useModule('Contacts')
                ->where('Social_Security_Number', $ssn)
                ->search();
        } catch (ZCRMException $e) {
            // If no contact exists will return an exception.
            return 'None';
        }

        if (count($contactQuery)) {
            $status = $contactQuery[0]->getData()['Cynergi_Status'];

            if ($status == 'None' || $status == 'Paid Off' || $status == null) {
                return $status;
            }
        }

        return false;
    }

    /**
     * Returns the view to be displayed if the Cynergi
     * Status check returns a deny message.
     */
    public function denied()
    {
        return view('gateway.denied');
    }
}
