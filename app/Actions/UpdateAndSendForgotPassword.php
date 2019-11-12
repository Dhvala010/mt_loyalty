<?php


namespace App\Actions;

use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use App\Notifications\PasswordResetRequest;
use App\User,
    App\PasswordReset;
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

    public function execute($user){
        $token = RandomPassword(60);
        $passwordReset = PasswordReset::updateOrCreate(['email' => $user->email],['email' => $user->email,'token' => \Hash::make($token)]);
        // $user->update(['password' => HashPassword($password)]);
        try {
            $user->notify(new PasswordResetRequest($token));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
