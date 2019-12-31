<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPointCollect extends Model
{
    protected $fillable = [
        'promocode_id',
        'store_id',
        'user_id',
        'count',
        'is_redeem'
    ];
}
