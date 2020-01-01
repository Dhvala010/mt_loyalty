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

    public function execute($data,$store_detail,$offer_detail){
        $user = Auth::user();

        $data['user_id'] = $user->id;
        $data['store_id'] =  $store_detail->id;
        $data['offer_id']= $offer_detail->id;
        $data['type']= 'stamp';
        $data['count'] = (int)$offer_detail->count;
        $StoreOffer = $this->UserRedeem->create($data);
        $StampManage = [
            "promocode_id" => $store_detail->store_promocode->id,
            "store_id" => $store_detail->id,
            "user_id" => $data['user_id'],
            "count" => - (int)$offer_detail->count,
            "is_redeem" => 1
        ];
        $StampManage = UserStampCollect::create($StampManage);
        return $StoreOffer;
    }
}
