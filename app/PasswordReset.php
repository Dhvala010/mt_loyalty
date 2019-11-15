<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    const UPDATED_AT = null;

    public $primaryKey = 'email';

    protected $fillable = [
        'email', 'token'
    ];
}
