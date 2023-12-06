<?php

namespace App\Console\Commands;

use App\Profile;
use Illuminate\Console\Command;
use App\User; // Assuming your model is User for freelancers
use Mail;
use App\EmailTemplate;
use App\Helper;
use App\Mail\ProfileCompletionMailable;
use DB;

class SendProfileReminders extends Command
{
    protected $signature = 'send:profile-reminders';
    protected $description = 'Send profile completion reminders to freelancers';

    public function handle()
    {
        // Get freelancers who haven't completed their profiles
        $freelancers = User::whereHas('roles', function ($query) {
            $query->where('role_id', 3); // Assuming role id 3 represents freelancers
        })
            ->get();
        // Send reminder emails
        foreach ($freelancers as $freelancer) {
            $profile = Profile::all()->where('user_id', $freelancer->id)->first();
            // Calculate the completion percentage based on their profile completeness
            $percentage = $this->getProfileCompletionPercentage($profile);
            if ($percentage < 34) {
                $admin_template = DB::table('email_types')->select('id')->where('email_type', 'profile_complete')->first();
                $template_data = EmailTemplate::getEmailTemplateByID($admin_template->id);
                // Send email
                $email_params['freelancer_name'] = Helper::getUserName($freelancer->id);
                $email_params['link'] = url('/');
                $email_params['percentage'] = $percentage;

                Mail::to($freelancer->email)->send(new ProfileCompletionMailable('profile_complete', $template_data, $email_params, 3));
                $this->info($percentage);
            }

            // Replace with your email logic
            // Mail::raw($emailContent, function ($message) use ($freelancer) {
            //     $message->to($freelancer->email)->subject('Complete Your Profile');
            // });
        }

        $this->info('Profile completion reminders sent successfully.');
    }

    public function getProfileCompletionPercentage($profile)
    {
        $totalFields = 9; // Total number of fields required for profile completion

        $completedFields = 0; // Counter for completed fields

        // Check if each required field is filled or not
        if (!empty($profile->english_level)) {
            $completedFields++;
        }

        if (!empty($profile->hourly_rate)) {
            $completedFields++;
        }

        if (!empty($profile->experience)) {
            $completedFields++;
        }

        if (!empty($profile->education)) {
            $completedFields++;
        }

        if (!empty($profile->projects)) {
            $completedFields++;
        }

        if (!empty($profile->avater)) {
            $completedFields++;
        }

        if (!empty($profile->banner)) {
            $completedFields++;
        }

        if (!empty($profile->description)) {
            $completedFields++;
        }

        if (!empty($profile->tagline)) {
            $completedFields++;
        }

        // Calculate profile completion percentage
        $percentage = ($completedFields / $totalFields) * 100;
        return intval(round($percentage));
    }
}
