<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlaidController;

use App\Http\Controllers\StripeController;

use App\Http\Controllers\ZohoController;

use App\Http\Controllers\PostController;

use App\Http\Controllers\DealDeniedController;

/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/



Route::get('/', function () {

    return view('welcome');

});



Route::get('/lease-form', function () {

    return view('gateway.form');

});



Route::get('/plaid-check', [PlaidController::class, 'index'])->name('plaid');

Route::get('/initial-payment', [StripeController::class, 'index']);

Route::get('/initial-payment', [StripeController::class, 'index'])->name('payment');

Route::get('/success', [StripeController::class, 'success'])->name('success');

Route::get('/denied', [ZohoController::class, 'denied'])->name('denied');

Route::get('/deal-denied', [DealDeniedController::class, 'index'])->name('dealDenied');

Route::get('/display-data', [PostController::class, 'index'])->name('display');

