<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\ResponseMessage;

use App\Actions\Addfamilymember;

use App\Http\Requests\ValidateUserToken;

use Str;

class FamilyMemberController extends Controller
{
    public function sendRequest(ValidateUserToken $request,Addfamilymember $Addfamilymember){
        $input = $request->all();

        $Addfamilymember->execute($input);
        return response()->success(ResponseMessage::REQUEST_SEND_SUCCESSFULLY);
    }
}
