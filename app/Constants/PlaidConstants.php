<?php

namespace App\Constants;

class PlaidConstants {
    const DAYS_AMOUNT_FOR_ASSET_REPORT = 60;
    const MAXIMUM_SOCIAL_SECURITY_AMOUNT_PER_MONTH = 3900;
    const MINIMUM_TRANSACTION_POSITIVE_AMOUNT = 100;
    // This array requires 2 categories on each index.
    const TRANSACTIONS_CONDITIONS = [
        // Checking for SSA/SSI deposits
        0 => [
            0 => 'Community',
            1 => 'Government Departments and Agencies',
        ],
        // Checking for 'Transfer' 'Payroll' deposits that aren't
        1 => [
            0 => 'Transfer',
            1 => 'Payroll',
        ],
        // Some Healthcare worker's Payroll Deposits are labelled 'Healthcare Services'
        2 => [
            0 => 'Healthcare',
            1 => 'Healthcare Services',
        ],
        3 => [
            0 => 'Service',
            1 => 'Security and Safety',
        ],
        4 => [
            0 => 'Shops',
            1 => 'Supermarkets and Groceries',
        ],
        5 => [
            0 => 'Service',
            1 => 'Telecommunication Services',
        ],
        6 => [
            0 => 'Service',
            1 => 'Food and Beverage',
        ],
        7 => [
            0 => 'Shops',
            1 => 'Discount Stores',
        ],
        // TEST: DELETE AFTER TESTING
        8 => [
            0 => 'Transfer',
            1 => 'Credit',
        ],
        9 => [
            0 => "Food and Drink",
            1 => "Restaurants"
        ],
    ];
}