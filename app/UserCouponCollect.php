<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCouponCollect extends Model
{
    protected $fillable = [
        'store_id',
        'coupon_id',
        'user_id',
        'count',
        'is_redeem'
    ];

    public function coupon_details()
    {
        return $this->belongsTo(StoreCoupon::class,'coupon_id','id');
    }
}
