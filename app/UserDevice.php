<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDevice extends Model
{
    //
    use SoftDeletes;
    //
    protected $fillable = [
		'user_id',
		'device_unique_id',
		'fcm_token',
		'language',
		'device_type',
		'device_os',
		'device_model',
		'device_manufacturer',
		'api_version',
		'app_version',
		'buildtype',
		'buildversion'
	];
	protected $hidden = [
		'created_at', 'updated_at',
	];
}
