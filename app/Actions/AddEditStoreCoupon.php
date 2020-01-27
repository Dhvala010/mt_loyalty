<?php


namespace App\Actions;

use App\StoreCoupon;

/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AddEditStoreCoupon
{

    protected $StoreCoupon;

    public function __construct(StoreCoupon $StoreCoupon)
    {
        $this->StoreCoupon = $StoreCoupon;
    }

    public function execute(array $data){
        if(!empty($data['store_coupon_id'])){
            $StoreCoupon = StoreCoupon::find($data['store_coupon_id']);
            $StoreCoupon->fill($data);
            $StoreCoupon->save();
        }else{
            $StoreCoupon = $this->StoreCoupon->create($data);
        }
        return $StoreCoupon;
    }
}
