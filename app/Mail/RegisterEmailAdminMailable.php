<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterEmailAdminMailable extends Mailable
{
    use Queueable, SerializesModels;
   // public $name;

   public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
       // $this->name = $name;
       $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

      return $this->from('admin@ebelong.com','eBelong')
          ->subject('New '.$this->data['role'].' has joined')
          ->view('emails/new_user_email_to_admin')
          ->with('data', $this->data);
       
    }
}
