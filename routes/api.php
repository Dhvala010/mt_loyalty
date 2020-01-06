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
        Route::post('update_profile', 'AuthController@UpdateProfile');
        Route::post('add_family_member', 'AuthController@Addfamilymember');
        Route::post('delete_family_member', 'AuthController@deletefamilymember');
        /*End User Management Routes*/

        /*Start Merchant Store Routes*/
        Route::post('add_edit_merchant_store', 'MerchantStoreController@AddEditMerchantStore');
        Route::post('delete_merchant_store', 'MerchantStoreController@DeleteMerchantStore');
        Route::post('merchant_store_listing', 'MerchantStoreController@MerchantStoreList');
        Route::POST('get_store_details', 'MerchantStoreController@getStoreDetails');
        Route::POST('reward_store_listing', 'MerchantStoreController@RewardStoreListing');
        /*End Merchant Store Routes*/

        /*Start Merchant Store offer Routes*/
        Route::post('add_edit_store_offer', 'StoreOfferController@AddEditOffer');
        Route::post('delete_store_offer', 'StoreOfferController@DeleteStoreOffer');
        Route::post('store_offer_detail', 'StoreOfferController@StoreOfferDetail');
        Route::post('store_offer_listing', 'StoreOfferController@StoreOfferList');
        /*End Merchant Store offer Routes*/

        /*Start Store Promocode Routes*/
        Route::post('add_edit_promocode', 'StorePromocodeController@AddEditpromocode');
        Route::post('delete_promocode', 'StorePromocodeController@Deletepromocode');
        Route::post('store_promocode_list', 'StorePromocodeController@promocodeList');
        Route::post('generate_promocode_token', 'StorePromocodeController@GeneratePromocodeToken');
        Route::post('validate_promocode_token', 'StorePromocodeController@ValidatePromocodeToken');
        Route::post('get_redeem', 'StorePromocodeController@getredeem');
        Route::post('generate_redeem', 'MerchantStoreController@generateRedeemtoken');
        Route::post('valid_get_redeem', 'MerchantStoreController@valid_get_redeem');
        Route::post('user_point_collect', 'MerchantStoreController@userPointCollect');
        /*End Store Promocode Routes*/


        /*Add store to wallet*/
        Route::post('user/{user}/list_store_wallet', 'CustomerController@listWallet');
        Route::post('user/{user}/add_store_wallet', 'CustomerController@addWallet');
        Route::post('user/{user}/remove_store_wallet', 'CustomerController@removeWallet');
        Route::post('store/{store}/detail', 'CustomerController@storeDetail');
        /*End Store to wallet*/

         /*Add store to wallet*/
         Route::post('family_member/request_send', 'FamilyMemberController@sendRequest');
         Route::post('family_member/update_request', 'FamilyMemberController@updateRequest');
         Route::post('family_member/listing', 'FamilyMemberController@MemberListing');
         Route::post('family_member/share_stamp', 'FamilyMemberController@shareStamp');
         /*End Store to wallet*/

         /*Start Merchant Store reward Routes*/
        Route::post('add_edit_store_reward', 'StoreRewardController@AddEditStoreReward');
        Route::post('delete_store_reward', 'StoreRewardController@DeleteStoreReward');
        Route::post('store_reward_detail', 'StoreRewardController@StoreRewardDetail');
        Route::post('store_reward_listing', 'StoreRewardController@StoreRewardList');
        /*End Merchant Store reward Routes*/

    });
});
