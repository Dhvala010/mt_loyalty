<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\CreateMerchantStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\ResponseMessage;

use Illuminate\Support\Facades\Auth;
use App\Store,
    App\StoreOffer,
    App\GenerateRedeemtoken,
    App\StoreReward;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Actions\RedeemStoreOffer;

use App\Http\Requests\MerchantStoreRegiserRequest,
    App\Http\Requests\DeleteMerchentStoreRequest,
    App\Http\Requests\StoreDetailRequest,
    App\Http\Requests\GenerateRedeemtokenRequest,
    App\Http\Requests\ValidateUserReddemTokenRequest;

use Illuminate\Support\Facades\DB;
use Str;


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

        $input = $request->all();
        $offset = $request->offset ? $request->offset : 10;
        $store = Store::query();

        if(!empty($input["longitude"]) && !empty($input["longitude"]))
        {
            $max_distance = 5;
            $lat = $input["latitude"];
            $lng = $input["longitude"];
            $offset = 100000;

            $distance = "( ( ( ACOS( SIN((" . $lat . " * PI() / 180)) * SIN((latitude * PI() / 180)) + COS((" . $lat . " * PI() / 180)) * COS((latitude * PI() / 180)) * COS( ( (" . $lng . " - longitude) * PI() / 180) ) )) * 180 / PI()) * 60 * 1.1515 * 1.609344)";
            $store = $store->whereRaw("{$distance} < ?", $max_distance)->orderBy(DB::raw($distance));
        }

        if (!empty($input["country"])) {
            $store = $store->where("country_code", $input["country"]);
        }

        $store = $store->paginate($offset)->toArray();
        $store_data = replace_null_with_empty_string($store['data']);
        $total_record = $store['total'];
        $total_page = $store['last_page'];

        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$store_data,$total_record,$total_page );
    }

    public function RewardStoreListing(Request $request){
        $input = $request->all();
        $offset = $request->offset ? $request->offset : 10;

        $store = Store::whereIn('id', function($query) {
                    $query->select('store_id')
                    ->from('user_point_collects')
                    ->whereColumn('store_id', 'stores.id');
                })->with(["store_reward"]);

        $store = $store->paginate($offset)->toArray();
        $store_data = replace_null_with_empty_string($store['data']);
        $total_record = $store['total'];
        $total_page = $store['last_page'];

        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$store_data,$total_record,$total_page );

    }


    public function getStoreDetails(StoreDetailRequest $request){
        $store = Store::where('id',$request->storeId)
                ->with(['store_offer','store_promocode','store_reward'])
                ->first();
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($store));
    }
    public function generateRedeemtoken(GenerateRedeemtokenRequest $request){
         $input = $request->all();
         $user = Auth::user();
         $input['unique_token'] = Str::random(12);
         $input['user_id'] = $user->id;
         $redeemtoken = GenerateRedeemtoken::create($input);
         return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($redeemtoken));


    }
    public function valid_get_redeem(ValidateUserReddemTokenRequest $request,RedeemStoreOffer $RedeemStoreOffer){
        $input = $request->all();

        $unique_token = $input['unique_token'];
        $user_redeem = GenerateRedeemtoken::where('unique_token', $unique_token)->first();
        $store_detail = Store::find($user_redeem->store_id);
        $offer_detail = StoreOffer::find($user_redeem->offer_id);
        $store_reward = StoreReward::find($user_redeem->reward_id);

        if($offer_detail && $store_detail->stamp_count < $offer_detail->count && $user_redeem->type == "stamp"){
            throw new ModelNotFoundException(ResponseMessage::NOT_AUTHORIZE_REDEEM_OFFER);
        }
        if($store_reward && $store_detail->point_count < $store_reward->count && $user_redeem->type == "point"){
            throw new ModelNotFoundException(ResponseMessage::NOT_AUTHORIZE_REDEEM_OFFER);
        }

        $data = $user_redeem->toArray();
        $response = $RedeemStoreOffer->execute($data,$store_detail,$offer_detail,$store_reward);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($response));
   }
}
