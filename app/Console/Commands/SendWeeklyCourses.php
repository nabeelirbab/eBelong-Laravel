<?php

namespace App\Console\Commands;

use App\Cource;
use App\Profile;
use Illuminate\Console\Command;

class SendWeeklyCourses extends Command
{
    protected $signature = 'send:weekly-cources';
    protected $description = 'Send last week\'s cources to Independent Freelancers';
    public function handle()
    {
        // Get freelancers with their category_id
        $freelancers = Profile::with('user')->where('freelancer_type', 'Independent Freelancers')
            ->get();

        // Initialize an array to store matching jobs
        $matchingJobs = [];

        // Iterate through freelancers
        foreach ($freelancers as $freelancer) {
            // Get the freelancer's category ID
            $freelancerCategoryId = $freelancer->category_id;

            // Get last week's jobs for the freelancer's category
            $matchingJobsForFreelancer = Cource::with('categories', 'employer')
                ->whereHas('categories', function ($query) use ($freelancerCategoryId) {
                    $query->where('categories.id', $freelancerCategoryId);
                })->limit(10)
                ->get();
            // Logic to send emails to the freelancer for the matching jobs
            if ($matchingJobsForFreelancer->count() > 0) {

                $matchingJobs = array_merge($matchingJobs, $matchingJobsForFreelancer->toArray());
                // Mail::to('peeknabeel@gmail.com')->send(new JobsMailable($matchingJobsForFreelancer->toArray(), $freelancer->user));
            }
        }

        // Now you can use the $matchingJobs array to include in your email or perform other actions
        $this->info('Last week\'s jobs sent successfully!');
    }
}
