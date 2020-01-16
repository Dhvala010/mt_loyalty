<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Constants\ResponseMessage;

use App\Actions\Addfamilymember,
    App\Actions\UpdatefamilymemberRequest,
    App\Actions\SharedStamp;

use App\Http\Requests\ValidateUserToken,
    App\Http\Requests\validatefamilyid,
    App\Http\Requests\ShareStampValidate;

use Illuminate\Http\Request;

use App\FamilyMember;

use Illuminate\Support\Facades\Auth;

class FamilyMemberController extends Controller
{
    /*
		Send Request For Add Family member
    */
    public function sendRequest(ValidateUserToken $request,Addfamilymember $Addfamilymember){
        $input = $request->all();

        $Addfamilymember->execute($input);
        return response()->success(ResponseMessage::REQUEST_SEND_FAMILY_MEMBER_SUCCESSFULLY);
    }

    /*
		Request Cancel , Reject And Accept For Family Member
    */
    public function updateRequest(validatefamilyid $request,UpdatefamilymemberRequest $UpdatefamilymemberRequest){
        $input = $request->all();

        $UpdatefamilymemberRequest->execute($input);
        return response()->success(ResponseMessage::REQUEST_UPDATE_REQUEST_FAMILY_MEMBER_SUCCESSFULLY);
    }

    /*
		Accept And Pending Request Member Listing
    */
    public function MemberListing(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $offset = $request->offset ? $request->offset : 10;
        $FamilyMember = FamilyMember::where(function($query) use ($user_id) {
                                        $query->orWhere("from_user",$user_id);
                                        $query->orWhere("to_user",$user_id);
                                    })->whereIn("status", [ "confirmed" , "pending" ] );

        $FamilyMember = $FamilyMember->paginate($offset)->toArray();
        $family_member_data = replace_null_with_empty_string($FamilyMember['data']);
        $total_record = $FamilyMember['total'];
        $total_page = $FamilyMember['last_page'];

        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$family_member_data,$total_record,$total_page );
    }

    /*
		Accept And Pending Request Member Listing
    */
    public function deletefamilymember(validatefamilyid $request){
        $input = $request->all();
        FamilyMember::find($input["family_member_id"])->delete();
        return response()->success(ResponseMessage::COMMON_MESSAGE);
    }

    /*
		Share Stamp to another family member
    */
    public function shareStamp(ShareStampValidate $request,SharedStamp $SharedStamp){
        $input = $request->all();
        $SharedStamp->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE);
    }

}
