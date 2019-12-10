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

use DB;
use Validator;
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
        $rules = array(
            'country' => "numeric",
            'latitude'   => "numeric",
            'longitude'  => 'numeric',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "msg" => $validator->errors()->first(), "data" => (object) []);
            return response($arr);
        } else {

            $store = Store::orderBy('title','asc');

            if($request->has('latitude') && $request->has('longitude'))
            {

            $max_distance = 5;
            $lat = $input["latitude"];
            $lng = $input["longitude"];

            $distance = "( ( ( ACOS( SIN((" . $lat . " * PI() / 180)) * SIN((latitude * PI() / 180)) + COS((" . $lat . " * PI() / 180)) * COS((latitude * PI() / 180)) * COS( ( (" . $lng . " - longitude) * PI() / 180) ) )) * 180 / PI()) * 60 * 1.1515 * 1.609344)";

            $store = DB::table('stores')->select(['id','title','description','phone_number','country_code','email', 'latitude', 'longitude', DB::raw($distance . ' AS distance')])
                ->whereRaw("{$distance} < ?", $max_distance)
                ->orderBy(DB::raw($distance));

            }
            if ($request->has('country')) {
                 $store = $store->where("country_code", $input["country"]);
            }

            $store = $store->paginate($offset)->toArray();
            $store_data = replace_null_with_empty_string($store['data']);
            $total_record = $store['total'];
            $total_page = $store['last_page'];

            return response()->paginate(ResponseMessage::COMMON_MESSAGE,$store_data,$total_record,$total_page );
        }

    }
    public function CreatePromocode(CreateStorePromocodeRequest $request,CreatePromoCode $createPromoCode){
        $user = Auth::user();
        $input = $request->all();

        $response = $createPromoCode->execute($input);
        return response()->success(ResponseMessage::MERCHANT_STORE_REGISTER_SUCCESS,replace_null_with_empty_string($response));
    }
}
