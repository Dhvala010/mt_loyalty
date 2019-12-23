<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneratePromocodeToken extends Model
{
    protected $fillable = [
        'promocode_id',
        'unique_token'
    ];

    public function promocode_detail(){
        return $this->belongsTo(StorePromocode::class,'promocode_id', 'id');
    }
}
