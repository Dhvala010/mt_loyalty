<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreCoupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'store_id',
        'title',
        'amount',
        'offer_valid'
    ];

    public function store(){
        return $this->belongsTo(Store::class,'store_id', 'id');
    }
}
