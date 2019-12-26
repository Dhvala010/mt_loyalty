<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StorePromocode extends Model
{
    protected $fillable = [
        'store_id',
        'title',
        'count',
        'unique_number',
        'offer_valid'
    ];

    public function store(){
        return $this->belongsTo(Store::class,'store_id', 'id');
    }
}
