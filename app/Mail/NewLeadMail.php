<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewLeadMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    public $lead;
    
    public function __construct($user, $lead)
    {
        $this->user = $user;
        $this->lead = $lead;
    }
  
    public function build()
    {
        return $this->subject('Novo lead - '.config('app.app_title'))->view('mail.new-lead')->with(['user' => $this->user, 'lead' => $this->lead]);
    }
}
