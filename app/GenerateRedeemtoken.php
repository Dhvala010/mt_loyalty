<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenerateRedeemToken extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'offer_id',
        'reward_id',
        'coupon_id',
        'unique_token',
        'type',
    ];
}
