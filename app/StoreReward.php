<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
class StoreReward extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'store_id',
        'title',
        'description',
        'count',
        'offer_valid',
    ];

    protected $appends = ["is_redeem"];

    protected $hidden = ["redeemDetail"];

    public function redeemDetail(){
        $id = Auth::id();
        return $this->hasMany(UserRedeem::class,'reward_id','id')->where("user_id",$id);
    }

    public function getIsRedeemAttribute(){
        return $this->redeemDetail->isEmpty() ? 0 : 1;
    }
}
