<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\ResponseMessage;

use App\Http\Requests\CheckStoreRewardId,
    App\Http\Requests\AddEditStoreRewardRequest;

use App\Actions\AddEditStoreReward;

use App\Store,
    App\StoreReward;

class StoreRewardController extends Controller
{
    public function AddEditStoreReward(AddEditStoreRewardRequest $request,AddEditStoreReward $AddEditStoreOffer){
        $input = $request->all();

        $result = $AddEditStoreOffer->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($result));
    }

    public function DeleteStoreReward(CheckStoreRewardId $request){
        StoreReward::where('id',$request->store_reward_id)->delete();
        return response()->success(ResponseMessage::COMMON_MESSAGE);
    }

    public function StoreRewardDetail(CheckStoreRewardId $request){
        $StoreOffer = StoreReward::find($request->store_reward_id);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($StoreOffer));
    }

    public function StoreRewardList(Request $request){
        $offset = $request->offset ? $request->offset : 10;

        $store = Store::whereIn('id', function($query) {
                    $query->select('store_id')
                    ->from('user_point_collects');
                })->with(["store_reward"]);

        $store = $store->paginate($offset)->toArray();
        $store_data = replace_null_with_empty_string($store['data']);
        $total_record = $store['total'];
        $total_page = $store['last_page'];

        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$store_data,$total_record,$total_page );
    }
}
