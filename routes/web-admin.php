<?php
use App\Store;
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

Auth::routes();
Route::group(['middleware' => 'auth','check-admin'], function () {
    
    Route::get('/', function() {
        return view('home');
    })->name('home');


    Route::post('user/GetDataById', 'UsersController@GetDataById');
    Route::get('get-merchant','StoreController@getmerchant');
    Route::get('user/ChangePassword', 'UsersController@ChangePassword');
    Route::post('user/ChangePasswords', 'UsersController@ChangePasswords');
    Route::resource('user', 'UsersController');
    Route::post('store/GetDataById', 'StoreController@GetDataById');
    Route::bind('store', function ($value) {
        return Store::find($value) ?? abort(404);
    });
    Route::resource('store', 'StoreController');

});
