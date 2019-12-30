<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenerateRedeemtoken extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'offer_id',
        'unique_token',
    ];
    

   

}
