<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreReward extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'store_id',
        'title',
        'description',
        'count',
        'offer_valid',

    ];
}
