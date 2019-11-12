<?php


namespace App\Actions;

use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class UpdateAndSendForgotPassword
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user; 
    }

    public function execute($user,$newPassword = NULL){
        $email = $user->email;
        $password = $newPassword ? $newPassword : RandomPassword(8);
        $user->update(['password' => HashPassword($password)]);
        $data['username'] = $user['first_name'] . ' ' . $user['last_name'];
        $data['password'] = $password;
        try {
            Mail::to($email)->queue(new ForgotPassword($data));
        } catch (\Exception $exception) {
        }
    }
}
