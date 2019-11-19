<?php


namespace App\Actions;

use App\Constants\ResponseMessage;
use App\Exceptions\EmailNotUniqueException;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
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
            $user = $this->user->create($data);
        } catch (\Exception $e) {
            rollback();
            throw new Exception(ResponseMessage::ERROR_CREATING_USER);
        }
        try {
            $user->devices()->create($data);
        } catch (\Exception $e) {
            rollback();
            throw new Exception(ResponseMessage::ERROR_CREATING_DEVICE);
        }
        commit();
        return $user;
    }
}
