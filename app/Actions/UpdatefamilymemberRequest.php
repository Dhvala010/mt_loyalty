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
class UpdatefamilymemberRequest
{

    protected $FamilyMember;

    public function __construct(FamilyMember $FamilyMember)
    {
        $this->FamilyMember = $FamilyMember;
    }

    public function execute(array $data){
        $family_member_id = $data["family_member_id"];
        $Action = $data["Action"];
        $FamilyMemberData =  $this->FamilyMember->where("id",$family_member_id)
                                                ->whereIn("status",["pending"])
                                                ->first();
        $user = Auth::user();

        if(empty($FamilyMemberData)){
            throw new ModelNotFoundException(ResponseMessage::NOT_AUTHORIZE);
        }

        switch ($Action) {
            case "cancel":
                if($FamilyMemberData->from_user != $user->id){
                    throw new ModelNotFoundException(ResponseMessage::NOT_AUTHORIZE);
                }
                $FamilyMemberData->status = $Action;
                $FamilyMemberData->save();
                break;
            case "confirmed":
                 if($FamilyMemberData->to_user != $user->id){
                    throw new ModelNotFoundException(ResponseMessage::NOT_AUTHORIZE);
                 }
                $FamilyMemberData->status = $Action;
                $FamilyMemberData->save();
                break;
            case "reject":
                if($FamilyMemberData->to_user != $user->id){
                    throw new ModelNotFoundException(ResponseMessage::NOT_AUTHORIZE);
                }
                $FamilyMemberData->status = $Action;
                $FamilyMemberData->save();
                break;
            default:
                throw new ModelNotFoundException(ResponseMessage::INVALIDE_ACTION);
        }

        return $FamilyMemberData;
    }
}
