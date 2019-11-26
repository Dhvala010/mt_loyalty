<?php


namespace App\Actions;

use App\User;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class CreateSocialLogin
{

    protected $user;
    public function __construct($data,User $user)
    {
        $this->user = $user;
        $data['user_type'];
    }

    public function execute(array $data){
        $user = 1;
        return $user;
    }
}
