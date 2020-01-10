<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Constants\ResponseMessage;

use App\Http\Requests\AddEditStoreOfferRequest,
    App\Http\Requests\CheckStoreOfferId,
    App\Http\Requests\CheckStoreIdRequest;

use App\Actions\AddEditStoreOffer;

use App\StoreOffer;

class StoreOfferController extends Controller
{
    /*
		Add Edit Store Offer
    */
    public function AddEditOffer(AddEditStoreOfferRequest $request,AddEditStoreOffer $AddEditStoreOffer){
        $input = $request->all();
        $result = $AddEditStoreOffer->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($result));
    }

    /*
		Delete Store Offer
    */
    public function DeleteStoreOffer(CheckStoreOfferId $request){
        StoreOffer::where('id',$request->store_offer_id)->delete();
        return response()->success(ResponseMessage::COMMON_MESSAGE);
    }

    /*
		Store Offer Detail
    */
    public function StoreOfferDetail(CheckStoreOfferId $request){
        $StoreOffer = StoreOffer::find($request->store_offer_id);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($StoreOffer));
    }

    /*
		Store Offer Listing api with pagination
    */
    public function StoreOfferList(CheckStoreIdRequest $request){
        $offset = $request->offset ? $request->offset : 10;
        $StoreOffer = StoreOffer::where('store_id',$request->store_id);

        $StoreOffer = $StoreOffer->paginate($offset)->toArray();
        $store_offer_data = replace_null_with_empty_string($StoreOffer['data']);
        $total_record = $StoreOffer['total'];
        $total_page = $StoreOffer['last_page'];
        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$store_offer_data,$total_record,$total_page );
    }
}
