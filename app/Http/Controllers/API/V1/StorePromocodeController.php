<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Constants\ResponseMessage;

use App\Actions\CreatePromoCode,
    App\Actions\GenrerateScanePromocodeToken,
    App\Actions\AddUserPromocodeStamp,
    App\Actions\RedeemStoreOffer;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\StorePromocode,
    App\Store,
    App\StoreOffer;

use Carbon\Carbon,
    Auth;

use App\Http\Requests\CreateStorePromocodeRequest,
    App\Http\Requests\DeleteStorePromocodeRequest,
    App\Http\Requests\StorePromocodeListRequest,
    App\Http\Requests\PromocodeValidateRequest,
    App\Http\Requests\PromocodeTokenValidateRequest,
    App\Http\Requests\ValidateRedeemRequest;

class StorePromocodeController extends Controller
{
    public function AddEditpromocode(CreateStorePromocodeRequest $request,CreatePromoCode $createPromoCode){
        $input = $request->all();
        $response = $createPromoCode->execute($input);
        return response()->success(ResponseMessage::MERCHANT_STORE_REGISTER_SUCCESS,replace_null_with_empty_string($response));
    }

    public function Deletepromocode(DeleteStorePromocodeRequest $request){

        StorePromocode::where('id',$request->promocode_id)->delete();
        return response()->success(ResponseMessage::COMMON_MESSAGE);
    }

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

    public function GeneratePromocodeToken(PromocodeValidateRequest $request,GenrerateScanePromocodeToken $promoCodeToken){
        $input = $request->all();

        $response = $promoCodeToken->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($response));
    }

    public function ValidatePromocodeToken(PromocodeTokenValidateRequest $request,AddUserPromocodeStamp $AddUserPromocodeStamp){
        $input = $request->all();

        $response = $AddUserPromocodeStamp->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($response));
    }
    public function getredeem(ValidateRedeemRequest $request,RedeemStoreOffer $RedeemStoreOffer){
        $input = $request->all();
        $store_detail = Store::find($input['store_id']);
        $offer_detail = StoreOffer::find($input['offer_id']);

        if($store_detail->stamp_count <= $offer_detail->count){
            throw new ModelNotFoundException(ResponseMessage::NOT_AUTHORIZE_REDEEM_OFFER);
        }
        $response = $RedeemStoreOffer->execute($input,$store_detail,$offer_detail);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($response));
    } 
    
}
