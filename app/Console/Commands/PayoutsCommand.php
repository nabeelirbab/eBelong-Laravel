<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Helper;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use App\Payout;
use App\Skill;
use App\SiteManagement;
use App\User;
use App\Service;
use App\Cource;
use App\Job;
use DB;
use Illuminate\Support\Facades\Schema;

class PayoutsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:payouts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'updating payouts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {  
        $payout_settings = SiteManagement::getMetaValue('commision');
        $min_payount = !empty($payout_settings) && !empty($payout_settings[0]['min_payout']) ? $payout_settings[0]['min_payout'] : '';
        $payment_settings = SiteManagement::getMetaValue('commision');
        $currency  = !empty($payment_settings) && !empty($payment_settings[0]['currency']) ? $payment_settings[0]['currency'] : 'USD';
        $job_payouts = DB::select(
            DB::raw(
                "SELECT freelancer_id AS user_id, 
                SUM(amount) AS total,
                GROUP_CONCAT(id) AS ids
                FROM proposals
                WHERE paid = 'pending' 
                AND proposals.status = 'completed' 
                GROUP BY freelancer_id"
            )
        );
        
        $purchased_services = DB::select(
            DB::raw(
                "SELECT SUM(services.price) AS total, service_user.seller_id AS user_id, GROUP_CONCAT(service_user.id) AS ids
                FROM service_user 
                INNER JOIN services
                WHERE service_user.service_id = services.id
                AND service_user.type = 'employer'
                AND service_user.status = 'completed'
                AND service_user.paid = 'pending' 
                GROUP BY service_user.seller_id"
            )
        );
        $purchased_courses = DB::select(
            DB::raw(
                "SELECT SUM(cources.price) AS total, cource_user.seller_id AS user_id, GROUP_CONCAT(cource_user.id) AS ids
                FROM cource_user 
                INNER JOIN cources
                WHERE cource_user.cource_id = cources.id
                AND cource_user.type = 'employer'
                AND cource_user.status = 'bought'
                AND cource_user.paid = 'pending' 
                GROUP BY cource_user.seller_id"
            )
        );
        
        $data = array_merge($job_payouts, $purchased_services,$purchased_courses);
        $result=array();
        foreach ($data as $value) {
            if (isset($result[((array)$value)["user_id"]])) {
                $result[((array)$value)["user_id"]]["total"]+=((array)$value)["total"];
            } else {
                $result[((array)$value)["user_id"]]=(array)$value;
            }
        }
        $totalPayouts = array();
        $totalPayouts = array_values($result);
        if (!empty($totalPayouts)) {
            // dd($totalPayouts);
            foreach ($totalPayouts as $q) {
                if ($q['total'] >= $min_payount) {
                  //  dd("im gr8r");
                    $user = User::find($q['user_id']);
                   
                    if ($user['profile']) {
                        $payout_id = !empty($user['profile']->payout_id) ? $user['profile']->payout_id : '';
                        $payout_detail = !empty($user['profile']->payout_settings) ? $user->profile->payout_settings : array();
                        if (!empty($payout_id) || !empty($payout_detail)) {
                            $total_earning = Helper::deductAdminCommission($q['total']);
                          
                            $payout = new Payout();
                            $payout->user()->associate($q['user_id']);
                            $payout->amount = $total_earning;
                            $payout->currency = $currency;
                            if (!empty($payout_detail)) { 
                                $payment_details  = Helper::getUnserializeData($user->profile->payout_settings);
                                if ($payment_details['type'] == 'paypal') {
                                    if (Schema::hasColumn('payouts', 'email')) {
                                        $payout->email = $payment_details['paypal_email'];
                                    } elseif (Schema::hasColumn('payouts', 'paypal_id')) {
                                        $payout->paypal_id = $payment_details['paypal_email'];
                                    }
                                } else if ($payment_details['type'] == 'bacs') {
                                    $payout->bank_details = $user->profile->payout_settings;
                                    $payout->paypal_id = 'null';
                                } else {
                                    $payout->paypal_id = '';
                                }
                                $payout->payment_method = $payment_details['type'];
                            } else if (!empty($payout_id)) {
                                $payout->payment_method = 'paypal';
                                if (Schema::hasColumn('payouts', 'email')) {
                                    $payout->email = $payout_id;
                                } elseif (Schema::hasColumn('payouts', 'paypal_id')) {
                                    $payout->paypal_id = $payout_id;
                                }
                            }
							
                            /*========== For get project id & employee id ==========*/
							$projectids = "";
							$employeeid = "";
							if(!empty($job_payouts)) {
								foreach ($job_payouts as $q) {
                                    
									$projectids .= $projectids == "" ? $q->ids : $projectids.','.$q->ids;
								}
								$job = DB::table('proposals')->select('jobs.user_id')
									->join('jobs','jobs.id','=','proposals.job_id')
									->whereIn('proposals.id',explode(",",$projectids));
								if($job->count() > 0){
									$job = $job->get();
									foreach($job as $empid){ 
										$employeeid = $employeeid != "" ? $employeeid.",".$empid->user_id : $empid->user_id;
									}
								}	
							}
							
							if(!empty($purchased_services)) {
								foreach ($purchased_services as $q) {
									$projectids .= $projectids == "" ? $q->ids : $projectids.','.$q->ids;
								}
								
								$service = DB::table('service_user')->select('service_user.user_id')
									->whereIn('service_user.id',explode(",",$projectids));
								if($service->count() > 0 ){
									$service = $service->get();
									foreach($service as $empid){ 
										$employeeid = $employeeid != "" ? $employeeid.",".$empid->user_id : $empid->user_id;
									}
								}
							} 
                            if(!empty($purchased_courses)) {
                               
                                    
									$projectids .= $projectids == "" ? $q['ids'] : $projectids.','.$q['ids'];
								
							
								$course = DB::table('cource_user')->select('cource_user.user_id')
									->whereIn('cource_user.id',explode(",",$projectids));
								if($course->count() > 0 ){
									$course= $course->get();
									foreach($course as $empid){ 
										$employeeid = $employeeid != "" ? $employeeid.",".$empid->user_id : $empid->user_id;
									}
								}
							} 
							/*========== end get project id & employee id ===========*/
							
                            $payout->status = 'pending';
                            $payout->order_id = null;
                            $payout->projects_ids = $projectids;
                            $payout->employee_id = $employeeid;
                            $payout->type = 'job';
                            $payout->save();
                        }
                    }
                }
            }
            if (!empty($job_payouts)) {
                foreach ($job_payouts as $q) {
                    $primary_records = explode(',', $q->ids);
                    foreach ($primary_records as $primary) {
                        DB::table('proposals')
                            ->where('id', $primary)
                            ->update(['paid' => 'completed']);
                    }
                }
            }
            if (!empty($purchased_courses)) {
                foreach ($purchased_courses as $q) {
                    $primary_records = explode(',', $q->ids);
                    foreach ($primary_records as $primary) {
                        DB::table('cource_user')
                            ->where('id', $primary)
                            ->update(['paid' => 'completed']);
                    }
                }
            }
            if (!empty($purchased_services)) {
                foreach ($purchased_services as $q) {
                    $primary_records = explode(',', $q->ids);
                    foreach ($primary_records as $primary) {
                        DB::table('service_user')
                            ->where('id', $primary)
                            ->update(['paid' => 'completed']);
                    }
                }
            }
        }

    }
}
