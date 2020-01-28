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

	public function formUser(){
        return $this->belongsTo(User::class,'from_user_id', 'id');
	}

	public function getMessageAttribute($msg)
	{
		$name = $this->formUser->first_name ." ".$this->formUser->last_name;
		$msg = str_replace("{Username}",$name,$msg);
		return $msg;
	}
}
