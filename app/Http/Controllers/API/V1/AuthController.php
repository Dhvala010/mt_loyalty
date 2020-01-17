<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\CreateUser,
    App\Actions\UpdateAndSendForgotPassword,
    App\Actions\UpdateUser;

use Symfony\Component\HttpFoundation\Response;
use App\Constants\ResponseMessage;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\StoreChangePasswordRequest,
    App\Http\Requests\StoreForgotPasswordRequest,
    App\Http\Requests\StoreLoginRequest,
    App\Http\Requests\StoreRegiserRequest,
    App\Http\Requests\CheckSocialLoginRequest,
    App\Http\Requests\UpdateUserRequest,
    App\Http\Requests\validatefamilyid;

use Illuminate\Support\Facades\Auth;

use App\User,
    App\Country;

use Illuminate\Support\Facades\Hash;
/*use App\Mail\VerifyMail;*/

class AuthController extends Controller
{
    /*
		Customer and merchant Register Api
    */
    public function register(StoreRegiserRequest $request,CreateUser $createUser){
        $data = $request->all();
        $response = $createUser->execute($data);
        $user = User::find($response->id);
        $user->token = $user->createToken('loyalty')->accessToken;
        if($request->fcm_token){
            $user->devices()->create($request->all());
        }
        return response()->success(ResponseMessage::REGISTER_SUCCESS,replace_null_with_empty_string($user));
    }

    /*
		Customer and merchant Login Api
    */
    public function login(StoreLoginRequest $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password ])){
            $user = Auth::user();
            $user->token = $user->createToken('loyalty')->accessToken;
            if($request->fcm_token){
                $user->devices()->create($request->all());
            }
            return response()->success(ResponseMessage::LOGIN_SUCCESS,replace_null_with_empty_string($user));
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
    public function logout(Request $request){
        $user = Auth::user();
        $user->devices()->where("fcm_token",$request->fcm_token)->delete();
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
        if (Hash::check($old_password, $user->password)) {
            $user->update(['password' => HashPassword($new_password)]);
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
            return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($user));
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
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($user));
    }

    /*
		Update User Profile APi
    */
    public function UpdateProfile(UpdateUserRequest $request,UpdateUser $updateUser){
        $input = $request->all();
        $image = $request->file('profile_picture') ?? '';
       	if(!empty($image)){
          $imagename = ImageUpload($image,'user');
          $input['profile_picture'] = $imagename;
        }
        $response = $updateUser->execute($input);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($response));
    }

    public function RoleAssign(){
        $user = User::get();
        foreach ($user as $key => $value) {
            $RoleName = $value->getRoleNames();
            if($RoleName->isEmpty()){
                $user_roles = config('loyalty.user_role');
                $userRole = array_keys($user_roles,$value->role);
                $Role = reset($userRole);
                $value->assignRole($Role);
            }

        }

    }
}
