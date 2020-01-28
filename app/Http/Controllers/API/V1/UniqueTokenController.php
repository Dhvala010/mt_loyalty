<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Constants\ResponseMessage;

use App\Actions\GenrerateScanePromocodeToken,
    App\Actions\AddUserPromocodeStamp;

use App\Http\Requests\PromocodeValidateRequest,
    App\Http\Requests\PromocodeTokenValidateRequest;

class UniqueTokenController extends Controller
{
     /*
		Generate Unique Token For Collact Stamp And Redeem
    */
    public function GeneratePromocodeToken(PromocodeValidateRequest $request,GenrerateScanePromocodeToken $promoCodeToken){
        $input = $request->all();

        $response = $promoCodeToken->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($response));
    }

    /*
		Validate Unique token and collact stamp and points
    */
    public function ValidatePromocodeToken(PromocodeTokenValidateRequest $request,AddUserPromocodeStamp $AddUserPromocodeStamp){
        $input = $request->all();

        $response = $AddUserPromocodeStamp->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($response));
    }
}
