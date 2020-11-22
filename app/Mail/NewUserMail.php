<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserMail extends Mailable
{
  use Queueable, SerializesModels;
  
  public $user;
  public $password;
  
  public function __construct($user, $password)
  {
    $this->user = $user;
    $this->password = $password;
  }
  
  
  public function build()
  {
    return $this->subject('Seja bem vindo - '.config('app.app_title'))->view('mail.new-user')->with(['user' => $this->user, 'password' => $this->password]);
  }
}
