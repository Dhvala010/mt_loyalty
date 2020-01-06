<?php


namespace App\Actions;

use App\Macros\Http\Response;
use App\UserStampCollect,
    App\Store,
    App\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Constants\ResponseMessage;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SharedStamp
{

    protected $UserStampCollect;
    public function __construct(UserStampCollect $UserStampCollect)
    {
        $this->UserStampCollect = $UserStampCollect;
    }

    public function execute(array $data){
        $user_id = Auth::user()->id;
        $store_id = $data['store_id'];
        $to_user = $data['to_user'];
        $count = $data['count'];

        $Store = Store::find($store_id);
        $promocode_id = $Store->store_promocode->id;

        $to_user_detail = User::where('id',$to_user)->first();
        if(!$to_user_detail->wallets->contains($store_id)){
            $to_user_detail->wallets()->attach($store_id);
        }

        if($Store->stamp_count < $count){
            throw new ModelNotFoundException(ResponseMessage::SHARE_STAMP_ERROR);
        }

        $stemp_from_data = [
            "promocode_id" => $promocode_id,
            "store_id" => $store_id,
            "user_id" => $user_id,
            "count" => - (int)$count,
            "is_shared" => 1,
            "shared_user" => $to_user_detail->id,
        ];

        $stemp_to_data = [
            "promocode_id" => $promocode_id,
            "store_id" => $store_id,
            "user_id" => $to_user_detail->id,
            "count" => (int)$count,
            "is_shared" => 1,
            "shared_user" => $user_id,
        ];

        $this->UserStampCollect->create($stemp_from_data);
        $this->UserStampCollect->create($stemp_to_data);
        return $Store;
    }
}
