<?php

use Illuminate\Http\Request;

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
Route::group(['middleware' => ['role'], 'roles' => ['client']], function () {
    Route::post('/user/register', 'API\UserController@register')->name('user.register');
    Route::post('/filter-transactions', 'API\FilterController@filter_transactions');
    Route::patch('/blocked-transaction', 'API\TransactionController@blocked_transaction');
    Route::patch('/accepted-transaction', 'API\TransactionController@accepted_transaction');
    Route::patch('/cancel-transaction', 'API\TransactionController@cancelled_transaction');

});
//Route::get('{path}','HomeController@index')->where('path','([A-z\d-\/_.]+)?');
//admin , client
Route::group([
    'middleware' => ['role'],
    'roles' => ['client', 'admin']
], function () {
    Route::patch('/receiver-transaction', 'API\MembersController@receiver_transaction');
    Route::get('/receiver-transaction', 'API\MembersController@receivertransaction');
    Route::post('/create-transaction', 'API\TransactionController@create_transaction');
    Route::post('/find-transaction/{code}', 'API\TransactionController@show');
    Route::post('/show-transaction/{code}', 'API\TransactionController@showTransaction');
    Route::get('/show-messages/{code}', 'API\ChatController@showMessage');
    Route::apiResource('/country', 'API\CountryController');
    Route::apiResource('/currency', 'API\CurrencyController');
    Route::apiResource('/message', 'API\ChatController');
    Route::get('/transaction', 'API\TransactionController@create');
    Route::post('/image-transaction/{code}', 'API\TransactionController@upload_images');
    Route::get('/show-images/{code}', 'API\TransactionController@show_images');
    Route::post('/delete-image', 'API\TransactionController@delete_image');
    Route::get('/member/{code}', 'API\MembersController@show');
    Route::get('/findBeneficiary', 'API\BeneficiaryController@search');
    Route::get('/beneficiary/{uuid}', 'API\BeneficiaryController@show');
    Route::get('/info-member', 'API\MembersController@info_member');
});

//admin
Route::group([
    'middleware' => ['role'],
    'roles' => ['admin']
], function () {
    Route::patch('/receiver-transaction', 'API\MembersController@receiver_transaction');
    Route::post('/user/register', 'API\UserController@register')->name('user.register');
    Route::get('/member', 'API\MembersController@index');
    Route::post('/block-member', 'API\MembersController@blocked_member');
    Route::post('/active-member', 'API\MembersController@active_member');
    Route::post('/hold-member', 'API\MembersController@hold_member');
    Route::patch('/profile/{code}', 'API\MembersController@update');
//    Route::post('/setting-country', 'API\SettingController@addCountry');
    Route::get('/setting-currency', 'API\SettingController@allCurrency');
    Route::get('/setting-country', 'API\SettingController@allCountry');
    Route::patch('/setting-currency', 'API\SettingController@update_currency');
    Route::patch('/setting-country', 'API\SettingController@update_country');
    Route::patch('/setting-currency_current', 'API\SettingController@update_country');
    Route::delete('/setting-currency/{id}', 'API\SettingController@deleteCurrency');
    Route::delete('/setting-country/{id}', 'API\SettingController@deleteCountry');

    //wallet
    Route::post('/wallet', 'API\WalletController@store');
    Route::delete('/wallet', 'API\WalletController@destroy');

    // commission
    Route::patch('/commission', 'API\MembersController@updateCommission');

    //settings
    Route::patch('/setting-commission', 'API\SettingController@commission_update');
    Route::get('/setting/{key}', 'API\SettingController@show');
    Route::get('/setting-header', 'API\SettingController@getDataHeader');
    Route::patch('/setting-header', 'API\SettingController@updateHeaderData');
});

