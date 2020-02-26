<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\ResponseMessage;

use App\Http\Requests\CheckStoreIdRequest,
    App\Http\Requests\AddEditStoreCouponRequest,
    App\Http\Requests\CheckStoreCouponId;

use App\Actions\AddEditStoreCoupon;

use App\StoreCoupon,
    App\Store;

use Illuminate\Support\Facades\Auth;

class StoreCouponController extends Controller
{
    /*
		Coupon Listing
    */
    public function CouponListing(CheckStoreIdRequest $request){
        $offset = $request->offset ? $request->offset : 10;
        $StoreCoupon = StoreCoupon::where('store_id',$request->store_id);

        $StoreCoupon = $StoreCoupon->paginate($offset)->toArray();
        $store_coupon_data = replace_null_with_empty_string($StoreCoupon['data']);
        $total_record = $StoreCoupon['total'];
        $total_page = $StoreCoupon['last_page'];
        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$store_coupon_data,$total_record,$total_page );
    }



    /*
		Add Edit Store Coupon
    */
    public function AddEditCoupon(AddEditStoreCouponRequest $request,AddEditStoreCoupon $AddEditStoreCoupon){
        $input = $request->all();
        $result = $AddEditStoreCoupon->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($result));
    }

    /*
		Delete Store Offer
    */
    public function DeleteStoreCoupon(CheckStoreCouponId $request){
        StoreCoupon::where('id',$request->store_coupon_id)->delete();
        return response()->success(ResponseMessage::COMMON_MESSAGE);
    }

}
