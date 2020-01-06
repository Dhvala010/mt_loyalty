<?php


namespace App\Actions;

use App\FamilyMember,
    App\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Constants\ResponseMessage;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Addfamilymember
{

    protected $FamilyMember;

    public function __construct(FamilyMember $FamilyMember)
    {
        $this->FamilyMember = $FamilyMember;
    }

    public function execute(array $data){
        $unique_token = $data["unique_token"];
        $user_detail = User::where("unique_token",$unique_token)->first();
        $user = Auth::user();
        $from_user = $user->id;
        $to_user = $user_detail->id;
        $FamilyMemberData = $this->FamilyMember->whereIn("status",["pending","confirmed"])
                            ->where(function($query) use ($from_user,$to_user){
                                $query->orWhere(function($query) use ($from_user,$to_user){
                                    $query->where('from_user', $from_user);
                                    $query->where('to_user',  $to_user);
                                });
                                $query->orWhere(function($query) use ($from_user,$to_user){
                                    $query->where('from_user', $from_user);
                                    $query->where('to_user',  $to_user);
                                });
                            })->first();
        if($FamilyMemberData){
            if($FamilyMemberData->status == "pending" ){
                throw new ModelNotFoundException(ResponseMessage::REQUEST_ALLREADY_SEND_FAMILY_MEMBER_SUCCESSFULLY);
            }else{
                throw new ModelNotFoundException(ResponseMessage::REQUEST_ALLREADY_FRD_FAMILY_MEMBER_SUCCESSFULLY);
            }
        }

        $FamilyMemberManage = [
            "from_user" => $user->id,
            "to_user" => $user_detail->id,
            "created_by" => $user->id,
            "status" => "pending"
        ];

        $FamilyMember = $this->FamilyMember->create($FamilyMemberManage);

        return $FamilyMember;
    }
}
