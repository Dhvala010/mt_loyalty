<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'phone_number',
        'country_code',
        'email',
        'facebook_url',
        'location_address',
        'latitude',
        'longitude'
    ];
}