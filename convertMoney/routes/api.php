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
Route::get('/select-role', 'API\UserController@roles');
Route::get('/select-permission', 'API\UserController@permissions');

//admin , client
Route::group([
    'middleware' => ['role'],
    'roles' => ['client', 'admin']
], function () {

    Route::post('/filter-transactions-client', 'API\FilterController@filter_transactions_client');
    Route::patch('/receiver-transaction', 'API\MembersController@receiver_transaction');
    Route::get('/receiver-transaction', 'API\MembersController@receivertransaction');
    Route::post('/create-transaction', 'API\TransactionController@create_transaction');
    Route::post('/find-transaction/{code}', 'API\TransactionController@show');
    Route::post('/show-transaction/{code}', 'API\TransactionController@showTransaction');
    Route::get('/show-messages/{code}', 'API\ChatController@showMessage');
    Route::apiResource('/message', 'API\ChatController');
    Route::get('/transaction', 'API\TransactionController@create');
    Route::post('/image-transaction/{code}', 'API\TransactionController@upload_images');
    Route::get('/show-images/{code}', 'API\TransactionController@show_images');
    Route::post('/delete-image', 'API\TransactionController@delete_image');
    Route::get('/member/{code}', 'API\MembersController@show');
    Route::get('/findBeneficiary', 'API\BeneficiaryController@search');
    Route::get('/beneficiary/{uuid}', 'API\BeneficiaryController@show');
    Route::get('/info-member', 'API\MembersController@info_member');
    Route::get('/setting-header', 'API\SettingController@getDataHeader');
    Route::get('/currency', 'API\CurrencyController@index');
    Route::get('/country', 'API\CountryController@index');
});

//admin
Route::group([
    'middleware' => ['role'],
    'roles' => ['admin']
], function () {

    //transaction
    Route::post('/filter-transactions', 'API\FilterController@filter_transactions')->name('filter.transaction');
    Route::patch('/blocked-transaction', 'API\TransactionController@blocked_transaction')->name('block.transaction');
    Route::patch('/accepted-transaction', 'API\TransactionController@accepted_transaction')->name('accept.transaction');
    Route::patch('/cancel-transaction', 'API\TransactionController@cancelled_transaction')->name('cancel.transaction');

    //members
    Route::post('/user/register', 'API\UserController@register')->name('member.register');
    Route::get('/member', 'API\MembersController@index')->name('member.view');
    Route::post('/block-member', 'API\MembersController@blocked_member')->name('member.block');
    Route::post('/active-member', 'API\MembersController@active_member')->name('member.active');
    Route::post('/hold-member', 'API\MembersController@hold_member')->name('member.hold');
    Route::patch('/profile/{code}', 'API\MembersController@update')->name('profile.update');

    //users
    Route::get('/user', 'API\UserController@index')->name('user.view');

    //roles
    Route::get('/role', 'API\UserController@roles_index')->name('role.view');

    //permission
    Route::get('/permission/{id}', 'API\UserController@permission_show')->name('permission.view');
    Route::post('/permission', 'API\UserController@permission_store')->name('permission.store');

    //wallet
    Route::post('/wallet', 'API\WalletController@store')->name('wallet.store');
    Route::delete('/wallet', 'API\WalletController@destroy')->name('wallet.delete');

    // commission
    Route::patch('/commission', 'API\MembersController@updateCommission')->name('commission.update');

    //settings
    Route::patch('/setting-commission', 'API\SettingController@commission_update')->name('setting_commission_admin.update');
    Route::get('/setting/{key}', 'API\SettingController@show')->name('setting.view');
    Route::patch('/setting-header', 'API\SettingController@updateHeaderData')->name('setting_header.update');
    Route::get('/setting-currency', 'API\SettingController@allCurrency')->name('setting_currency.view');
    Route::get('/setting-country', 'API\SettingController@allCountry')->name('setting_country.view');
    Route::patch('/setting-currency', 'API\SettingController@update_currency')->name('setting_currency.update');
    Route::patch('/setting-country', 'API\SettingController@update_country')->name('setting_country.update');
    Route::patch('/setting-currency_current', 'API\SettingController@update_country')->name('setting_country_current.update');
    Route::delete('/setting-currency/{id}', 'API\SettingController@deleteCurrency')->name('setting_currency.delete');
    Route::delete('/setting-country/{id}', 'API\SettingController@deleteCountry')->name('setting_country.delete');
    Route::patch('/country/{id}', 'API\CountryController@update')->name('country.update');
    Route::post('/country', 'API\CountryController@store')->name('country.store');
    Route::patch('/currency/{id}', 'API\CurrencyController@update')->name('currency.update');
    Route::post('/currency', 'API\CurrencyController@store')->name('currency.store');


    //Statistics
    Route::get('/statistics', 'API\StatisticsController@statistics')->name('statistics.view');
});

