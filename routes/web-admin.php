<?php
use App\Store;
use App\User;
use App\StorePromocode;
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

Route::bind('user', function ($value) {
    return User::find($value) ?? abort(404);
});

Auth::routes();
Route::group(['middleware' => 'auth','check-admin'], function () {

    Route::get('/', function() {
        return view('home');
    })->name('home');


    Route::post('user/GetDataById', 'UsersController@GetDataById');
    Route::get('get-merchant','StoreController@getmerchant');
    Route::get('get-store','OfferController@getstore');
    Route::get('user/ChangePassword', 'UsersController@ChangePassword');
    Route::post('user/ChangePasswords', 'UsersController@ChangePasswords');
    Route::resource('user', 'UsersController');
    Route::post('offer/GetDataById', 'OfferController@GetDataById');
    Route::bind('StorePromocode', function ($value) {
        return StorePromocode::find($value) ?? abort(404);
    });
    Route::resource('offer', 'OfferController');
    Route::post('store/GetDataById', 'StoreController@GetDataById');
    Route::bind('store', function ($value) {
        return Store::find($value) ?? abort(404);
    });
    Route::resource('store', 'StoreController');
    Route::resource('store_reward', 'StoreRewardController');
    

});
