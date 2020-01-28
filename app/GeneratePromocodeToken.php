<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneratePromocodeToken extends Model
{
    protected $fillable = [
        'promocode_id',
        "type",
        "count",
        'unique_token',
        'coupon_id',
        'store_id'
    ];

    public function promocode_detail(){
        return $this->belongsTo(StorePromocode::class,'promocode_id', 'id');
    }

    public function coupon_detail(){
        return $this->belongsTo(StoreCoupon::class,'coupon_id', 'id');
    }
}
