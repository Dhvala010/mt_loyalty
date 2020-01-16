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
        'description',
        'count',
        'offer_valid'
    ];


    public function store(){
        return $this->belongsTo(Store::class,'store_id', 'id');
    }
}
