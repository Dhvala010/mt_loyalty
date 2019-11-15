<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'title',
        'last_name',
        'email',
        'password',
        'role',
        'profile_picture',
        'is_aggree_terms'
    ];
}
