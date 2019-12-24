<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreOffer extends Model
{
    protected $fillable = [
        'store_id',
        'title',
        'count',
        'offer_valid'
    ];

}
