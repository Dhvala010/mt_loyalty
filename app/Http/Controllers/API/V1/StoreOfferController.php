<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\ResponseMessage;

use App\Http\Requests\AddEditStoreOfferRequest,
    App\Http\Requests\CheckStoreOfferId;

use App\Actions\AddEditStoreOffer;

use App\StoreOffer;

class StoreOfferController extends Controller
{
    public function AddEditOffer(AddEditStoreOfferRequest $request,AddEditStoreOffer $AddEditStoreOffer){
        $input = $request->all();
        $result = $AddEditStoreOffer->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($result));
    }

    public function DeleteStoreOffer(CheckStoreOfferId $request){
        StoreOffer::where('id',$request->store_offer_id)->delete();
        return response()->success(ResponseMessage::COMMON_MESSAGE);
    }

    public function StoreOfferDetail(CheckStoreOfferId $request){
        $StoreOffer = StoreOffer::find($request->storeId);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($StoreOffer));
    }

    public function StoreOfferList(Request $request){
        $offset = $request->offset ? $request->offset : 10;
        $StoreOffer = StoreOffer::query();

        $StoreOffer = $StoreOffer->paginate($offset)->toArray();
        $store_offer_data = replace_null_with_empty_string($StoreOffer['data']);
        $total_record = $StoreOffer['total'];
        $total_page = $StoreOffer['last_page'];
        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$store_offer_data,$total_record,$total_page );
    }
}
