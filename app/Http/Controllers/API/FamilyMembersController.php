<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateFamilyMember;
use App\Constants\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCreateFamilyMemberRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Auth;

class FamilyMembersController extends Controller
{
    
    public function familyMembers(){
       $user = Auth::user()->load('familyMembers');
       return response()->success(ResponseMessage::FAMILY_MEMBERS,["family_members" => replace_null_with_empty_string($user->familyMembers)]);
    }

    public function addFamilyMember(StoreCreateFamilyMemberRequest $request,CreateFamilyMember $createFamilyMember){
        $response = $createFamilyMember->execute($request->all());
        return response()->success(ResponseMessage::CREATE_FAMILY_MEMBER,["user" => replace_null_with_empty_string($response)]);
    }

    public function updateFamilyMembers(StoreCreateFamilyMemberRequest $request){

    }
}
