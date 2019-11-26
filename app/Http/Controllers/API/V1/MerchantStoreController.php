<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\CreateMerchantStore;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\ResponseMessage;

use App\Store;

use App\Http\Requests\MerchantStoreRegiserRequest;


class MerchantStoreController extends Controller
{
    public function register_merchant_store(MerchantStoreRegiserRequest $request,CreateMerchantStore $createMerchantStore){
    	$input = $request->all();
       	$image = $request->file('image') ?? '';
       	if(!empty($image)){
          $imagename = ImageUpload($image,'store_image');
          $input['image'] = $imagename;
        }
        $response = $createMerchantStore->execute($input);
        $store = Store::find($response->id);
        return response()->success(ResponseMessage::MERCHANT_STORE_REGISTER_SUCCESS,replace_null_with_empty_string($store));
    }
}
