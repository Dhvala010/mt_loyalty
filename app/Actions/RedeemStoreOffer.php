<?php


namespace App\Actions;

use App\UserRedeem,
    App\UserStampCollect,
    App\UserPointCollect,
    App\UserCouponCollect;

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

    public function execute($data,$store_detail,$offer_detail,$reward_detail,$coupon_detail){

        $data['user_id'] = $data['user_id'];
        $data['store_id'] =  $store_detail->id;
        $data['offer_id']=   $offer_detail ? $offer_detail->id : null;
        $data['reward_id']=   $reward_detail ? $reward_detail->id : null;
        $data['coupon_id']=   $coupon_detail ? $coupon_detail->id : null;

        $data['type']= $data['type'];
        if($data['type'] == "stamp"){
            $data['count'] = (int)$offer_detail->count;
            $StoreOffer = $this->UserRedeem->create($data);
        }elseif($data['type'] == "point"){
            $data['count'] = (int)$reward_detail->count;
            $StoreOffer = $this->UserRedeem->create($data);
        }else{
            $data['count'] = (int)$coupon_detail->amount;
            $StoreOffer = $this->UserRedeem->create($data);
        }

        $ManageCount = [
            "promocode_id" => $store_detail->store_promocode->id,
            "store_id" => $store_detail->id,
            "user_id" => $data['user_id'],
            "count" => - $data['count'],
            "amount" => - $data['count'],
            "is_redeem" => 1,
            'coupon_id' => $data['coupon_id']
        ];

        if($data['type'] == "stamp"){
            UserStampCollect::create($ManageCount);
        }
        if($data['type'] == "point"){
            UserPointCollect::create($ManageCount);
        }
        if($data['type'] == "coupon"){
            UserCouponCollect::create($ManageCount);
        }

        return $StoreOffer;
    }
}
