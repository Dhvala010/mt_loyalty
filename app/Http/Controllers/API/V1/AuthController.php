<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\CreateUser;
use App\Actions\UpdateAndSendForgotPassword;
use App\Constants\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChangePasswordRequest;
use App\Http\Requests\StoreForgotPasswordRequest;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreRegiserRequest;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /*
		Register Api
    */
    public function register(StoreRegiserRequest $request,CreateUser $createUser)
    {
        $response = $createUser->execute($request->all());
        $response->token = $response->createToken('loyalty')->accessToken;
        return response()->success(ResponseMessage::REGISTER_SUCCESS,replace_null_with_empty_string($response));
    }

    /*
		Login Api
    */
    public function login(StoreLoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user->token = $user->createToken('loyalty')->accessToken;
            $user->devices()->create($request->all());
            return response()->success(ResponseMessage::LOGIN_SUCCESS,["user" => replace_null_with_empty_string($user)]);
        } else {
            return response()->error(ResponseMessage::LOGIN_UNAUTHORIZED,Response::HTTP_UNAUTHORIZED);
        }
    }

    /*
		Forgot password Api
	*/
    public function forgotPassword(StoreForgotPasswordRequest $request,UpdateAndSendForgotPassword $updateAndSendForgotPassword)
    {
        $email = $request->email;
        $user = User::where(['email' => $email])->first();
        if(!$user){
            return response()->error(ResponseMessage::USER_NOT_FOUND,Response::HTTP_NOT_FOUND);
        }
        $updateAndSendForgotPassword->execute($user);
        return response()->success(ResponseMessage::FORGOT_PASSWORD_SUCCESS);
    }

    /*
		User Logout Api
	*/

    public function logout()
    {
        $user = Auth::user();
        $user->token()->revoke();
        return response()->success(ResponseMessage::LOGOUT_SUCCESS);
    }

    /*
		User Logout Api
	*/

    public function changePassword(StoreChangePasswordRequest $request)
    {
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user = Auth::user();
        if (\Hash::check($old_password, $user->password)) {
            $user->update(['password' => HashPassword($new_password)]);
            return response()->success(ResponseMessage::CHANGE_PASSWORD_SUCCESS,NULL);
        } else {
            return response()->error(ResponseMessage::PASSWORD_DO_NOT_MATCH,Response::HTTP_UNAUTHORIZED);
        }
    }
}
