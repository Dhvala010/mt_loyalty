<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Verification Email.';

    public $viewData = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->viewData = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $user_data = $this->viewData;
        $user = User::find($user_data['id']);
        return $this->view('emails.verify_email',['user' => $user] );
    }
}
