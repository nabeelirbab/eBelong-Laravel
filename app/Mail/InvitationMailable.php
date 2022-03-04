<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\EmailHelper;
class InvitationMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $template, $email_params = array(),$user_type)
    {
        $this->type = $type;
        $this->template = $template;
        $this->email_params = $email_params;
        $this->user_type = $user_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = !empty($this->template->subject) ? $this->template->subject : '';
        if ($this->type == 'invite_people') {
            $email_message = $this->prepareAdminEmailInvitation($this->email_params);
        }
        $message = $this->subject($subject)->view('emails.index')
            ->with(
                [
                    'html' => $email_message,
                ]
            );
        return $message;
    }
    public function prepareAdminEmailInvitation($email_params)
    {
        extract($email_params);
        $user_name = $name;
        $user_email = $email;
        $user_password = $password;
        $profile_link = $link;
        $signature = EmailHelper::getSignature();
        if($this->user_type == 4){
        $app_content = $this->template->content;
        }
        else{
            $app_content = $this->template['content'];
        }
        $email_content_default =    "Hi %name%! Thanks for registering at eBelong. You can now login to manage your account using the following credentials:
Password: %password%
Email: %email%

Please visite the link %link%


%signature%";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%name%", $user_name, $app_content);
        $app_content = str_replace("%email%", $user_email, $app_content);
        $app_content = str_replace("%password%", $user_password, $app_content);
        $app_content = str_replace("%link%", $profile_link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);

        $body = "";
        $body .= EmailHelper::getEmailHeader();
        $body .= $app_content;
        $body .= EmailHelper::getEmailFooter();
        return $body;
    }
}
