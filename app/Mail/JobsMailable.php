<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobsMailable extends Mailable
{
    use Queueable, SerializesModels;
    // public $name;

    public $data;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $user)
    {
        // $this->name = $name;
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('admin@ebelong.com', 'eBelong')
            ->subject('Latest Jobs')
            ->view('emails/jobs')
            ->with('data', $this->data, $this->user);
    }
}
