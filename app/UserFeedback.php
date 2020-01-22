<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{
    protected $fillable = [
        'user_id',
		'title',
		'description'
	];

	public function user_detail(){
        return $this->belongsTo(User::class,'user_id', 'id');
    }
}
