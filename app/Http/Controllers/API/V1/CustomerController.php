<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\CreateMerchantStore;
use App\Actions\CreatePromoCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\ResponseMessage;

use Illuminate\Support\Facades\Auth;
use App\Store;
use App\User;
use App\Http\Requests\MerchantStoreRegiserRequest;
use App\Http\Requests\DeleteMerchentStoreRequest;
use App\Http\Requests\CreateStorePromocodeRequest;

use DB;
use Validator;
use Helper;
class CustomerController extends Controller
{
    public function listWallet(User $user, Request $request){
       return $user->wallets;
    }
    public function addWallet(User $user, Request $request){
        if(! $user->wallets->contains($request->store_id)){
            $user->wallets()->attach($request->store_id);
        }
        return response()->success(ResponseMessage::COMMON_MESSAGE,Helper::replace_null_with_empty_string($user));
    }
    public function removeWallet(User $user, Request $request){
        $user->wallets()->detach($request->store_id);
     }
}
