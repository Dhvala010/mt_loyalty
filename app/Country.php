<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'iso',
        'name',
        'nicename',
        'iso3',
        'numcode',
        'phonecode',
    ];


    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function getPhonecodeAttribute($value)
    {
        return "+" . $value;
    }
}
