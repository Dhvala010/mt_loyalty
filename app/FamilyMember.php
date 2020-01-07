<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
class FamilyMember extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'from_user',
        "to_user",
        "created_by",
        "status"
    ];

    protected $appends = ["user_detail" , "status"];

    // protected $hidden = ["to_user_detail" , "from_user_detail"];

    public function from_user_detail(){
        return $this->belongsTo(User::class,'from_user', 'id');
    }

    public function to_user_detail(){
        return $this->belongsTo(User::class,'to_user', 'id');
    }

    public function getUserDetailAttribute($value){
        $user_id = Auth::id();
        $users = $this->from_user == $user_id ? $this->to_user_detail()->first() : $this->from_user_detail()->first();
        return  $users;
    }

    public function getStatusAttribute($value){
        $user_id = Auth::id();
        if($this->from_user == $user_id && $this->status == "pending"  ){

        }
    }
}
