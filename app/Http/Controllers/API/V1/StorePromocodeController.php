<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Constants\ResponseMessage;

use App\Actions\CreatePromoCode,
    App\Actions\GenrerateScanePromocodeToken,
    App\Actions\AddUserPromocodeStamp;

use App\StorePromocode;

use Carbon\Carbon;

use App\Http\Requests\CreateStorePromocodeRequest,
    App\Http\Requests\DeleteStorePromocodeRequest,
    App\Http\Requests\StorePromocodeListRequest,
    App\Http\Requests\PromocodeValidateRequest,
    App\Http\Requests\PromocodeTokenValidateRequest;

class StorePromocodeController extends Controller
{
    /*
		Add Edit Promocode For Store
    */
    public function AddEditpromocode(CreateStorePromocodeRequest $request,CreatePromoCode $createPromoCode){
        $input = $request->all();
        $response = $createPromoCode->execute($input);
        return response()->success(ResponseMessage::MERCHANT_STORE_REGISTER_SUCCESS,replace_null_with_empty_string($response));
    }

    /*
		Delete Promocode For Store
    */
    public function Deletepromocode(DeleteStorePromocodeRequest $request){

        StorePromocode::where('id',$request->promocode_id)->delete();
        return response()->success(ResponseMessage::COMMON_MESSAGE);
    }

    /*
		Promocode Listing Api
    */
    public function promocodeList(StorePromocodeListRequest $request){
        $Date = Carbon::now();
        $DateTime = $Date->toDateTimeString();

        $store = StorePromocode::where('store_id',$request->store_id)
                ->where('offer_valid','>=',$DateTime)
                ->paginate(50)->toArray();
        $store_data = replace_null_with_empty_string($store['data']);
        $total_record = $store['total'];
        $total_page = $store['last_page'];

        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$store_data,$total_record,$total_page );
    }

    /*
		Generate Unique Token For Collact Stamp And Redeem
    */
    public function GeneratePromocodeToken(PromocodeValidateRequest $request,GenrerateScanePromocodeToken $promoCodeToken){
        $input = $request->all();

        $response = $promoCodeToken->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($response));
    }

    /*
		Validate Unique token and collact stamp and points
    */
    public function ValidatePromocodeToken(PromocodeTokenValidateRequest $request,AddUserPromocodeStamp $AddUserPromocodeStamp){
        $input = $request->all();

        $response = $AddUserPromocodeStamp->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($response));
    }


}
