<?php

namespace App\Console\Commands; // Make sure to use the correct namespace

use Illuminate\Console\Command;
use App\Job;
use App\Profile;
use Carbon\Carbon;


class SendWeeklyJobs extends Command
{
    protected $signature = 'send:weekly-jobs';
    protected $description = 'Send last week\'s jobs to Independent Freelancers';

    public function handle()
    {
        // Get last week's jobs
        $lastWeekJobs = Job::where('created_at', '>=', Carbon::now()->subWeek())
            ->get();

        // Get freelancers with their category_id
        $freelancers = Profile::where('freelancer_type', 'Independent Freelancers')
            ->get();

        // Initialize an array to store matching jobs
        $matchingJobs = [];

        // Iterate through freelancers
        foreach ($freelancers as $freelancer) {
            // Get the freelancer's category ID
            $freelancerCategoryId = $freelancer->category_id;

            // Filter jobs based on freelancer's category ID
            $matchingJobsForFreelancer = $lastWeekJobs->filter(function ($job) use ($freelancerCategoryId) {
                return $job->category_id == $freelancerCategoryId;
            });

            // Logic to send emails to the freelancer for the matching jobs
            if ($matchingJobsForFreelancer->count() > 0) {
                // Send email to $freelancer->user with $matchingJobsForFreelancer
                // ...

                // Accumulate matching jobs
                $matchingJobs = array_merge($matchingJobs, $matchingJobsForFreelancer->toArray());
            }
        }

        // Now you can use the $matchingJobs array to include in your email or perform other actions
        $this->info('Last week\'s jobs sent successfully!');
    }
}
