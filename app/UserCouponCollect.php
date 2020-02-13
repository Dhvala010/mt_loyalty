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
}
