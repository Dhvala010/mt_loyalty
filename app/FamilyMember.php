<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = [
        'from_user',
        "to_user",
        "created_by",
        "status"
    ];
}
