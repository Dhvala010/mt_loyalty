<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserNotification extends Model
{
    use SoftDeletes;

    protected $fillable = [
		'from_user_id',
		'to_user_id',
		'refference_id',
		'refference_type',
		'message',
		'is_read'
	];
}
