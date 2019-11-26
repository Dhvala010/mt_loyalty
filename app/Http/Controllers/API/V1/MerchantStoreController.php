<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\CreateMerchantStore;
use App\Actions\CreatePromoCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\ResponseMessage;

use Illuminate\Support\Facades\Auth;
use App\Store;

use App\Http\Requests\MerchantStoreRegiserRequest;
use App\Http\Requests\DeleteMerchentStoreRequest;
use App\Http\Requests\CreateStorePromocodeRequest;


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

    public function MerchantStoreList(Request $request){

        $offset = $request->offset ? $request->offset : 10;
        $store = Store::paginate($offset)->toArray();
        $store_data = replace_null_with_empty_string($store['data']);

        $total_record = $store['total'];
        $total_page = $store['last_page'];

        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$store_data,$total_record,$total_page );
    }

    public function CreatePromocode(CreateStorePromocodeRequest $request,CreatePromoCode $createPromoCode){
        $user = Auth::user();
        $input = $request->all();

        $response = $createPromoCode->execute($input);
        return response()->success(ResponseMessage::MERCHANT_STORE_REGISTER_SUCCESS,replace_null_with_empty_string($response));
    }
}
