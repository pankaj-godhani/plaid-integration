<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/lease-form', 'ZohoController@leaseForm')->name('post_lease_form');
Route::post('/plaid-webhook', 'PlaidController@webhook')->name('plaid_webhook');
Route::get('/get-records', 'ZohoController@getRecords')->name('get_records');
Route::post('/charge-card', 'StripeController@chargeCard')->name('charge_card');

Route::post('/check-plaid-token', 'PlaidController@checkPlaidToken')->name(
    'plaid_token'
);
