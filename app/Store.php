<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class Store extends Model
{
    use HasApiTokens,SoftDeletes,Notifiable;
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

    protected $dates = ['deleted_at'];

    protected $appends = ['stamp_count' , 'point_count'];

    protected $hidden = ['user_stemp_count' , 'user_point_count' , 'updated_at' , 'deleted_at'];

    public function merchant(){
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function getImageAttribute($value) {
        return $value ? asset('/uploads/store_image') . "/" .  $value : "";
    }


    public function user_stemp_count(){
        $id = Auth::id();
        return $this->hasMany(UserStampCollect::class)->where('user_id',$id);
    }

    public function user_point_count(){
        $id = Auth::id();
        return $this->hasMany(UserPointCollect::class)->where('user_id',$id);
    }

    public function getStampCountAttribute(){
        return $this->user_stemp_count->sum('count');
    }

    public function getPointCountAttribute(){
        return $this->user_point_count->sum('count');
    }

    public function store_offer(){
        return $this->hasMany(StoreOffer::class);
    }

    public function store_reward(){
        return $this->hasMany(StoreReward::class,'store_id','id');
    }

    public function store_promocode(){
        return $this->hasOne(StorePromocode::class);
    }
}