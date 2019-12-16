<?php

use Illuminate\Http\Request;
use App\User;
use App\Store;
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

Route::bind('user', function ($value) {
    return User::find($value) ?? abort(404);
});
Route::bind('store', function ($value) {
    return Store::find($value) ?? abort(404);
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'API\V1','prefix'=>'v1'], function () {

    /*Start User Management Routes*/
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('forgot_password', 'AuthController@forgotPassword');
    Route::post('configuration', 'AuthController@configuration');
    Route::post('check_social_login', 'AuthController@checkSocialLogin');
    /*End User Management Routes*/

    Route::group(['middleware' => ['auth:api']], function () {

        /*Start User Management Routes*/
        Route::post('user_detail', 'AuthController@UserDetail');
        Route::post('logout', 'AuthController@logout');
        Route::post('change_password', 'AuthController@changePassword');
        /*End User Management Routes*/

        /*Start Merchant Store Routes*/
        Route::post('add_edit_merchant_store', 'MerchantStoreController@AddEditMerchantStore');
        Route::post('delete_merchant_store', 'MerchantStoreController@DeleteMerchantStore');
        Route::post('merchant_store_listing', 'MerchantStoreController@MerchantStoreList');
        Route::post('create_promocode', 'MerchantStoreController@CreatePromocode');
        Route::GET('get_store_details', 'MerchantStoreController@getStoreDetails');
        /*End Merchant Store Routes*/

        /*Add store to wallet*/
        Route::post('user/{user}/list_store_wallet', 'CustomerController@listWallet');
        Route::post('user/{user}/add_store_wallet', 'CustomerController@addWallet');
        Route::post('user/{user}/remove_store_wallet', 'CustomerController@removeWallet');
        Route::post('store/{store}/detail', 'CustomerController@storeDetail');
    });
});
