<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class StoreOffer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'store_id',
        'title',
        'count',
        'offer_valid'
    ];

}
