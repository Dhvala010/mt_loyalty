<?php


namespace App\Actions;

use App\Constants\ResponseMessage;
use App\Exceptions\EmailNotUniqueException;
use App\User;
use Exception;
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
        begin();
        try {
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
