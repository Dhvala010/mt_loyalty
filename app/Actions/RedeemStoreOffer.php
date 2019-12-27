<?php


namespace App\Actions;

use App\UserRedeem,
    App\UserStampCollect;

use Illuminate\Support\Facades\Auth;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class RedeemStoreOffer
{

    protected $UserRedeem;

    public function __construct(UserRedeem $UserRedeem)
    {
        $this->UserRedeem = $UserRedeem;
    }

    public function execute(array $data,$store_detail,$offer_detail){
        $user = Auth::user();
        $data['type'] = "stamp";
        $data['user_id'] = $user->id;
        $data['count'] = (int)$offer_detail->count;
        $StoreOffer = $this->UserRedeem->create($data);
        $StampManage = [
            "promocode_id" => $store_detail->store_promocode->id,
            "store_id" => $store_detail->id,
            "user_id" => $user->id,
            "count" => - (int)$offer_detail->count,
            "is_redeem" => 1
        ];
        $StampManage = UserStampCollect::create($StampManage);
        return $StoreOffer;
    }
}
