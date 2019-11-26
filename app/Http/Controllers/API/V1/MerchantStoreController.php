<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\CreateMerchantStore;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\ResponseMessage;

use Illuminate\Support\Facades\Auth;
use App\Store;

use App\Http\Requests\MerchantStoreRegiserRequest;
use App\Http\Requests\DeleteMerchentStoreRequest;


class MerchantStoreController extends Controller
{
    public function AddEditMerchantStore(MerchantStoreRegiserRequest $request,CreateMerchantStore $createMerchantStore){
        $user = Auth::user();
        $input = $request->all();
        $image = $request->file('image') ?? '';
        $input['user_id'] = $user->id;
       	if(!empty($image)){
          $imagename = ImageUpload($image,'store_image');
          $input['image'] = $imagename;
        }
        $response = $createMerchantStore->execute($input);
        $store = Store::find($response->id);
        return response()->success(ResponseMessage::MERCHANT_STORE_REGISTER_SUCCESS,replace_null_with_empty_string($store));
    }

    public function DeleteMerchantStore(DeleteMerchentStoreRequest $request){
        $store = Store::find($request->store_id);
        $store->delete();
        return response()->success(ResponseMessage::MERCHANT_STORE_DELETE);
    }
}
