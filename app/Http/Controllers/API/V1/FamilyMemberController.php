<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Constants\ResponseMessage;

use App\Actions\Addfamilymember,
    App\Actions\UpdatefamilymemberRequest;

use App\Http\Requests\ValidateUserToken,
    App\Http\Requests\ValidateFamilyId;

use Illuminate\Http\Request;

use App\FamilyMember;

use Illuminate\Support\Facades\Auth;

class FamilyMemberController extends Controller
{
    public function sendRequest(ValidateUserToken $request,Addfamilymember $Addfamilymember){
        $input = $request->all();

        $Addfamilymember->execute($input);
        return response()->success(ResponseMessage::REQUEST_SEND_FAMILY_MEMBER_SUCCESSFULLY);
    }

    public function updateRequest(ValidateFamilyId $request,UpdatefamilymemberRequest $UpdatefamilymemberRequest){
        $input = $request->all();

        $UpdatefamilymemberRequest->execute($input);
        return response()->success(ResponseMessage::REQUEST_UPDATE_REQUEST_FAMILY_MEMBER_SUCCESSFULLY);
    }

    public function MemberListing(Request $request){
        $input = $request->all();
        $user = Auth::user();
        $user_id = $user->id;
        $offset = $request->offset ? $request->offset : 10;
        $FamilyMember = FamilyMember::where(function($query) use ($user_id) {
                                        $query->orWhere("from_user",$user_id);
                                        $query->orWhere("to_user",$user_id);
                                    })->where("status","confirmed");

        $FamilyMember = $FamilyMember->paginate($offset)->toArray();
        $family_member_data = replace_null_with_empty_string($FamilyMember['data']);
        $total_record = $FamilyMember['total'];
        $total_page = $FamilyMember['last_page'];

        return response()->paginate(ResponseMessage::COMMON_MESSAGE,$family_member_data,$total_record,$total_page );
    }
}
