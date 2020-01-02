<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreReward extends Model
{
    protected $fillable = [
        'store_id',
        'title',
        'description',
        'count',
        'offer_valid',
        
    ];
}
