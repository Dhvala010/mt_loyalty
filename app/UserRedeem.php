<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRedeem extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'offer_id',
        'reward_id',
        'type',
        'count'
    ];
}
