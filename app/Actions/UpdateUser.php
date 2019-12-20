<?php


namespace App\Actions;

use App\Constants\ResponseMessage;
use App\User;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class UpdateUser
{

    protected $User;
    public function __construct(User $User)
    {
        $this->User = $User;
    }

    public function execute(array $data){
        $user_id = Auth::user()->id;
        $User = User::find($user_id);
        $User->fill($data);
        $User->save();

        return $User;
    }
}
