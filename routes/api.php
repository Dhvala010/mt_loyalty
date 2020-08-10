<?php

use Illuminate\Http\Request;
use App\User;
use App\Store;
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
    Route::post('assign_role_existing_user', 'AuthController@RoleAssign');
    Route::post('login', 'AuthController@login');
    Route::post('forgot_password', 'AuthController@forgotPassword');
    Route::post('configuration', 'AuthController@configuration');
    Route::post('check_social_login', 'AuthController@checkSocialLogin');
    Route::post('local_notification','AuthController@localNotification');
    /*End User Management Routes*/

    Route::group(['middleware' => ['auth:api']], function () {

        Route::post('add_feedback', 'AuthController@AddFeedBack');

        /*Start User Management Routes*/
        Route::post('user_detail', 'AuthController@UserDetail');
        Route::post('logout', 'AuthController@logout');
        Route::post('change_password', 'AuthController@changePassword');
        Route::post('update_profile', 'AuthController@UpdateProfile');
        Route::post('add_family_member', 'AuthController@Addfamilymember');
        /*End User Management Routes*/

        /*Start Merchant Store Routes*/
        Route::post('add_edit_merchant_store', 'MerchantStoreController@AddEditMerchantStore');
        Route::post('delete_merchant_store', 'MerchantStoreController@DeleteMerchantStore');
        Route::post('merchant_store_listing', 'MerchantStoreController@MerchantStoreList');
        Route::POST('get_store_details', 'MerchantStoreController@getStoreDetails');
        /*End Merchant Store Routes*/

        /*Start Merchant Store offer Routes*/
        Route::post('add_edit_store_offer', 'StoreOfferController@AddEditOffer');
        Route::post('delete_store_offer', 'StoreOfferController@DeleteStoreOffer');
        Route::post('store_offer_detail', 'StoreOfferController@StoreOfferDetail');
        Route::post('store_offer_listing', 'StoreOfferController@StoreOfferList');
        /*End Merchant Store offer Routes*/

        /*Start Generate Unique Token and Validate Token Routes*/
        // Old
        Route::post('generate_promocode_token', 'UniqueTokenController@GeneratePromocodeToken');
        Route::post('validate_promocode_token', 'UniqueTokenController@ValidatePromocodeToken');
        // New
        Route::post('generate_unique_token', 'UniqueTokenController@GeneratePromocodeToken');
        Route::post('validate_unique_token', 'UniqueTokenController@ValidatePromocodeToken');
        Route::post('generate_redeem', 'MerchantStoreController@generateRedeemtoken');
        Route::post('valid_get_redeem', 'MerchantStoreController@valid_get_redeem');
        Route::post('user_point_collect', 'MerchantStoreController@userPointCollect');
        /*End Generate Unique Token and Validate Token Routes*/


        /*Add store to wallet*/
        Route::post('user/{user}/list_store_wallet', 'CustomerController@listWallet');
        Route::post('user/{user}/add_store_wallet', 'CustomerController@addWallet');
        Route::post('user/{user}/remove_store_wallet', 'CustomerController@removeWallet');
        Route::post('store/{store}/detail', 'CustomerController@storeDetail');
        Route::post('customer/coupon_list','CustomerController@couponList');
        Route::post('customer/store_coupon_listing', 'CustomerController@StoreCouponListing');
        /*End Store to wallet*/

         /*Add store to wallet*/
         Route::post('family_member/request_send', 'FamilyMemberController@sendRequest');
         Route::post('family_member/update_request', 'FamilyMemberController@updateRequest');
         Route::post('family_member/listing', 'FamilyMemberController@MemberListing');
         Route::post('family_member/share_stamp', 'FamilyMemberController@shareStamp');
         Route::post('family_member/delete', 'FamilyMemberController@deletefamilymember');
         /*End Store to wallet*/

         /*Start Merchant Store reward Routes*/
        Route::post('add_edit_store_reward', 'StoreRewardController@AddEditStoreReward');
        Route::post('delete_store_reward', 'StoreRewardController@DeleteStoreReward');
        Route::post('store_reward_detail', 'StoreRewardController@StoreRewardDetail');
        Route::post('store_reward_listing', 'StoreRewardController@StoreRewardList');
        /*End Merchant Store reward Routes*/

         /*Start User Notification Routes*/
         Route::post('notification_listing', 'NotificationController@NotificationListing');
         Route::post('read_notification', 'NotificationController@ReadNotification');
         Route::post('delete_notification', 'NotificationController@DeleteNotification');
         /*End User Notification Routes*/

         /*Start User StoreCoupon Routes*/
         Route::post('coupon_listing', 'StoreCouponController@CouponListing');
         Route::post('add_edit_coupon', 'StoreCouponController@AddEditCoupon');
         Route::post('delete_coupon', 'StoreCouponController@DeleteStoreCoupon');
        /*End User StoreCoupon Routes*/
    });
});
