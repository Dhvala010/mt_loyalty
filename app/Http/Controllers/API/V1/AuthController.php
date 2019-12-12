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
use App\Http\Requests\CheckSocialLoginRequest;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

use App\User,
    App\Country;
use League\Flysystem\Config;
use Helper;
/*use App\Mail\VerifyMail;*/

class AuthController extends Controller
{
    /*
		Register Api
    */
    public function register(StoreRegiserRequest $request,CreateUser $createUser){
        $data = $request->all();
        $response = $createUser->execute($data);
        $user = User::find($response->id);
        $user->token = $user->createToken('loyalty')->accessToken;

        /*$role = $data['role'];
        if($role=='merchant'){
            Mail::to($user->email)->send(new VerifyMail($user->toArray()));
        }*/

        return response()->success(ResponseMessage::REGISTER_SUCCESS,Helper::replace_null_with_empty_string($user));
    }

    /*
		Login Api
    */
    public function login(StoreLoginRequest $request){
        $role = config("loyalty.user_role.".$request->role);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password , 'role' => $role])){
            $user = Auth::user();
            $user->token = $user->createToken('loyalty')->accessToken;
            $user->devices()->create($request->all());
            return response()->success(ResponseMessage::LOGIN_SUCCESS,Helper::replace_null_with_empty_string($user));
        } else {
            return response()->error(ResponseMessage::LOGIN_UNAUTHORIZED,Response::HTTP_UNAUTHORIZED);
        }
    }

    /*
		Forgot password Api
	*/
    public function forgotPassword(StoreForgotPasswordRequest $request,UpdateAndSendForgotPassword $updateAndSendForgotPassword){

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
    public function logout(){
        $user = Auth::user();
        $user->token()->revoke();
        return response()->success(ResponseMessage::LOGOUT_SUCCESS);
    }

    /*
		User change Password Api
	*/
    public function changePassword(StoreChangePasswordRequest $request){
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user = Auth::user();
        if (\Hash::check($old_password, $user->password)) {
            $user->update(['password' => Helper::HashPassword($new_password)]);
            return response()->success(ResponseMessage::CHANGE_PASSWORD_SUCCESS,NULL);
        } else {
            return response()->error(ResponseMessage::PASSWORD_DO_NOT_MATCH,Response::HTTP_UNAUTHORIZED);
        }
    }

    /*
		Check Social Login Api
    */
    public function checkSocialLogin(CheckSocialLoginRequest $request){
        $social_media_id = $request->social_media_id;
        $user = User::where(['fbid' => $social_media_id])
                ->orWhere(['gid'=> $social_media_id])
                ->orWhere(['tid'=> $social_media_id])
                ->first();
        if(!empty($user)){
            $user->token = $user->createToken('loyalty')->accessToken;
            return response()->success(ResponseMessage::COMMON_MESSAGE,Helper::replace_null_with_empty_string($user));
        }else{
            return response()->error(ResponseMessage::SOCIAL_MEDIA_NOT_FOUND,201);
        }
    }

    /*
		Check Configuration listing api
    */
    public function configuration(Request $request){
        $data['country'] = Country::get();
        return response()->success(ResponseMessage::COMMON_MESSAGE,$data);
    }

    /*
		User Detail APi
    */
    public function UserDetail(Request $request){
        $user = Auth::user();
        return response()->success(ResponseMessage::COMMON_MESSAGE,Helper::replace_null_with_empty_string($user));
    }
}
