<?php


namespace App\Actions;

use App\Constants\ResponseMessage;
use App\User;
use Exception;
use Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class CreateUser
{

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function execute(array $data){
        $role = $data['role'];
        $data['role'] = config("loyalty.user_role.".$data['role']);
        $user = User::where(['email' => $data['email'] ])->first();

        if(!empty($data['fbid']) || !empty($data['tid']) || !empty($data['gid'])){
            if(!empty($user)){
                if(!empty($data['fbid']))
                    $user->fbid = $data['fbid'];
                if(!empty($data['tid']))
                    $user->tid = $data['tid'];
                if(!empty($data['gid']))
                    $user->gid = $data['gid'];

                $user->save();
                return $user;
            }
        }else{
            if(!empty($user)){
                throw new ModelNotFoundException(ResponseMessage::USER_EMAIL_EXIST);
            }
        }
        begin();
        try {
            if(empty($data['password']))
                $data['password'] = RandomPassword(8);
            //dd($data['password']);
            $data['password'] = HashPassword($data['password']);
            $data['unique_token'] = Str::random(12);
            $user = $this->user->create($data);
            $user->assignRole($role);
        } catch (\Exception $e) {
            rollback();
            throw new Exception(ResponseMessage::ERROR_CREATING_USER);
        }
        try {
            if(!empty($data['fcm_token']))
                $user->devices()->create($data);
        } catch (\Exception $e) {
            rollback();
            throw new Exception(ResponseMessage::ERROR_CREATING_DEVICE);
        }
        commit();
        return $user;
    }
}
