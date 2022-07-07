<?php

namespace App\Http\Controllers;

use App\WorkDiary;
use App\Job;
use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use App\Language;
use App\Category;
use App\Skill;
use App\Location;
use App\Helper;
use App\Proposal;
use ValidateRequests;
use App\User;
use App\Profile;
use App\Package;
use DB;
use Spatie\Permission\Models\Role;
use App\SiteManagement;
use App\Mail\AdminEmailMailable;
use App\Mail\EmployerEmailMailable;
use App\EmailTemplate;
use App\Item;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use App\Review;
use App\Wallet;
use App\HourlyJobPayOut;

class WorkDiaryController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access public
     * @var    array $department
     */
    protected $workdiary;

    public function __construct(WorkDiary $workdiary)
    {
        $this->workdiary = $workdiary;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id,$date)
    {
         $project_id = $id;
         $project_title =   Job::where('id', $project_id)->first();
         //dd($project_title->title);
         $data['projects'] = Job::where('project_type','hourly')->where('status','hired')->get()->toArray();
            $data['date'] = $date;
        return view('back-end.freelancer.jobs.workdiary',compact('project_title'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $json = array();
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['message'] = $server->getData()->message;
            return $response;
        }
        if (Helper::getAccessType() == 'jobs') {
            $json['type'] = 'error';
            $json['message'] = trans('lang.service_warning');
            return $json;
        }
        $this->validate(
            $request,
            [
                'project_id' => 'required',
                'date'    => 'required',
                'start_time'    => 'required',
                'end_time'    => 'required',
                'description'    => 'required',
            ]
        );
        $validation = $this->createworkdiaryvalidation($request);
        if($validation['status'])
        {
            $create_work_diary = $this->workdiary->saveWorkDiary($request);
            if($create_work_diary)
            {
                $json['type'] = 'success';
                $json['message'] = "Successfully Added";
                return $json;
            }
            else
            {
                $json['type'] = 'server_error';
                $json['message'] = "server_error";
                return $json;
            }   
        }
        else {
            $json['type'] = 'error';
            $json['message'] = $validation['message'];
            return $json;
        }
    }

    public function createworkdiaryvalidation($request)
    {
        $validate = array(
            "status"   => true,
            "message"  => ""
        );
        
        if(strtotime(date("Y-m-d")) < strtotime($request['date']))
        {
            $validate['status']  = false;
            $validate['message'] = "You cannot enter the future date.";
            return $validate;
        }

        $project_id = Job::where('id',$request['project_id'])->first();
        if(empty($project_id))
        {
            $validate['status']  = false;
            $validate['message'] = "Project Id is invalid";
            return $validate;
        }
        if(strtotime($project_id->hired_date) > strtotime($request['date']." ".$request['start_time']))
        {
            $validate['status']  = false;
            $validate['message'] = "Your were hired on : " . $project_id->hired_date. "(UTC),Please add time after this date and start time.";
            return $validate;
        }
        if((strtotime($request['end_time'])-strtotime($request['start_time'])) <= 0)
        {
            $validate['status']  = false;
            $validate['message'] = "Start time is not greater and equal to End time.";
            return $validate;
        }
        $request_no_of_seconds = strtotime($request['end_time'])-strtotime($request['start_time']);
        if($request_no_of_seconds > ($project_id->no_of_hours*60*60))
        {
            $validate['status']  = false;
            $validate['message'] = "You have enter greater no of hours in this project";
            return $validate;   
        }
        //->where('date',$request['date'])
        $get_project_work_diary = WorkDiary::where('project_id',$request['project_id'])->get()->toArray();
        if(!empty($get_project_work_diary))
        {
            $requested_scenario_data = array(
                "start_time" => $request['start_time'],
                "end_time"   => $request['end_time']
            );
            $previous_seconds = 0;
            foreach ($get_project_work_diary as $key => $project_diary) 
            {
                $active_scenario_data = array(
                    "start_time" => $project_diary['start_time'],
                    "end_time"   => $project_diary['end_time'],
                    "id"         => $project_diary['id']
                );
                if($this->set_of_time_day_validate($active_scenario_data,$requested_scenario_data))
                {
                    if($project_diary['date'] == $request['date'])
                    {
                        $validate['status']  = false;
                        $validate['message'] = "Your cannot overlap your time entry for ".$request['start_time']."(UTC).";
                        return $validate;
                    }
                }
                $previous_seconds = $previous_seconds + (strtotime($project_diary['end_time'])-strtotime($project_diary['start_time'])); 
            }
            if(($previous_seconds + $request_no_of_seconds) > ($project_id->no_of_hours*60*60))
            {
                $validate['status']  = false;
                $validate['message'] = "Your no of hours is increased.";
                return $validate;
            }
        }
        return $validate;
    }
    public function set_of_time_day_validate($slice_time,$time_lie_in_slice_time)
{
    // to check set of time validation start time and end time
    $status = false;
    $slice_time['convert_start_time'] = strtotime($slice_time['start_time']);
    $slice_time['convert_end_time'] = strtotime($slice_time['end_time']);
    $time_lie_in_slice_time['convert_start_time'] = strtotime($time_lie_in_slice_time['start_time']);
    $time_lie_in_slice_time['convert_end_time'] = strtotime($time_lie_in_slice_time['end_time']);
    if($slice_time['convert_start_time'] < $time_lie_in_slice_time['convert_start_time'] &&   $slice_time['convert_start_time'] < $time_lie_in_slice_time['convert_end_time']  &&   $slice_time['convert_end_time'] > $time_lie_in_slice_time['convert_start_time']  &&   $slice_time['convert_end_time'] <= $time_lie_in_slice_time['convert_end_time'])
    {
        $status = true;
    }
    else if($slice_time['convert_start_time'] > $time_lie_in_slice_time['convert_start_time'] && $slice_time['convert_start_time'] < $time_lie_in_slice_time['convert_end_time'] &&
        $slice_time['convert_end_time'] > $time_lie_in_slice_time['convert_start_time'] && $slice_time['convert_end_time'] >= $time_lie_in_slice_time['convert_end_time'])
    {
        $status = true;
    }
    else if($slice_time['convert_start_time'] <= $time_lie_in_slice_time['convert_start_time'] && $slice_time['convert_start_time'] < $time_lie_in_slice_time['convert_end_time'] &&
            $slice_time['convert_end_time'] > $time_lie_in_slice_time['convert_start_time'] &&
            $slice_time['convert_end_time'] > $time_lie_in_slice_time['convert_end_time'])
    {
        $status = true;
    }
    else if($slice_time['convert_start_time'] == $time_lie_in_slice_time['convert_start_time']&& $slice_time['convert_start_time'] < $time_lie_in_slice_time['convert_end_time'] &&
        $slice_time['convert_end_time'] > $time_lie_in_slice_time['convert_start_time'] && $slice_time['convert_end_time'] <= $time_lie_in_slice_time['convert_end_time'])
    {
        $status = true;
    }
    else if($slice_time['convert_start_time'] > $time_lie_in_slice_time['convert_start_time'] && $slice_time['convert_start_time'] < $time_lie_in_slice_time['convert_end_time'] && $slice_time['convert_end_time'] > $time_lie_in_slice_time['convert_start_time'] && $slice_time['convert_end_time'] < $time_lie_in_slice_time['convert_end_time'])
    {
        $status = true;
    }
    return $status;
}
    // public function set_of_time_day_validate($active_scenario_data,$requested_scenario_data)
    // {
    //     // to check set of time validation start time and end time
    //     $status = true;
    //     $active_scenario_data['convert_start_time'] = strtotime($active_scenario_data['start_time']);
    //     $active_scenario_data['convert_end_time'] = strtotime($active_scenario_data['end_time']);
    //     $requested_scenario_data['convert_start_time'] = strtotime($requested_scenario_data['start_time']);
    //     $requested_scenario_data['convert_end_time'] = strtotime($requested_scenario_data['end_time']);
    //     if($active_scenario_data['convert_start_time'] < $requested_scenario_data['convert_start_time'] && $active_scenario_data['convert_start_time'] < $requested_scenario_data['convert_end_time'] && $active_scenario_data['convert_end_time'] >= $requested_scenario_data['convert_start_time'] && $active_scenario_data['convert_end_time'] < $requested_scenario_data['convert_end_time'])
    //     {
    //         $status = $this->check_days_validation($active_scenario_data['days'],$requested_scenario_data['days']);
    //     }
    //     elseif($active_scenario_data['convert_start_time'] > $requested_scenario_data['convert_start_time'] && $active_scenario_data['convert_start_time'] <= $requested_scenario_data['convert_end_time'] && $active_scenario_data['convert_end_time'] > $requested_scenario_data['convert_start_time'] && $active_scenario_data['convert_end_time'] >= $requested_scenario_data['convert_start_time'])
    //     {
    //         $status = $this->check_days_validation($active_scenario_data['days'],$requested_scenario_data['days']);
    //     }
    //     elseif($active_scenario_data['convert_start_time'] == $requested_scenario_data['convert_start_time'] && $active_scenario_data['convert_start_time'] < $requested_scenario_data['convert_end_time'] && $active_scenario_data['convert_end_time'] > $requested_scenario_data['convert_start_time'] && $active_scenario_data['convert_end_time'] == $requested_scenario_data['convert_end_time'])
    //     {
    //         $status = $this->check_days_validation($active_scenario_data['days'],$requested_scenario_data['days']);
    //     }
    //     elseif($active_scenario_data['convert_start_time'] < $requested_scenario_data['convert_start_time'] && $active_scenario_data['convert_start_time'] < $requested_scenario_data['convert_end_time'] && $active_scenario_data['convert_end_time'] > $requested_scenario_data['convert_start_time'] && $active_scenario_data['convert_end_time'] > $requested_scenario_data['convert_start_time'])
    //     {
    //         $status = $this->check_days_validation($active_scenario_data['days'],$requested_scenario_data['days']);
    //     }
    //     elseif($active_scenario_data['convert_start_time'] == $requested_scenario_data['convert_start_time'] && $active_scenario_data['convert_start_time'] < $requested_scenario_data['convert_end_time'] && $active_scenario_data['convert_end_time'] > $requested_scenario_data['convert_start_time'] && $active_scenario_data['convert_end_time'] <= $requested_scenario_data['convert_end_time'])
    //     {
    //         $status = $this->check_days_validation($active_scenario_data['days'],$requested_scenario_data['days']);
    //     }
    //     return $status;
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // Backup function
    public function showEmployerWorkDiaryBack($slug,$status,$id)
    {
        $project_id = $id;


        $profile = array();
        $accepted_proposal = array();
        $freelancer_name = '';
        $profile_image = '';
        $user_slug = '';
        $attachments = array();
        $job = Job::where('slug', $slug)->first();
        $accepted_proposal = Job::find($job->id)->proposals()->where('hired', 1)
            ->first();
        $proposal_id = Proposal::where('job_id', $id)->where('hired', 1)->first();

        $freelancer_name = Helper::getUserName($accepted_proposal->freelancer_id);
        $completion_time = !empty($accepted_proposal->completion_time) ?
            Helper::getJobDurationList($accepted_proposal->completion_time) : '';
        $profile = User::find($accepted_proposal->freelancer_id)->profile;
        $attachments = !empty($accepted_proposal->attachments) ? unserialize($accepted_proposal->attachments) : '';
        $user_image = !empty($profile) ? $profile->avater : '';
        $profile_image = !empty($user_image) ? '/uploads/users/' . $accepted_proposal->freelancer_id . '/' . $user_image : 'images/user-login.png';
        $employer_name = Helper::getUserName($job->user_id);
        $project_status = Helper::getProjectStatus();
        $duration = !empty($job->duration) ? Helper::getJobDurationList($job->duration) : '';
        $review_options = DB::table('review_options')->get()->all();
        $user_slug = User::find($accepted_proposal->freelancer_id)->slug;
        $feedbacks = Review::select('feedback')->where('receiver_id', $accepted_proposal->freelancer_id)->count();
        $avg_rating = Review::where('receiver_id', $accepted_proposal->freelancer_id)->sum('avg_rating');
        $rating  = $avg_rating != 0 ? round($avg_rating/Review::count()) : 0;
        $reviews = Review::where('receiver_id', $accepted_proposal->freelancer_id)->get();
        $stars  = $reviews->sum('avg_rating') != 0 ? (($reviews->sum('avg_rating')/$feedbacks)/5)*100 : 0;
        $average_rating_count = !empty($feedbacks) ? $reviews->sum('avg_rating')/$feedbacks : 0;
        $currency   = SiteManagement::getMetaValue('commision');
        $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $cancel_proposal_text = trans('lang.cancel_proposal_text');
        $cancel_proposal_button = trans('lang.send_request');
        $validation_error_text = trans('lang.field_required');
        $cancel_popup_title = trans('lang.reason');

        $bill_hours = WorkDiary::where('project_id', $project_id)->get()->all();

        $week_days = array ('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday');
        
        $current_week = WorkDiary::where('project_id', $project_id)->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

       $monday = WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Monday'])->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('hours');

        $tuesday =  WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Tuesday'])->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('hours');
        $wednesday = WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Wednesday'])->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('hours');
        $thursday = WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Thursday'])->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('hours');
        $friday =  WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Friday'])->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('hours');
        $saturday = WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Saturday'])->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('hours');
        $sunday = WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Sunday'])->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('hours');
        $total_hours = $monday + $tuesday + $wednesday + $thursday + $friday +  $saturday + $sunday;

         $previous_bill = WorkDiary::where('project_id', $project_id)->whereBetween('date', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])->first();

        /* Wallet Amount Show Work Start */
        $user_id = Auth::user()->id;
        $total_job_wallet_amount =  Wallet::where('job_id', $project_id)->where('employer_id', $user_id)->sum('amount');
        /* Wallet Amount Show Work End */

        if (file_exists(resource_path('views/extend/back-end/employer/jobs/workdiary.blade.php'))) {
            return view(
                'extend.back-end.employer.jobs.workdiary',
                compact(
                    'average_rating_count',
                    'job',
                    'duration',
                    'accepted_proposal',
                    'project_status',
                    'employer_name',
                    'profile_image',
                    'completion_time',
                    'freelancer_name',
                    'attachments',
                    'review_options',
                    'user_slug',
                    'stars',
                    'rating',
                    'feedbacks',
                    'symbol',
                    'cancel_proposal_text',
                    'cancel_proposal_button',
                    'validation_error_text',
                    'cancel_popup_title',
                    'week_days',
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                    'total_hours',
                    'current_week',
                    'proposal_id',
                    'previous_bill',
                    'project_id',
                    'total_job_wallet_amount'
                )
            );
        } else {
            return view(
                'back-end.employer.jobs.workdiary',
                compact(
                    'average_rating_count',
                    'job',
                    'duration',
                    'accepted_proposal',
                    'project_status',
                    'employer_name',
                    'profile_image',
                    'completion_time',
                    'freelancer_name',
                    'attachments',
                    'review_options',
                    'user_slug',
                    'stars',
                    'rating',
                    'feedbacks',
                    'symbol',
                    'cancel_proposal_text',
                    'cancel_proposal_button',
                    'validation_error_text',
                    'cancel_popup_title',
                    'week_days',
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                    'total_hours',
                    'current_week',
                    'proposal_id',
                    'previous_bill',
                    'project_id',
                    'total_job_wallet_amount'
                )
            );
        }
    }

    //After Update
    public function showEmployerWorkDiary($slug,$status,$id)
    {
        $project_id = $id;


        $profile = array();
        $accepted_proposal = array();
        $freelancer_name = '';
        $profile_image = '';
        $user_slug = '';
        $attachments = array();
        $job = Job::where('slug', $slug)->first();
        $accepted_proposal = Job::find($job->id)->proposals()->where('hired', 1)
            ->first();
        $proposal_id = Proposal::where('job_id', $id)->where('hired', 1)->first();

        $freelancer_name = Helper::getUserName($accepted_proposal->freelancer_id);
        $completion_time = !empty($accepted_proposal->completion_time) ?
            Helper::getJobDurationList($accepted_proposal->completion_time) : '';
        $profile = User::find($accepted_proposal->freelancer_id)->profile;
        $attachments = !empty($accepted_proposal->attachments) ? unserialize($accepted_proposal->attachments) : '';
        $user_image = !empty($profile) ? $profile->avater : '';
        $profile_image = !empty($user_image) ? '/uploads/users/' . $accepted_proposal->freelancer_id . '/' . $user_image : 'images/user-login.png';
        $employer_name = Helper::getUserName($job->user_id);
        $project_status = Helper::getProjectStatus();
        $duration = !empty($job->duration) ? Helper::getJobDurationList($job->duration) : '';
        $review_options = DB::table('review_options')->get()->all();
        $user_slug = User::find($accepted_proposal->freelancer_id)->slug;
        $feedbacks = Review::select('feedback')->where('receiver_id', $accepted_proposal->freelancer_id)->count();
        $avg_rating = Review::where('receiver_id', $accepted_proposal->freelancer_id)->sum('avg_rating');
        $rating  = $avg_rating != 0 ? round($avg_rating/Review::count()) : 0;
        $reviews = Review::where('receiver_id', $accepted_proposal->freelancer_id)->get();
        $stars  = $reviews->sum('avg_rating') != 0 ? (($reviews->sum('avg_rating')/$feedbacks)/5)*100 : 0;
        $average_rating_count = !empty($feedbacks) ? $reviews->sum('avg_rating')/$feedbacks : 0;
        $currency   = SiteManagement::getMetaValue('commision');
        $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $cancel_proposal_text = trans('lang.cancel_proposal_text');
        $cancel_proposal_button = trans('lang.send_request');
        $validation_error_text = trans('lang.field_required');
        $cancel_popup_title = trans('lang.reason');

        //$bill_hours = WorkDiary::where('project_id', $project_id)->get()->all();
        $bill_hours = WorkDiary::where('status','!=', 'pending')->where('project_id', $project_id)->orderBy('WeekDay','ASC')->get()->toArray();
        
        /* Start */
        if(!empty($_GET['filter']))
        {
            $filter_start_day = date("l",strtotime($_GET['start_date']));
            $filter_end_day = date("l",strtotime($_GET['end_date']));
            
            if($filter_start_day == "Monday")
                $filter_start_offset_day = 0;
            elseif($filter_start_day =="Tuesday")
                $filter_start_offset_day = 1;
            elseif($filter_start_day == "Wednesday")
                $filter_start_offset_day = 2;
            elseif($filter_start_day == "Thursday")
                $filter_start_offset_day = 3;
            elseif($filter_start_day == "Friday")
                $filter_start_offset_day = 4;
            elseif($filter_start_day == "Saturday")
                $filter_start_offset_day = 5;
            else
                $filter_start_offset_day = 6;            
            
            $start_date = date('Y-m-d', strtotime($_GET['start_date'] . '-'.$filter_start_offset_day.' day'));
             
            if($filter_end_day == "Monday")
                $filter_end_offset_day = 6;
            elseif($filter_end_day =="Tuesday")
                $filter_end_offset_day = 5;
            elseif($filter_end_day == "Wednesday")
                $filter_end_offset_day = 4;
            elseif($filter_end_day == "Thursday")
                $filter_end_offset_day = 3;
            elseif($filter_end_day == "Friday")
                $filter_end_offset_day = 2;
            elseif($filter_end_day == "Saturday")
                $filter_end_offset_day = 1;
            else
                $filter_end_offset_day = 0; 

            $end_date = date('Y-m-d', strtotime($_GET['end_date'] . '+'.$filter_end_offset_day.' day'));
        }
        else
        {
            $today_day = date("l");

            if($today_day == "Monday")
                $offset_day = 1;
            elseif($today_day =="Tuesday")
                $offset_day = 2;
            elseif($today_day == "Wednesday")
                $offset_day = 3;
            elseif($today_day == "Thursday")
                $offset_day = 4;
            elseif($today_day == "Friday")
                $offset_day = 5;
            elseif($today_day == "Saturday")
                $offset_day = 6;
            else
                $offset_day = 7;
            $end_date = date('Y-m-d', strtotime($today_day . '-'.$offset_day.' day'));
            $start_offset = $offset_day + 27;
            $start_date = date('Y-m-d', strtotime($today_day . ' -'.$start_offset.' day'));
            
        }

        // $today_day = date("l");

        // if($today_day == "Monday")
        //     $offset_day = 1;
        // elseif($today_day =="Tuesday")
        //     $offset_day = 2;
        // elseif($today_day == "Wednesday")
        //     $offset_day = 3;
        // elseif($today_day == "Thursday")
        //     $offset_day = 4;
        // elseif($today_day == "Friday")
        //     $offset_day = 5;
        // elseif($today_day == "Saturday")
        //     $offset_day = 6;
        // else
        //     $offset_day = 7;


        // $end_date = date('Y-m-d', strtotime($today_day . ' -'.$offset_day.' day'));
        // $start_date = date('Y-m-d', strtotime($today_day . ' -28 day'));
        $project_hours_data = [];
        if(!empty($bill_hours))
        {
            $StartWeekNumber = date('W',strtotime($bill_hours[count($bill_hours)-1]['date']));
            for($start = strtotime($start_date) ; $start <= strtotime($end_date) ; $start= $start + 604800)
            {
                $WeekNumber = date('W',$start);
                if($StartWeekNumber <= $WeekNumber)
                {
                    
                    $week_hours = [];
                    $total_hours = 0;
                    for($inner_loop = $start; $inner_loop < ($start + 604800) ; $inner_loop = $inner_loop + 86400) 
                    {   
                        
                        $no_of_hours = $this->sum_no_of_hours(date('Y-m-d',$inner_loop),$bill_hours);
                        $week_hours[date("l",$inner_loop)] = array(
                            "no_of_hours" => $no_of_hours,
                            "date" => date('m/d',$inner_loop),
                            "day" => date("l",$inner_loop)
                        );
                        $total_hours = $total_hours + $no_of_hours;
                    }
                    
                    $is_show_pay_button = WorkDiary::where('status', 'submitted')->where('project_id', $project_id)->whereBetween('date', [date('Y-m-d',strtotime($week_hours['Monday']['date'])),date('Y-m-d',strtotime($week_hours['Sunday']['date']))])->get()->toArray();
                    $project_hours_data[] = array(
                        "total_hours" => $total_hours,
                        "week_hours" => $week_hours,
                        "is_show_pay_button" => !empty($is_show_pay_button) ? 1 : 0 
                    );    
                }
            }
        }
        $project_hours_data = array_reverse($project_hours_data);
        $previous_hours_data = [];
        // print_r("<pre>");
        // print_r($project_hours_data);
        // print_r("+++++++++++++++++++++++++++++++++");
        if(!empty($project_hours_data))
        {
            $previous_hours_data = $project_hours_data[0];   
            unset($project_hours_data[0]);
            $project_hours_data = array_values($project_hours_data);
        }
        // print_r("<pre>");
        // print_r($previous_hours_data);
        // print_r("------------------------------");
        // print_r($project_hours_data);
        // exit();
        /* End */

        $week_days = array ('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday');
        
        $current_start_week = date('Y-m-d', strtotime("this week"));
        $current_end_date = date('Y-m-d', strtotime($current_start_week . '+6 day'));

        $current_week = WorkDiary::where('project_id', $project_id)->whereBetween('date', [$current_start_week, $current_end_date])->get();
        $paid_current_week = WorkDiary::where('status', 'paid')->where('project_id', $project_id)->whereBetween('date', [$current_start_week, $current_end_date])->get()->toArray();
        
        if(!empty($paid_current_week))
        {
            $show_current_week_pay_out_button =  2;
        }
        else
        {
            $show_current_week_pay_out_button =  1;
        }
        if(empty($bill_hours))
            $show_current_week_pay_out_button =  0;   
        
        $monday = WorkDiary::where('status','!=', 'pending')->where('project_id', $project_id)->where('WeekDay', $week_days['Monday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');

        $tuesday =  WorkDiary::where('status','!=', 'pending')->where('project_id', $project_id)->where('WeekDay', $week_days['Tuesday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $wednesday = WorkDiary::where('status','!=', 'pending')->where('project_id', $project_id)->where('WeekDay', $week_days['Wednesday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $thursday = WorkDiary::where('status','!=', 'pending')->where('project_id', $project_id)->where('WeekDay', $week_days['Thursday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $friday =  WorkDiary::where('status','!=', 'pending')->where('project_id', $project_id)->where('WeekDay', $week_days['Friday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $saturday = WorkDiary::where('status','!=', 'pending')->where('project_id', $project_id)->where('WeekDay', $week_days['Saturday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $sunday = WorkDiary::where('status','!=', 'pending')->where('project_id', $project_id)->where('WeekDay', $week_days['Sunday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $total_hours = $monday + $tuesday + $wednesday + $thursday + $friday +  $saturday + $sunday;

         $previous_bill = WorkDiary::where('project_id', $project_id)->whereBetween('date', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])->first();
        //   print_r("<pre>");
        // print_r($project_hours_data);
        // exit();

        /* Wallet Amount Show Work Start */
        $user_id = Auth::user()->id;
        $total_job_wallet_amount =  Wallet::where('job_id', $project_id)->where('employer_id', $user_id)->sum('amount');
        /* Wallet Amount Show Work End */

        if (file_exists(resource_path('views/extend/back-end/employer/jobs/workdiary.blade.php'))) {
            return view(
                'extend.back-end.employer.jobs.workdiary',
                compact(
                    'average_rating_count',
                    'job',
                    'duration',
                    'accepted_proposal',
                    'project_status',
                    'employer_name',
                    'profile_image',
                    'completion_time',
                    'freelancer_name',
                    'attachments',
                    'review_options',
                    'user_slug',
                    'stars',
                    'rating',
                    'feedbacks',
                    'symbol',
                    'cancel_proposal_text',
                    'cancel_proposal_button',
                    'validation_error_text',
                    'cancel_popup_title',
                    'week_days',
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                    'total_hours',
                    'current_week',
                    'proposal_id',
                    'previous_bill',
                    'project_id',
                    'project_hours_data',
                    'total_job_wallet_amount',
                    'show_current_week_pay_out_button',
                    'previous_hours_data'
                )
            );
        } else {
            return view(
                'back-end.employer.jobs.workdiary',
                compact(
                    'average_rating_count',
                    'job',
                    'duration',
                    'accepted_proposal',
                    'project_status',
                    'employer_name',
                    'profile_image',
                    'completion_time',
                    'freelancer_name',
                    'attachments',
                    'review_options',
                    'user_slug',
                    'stars',
                    'rating',
                    'feedbacks',
                    'symbol',
                    'cancel_proposal_text',
                    'cancel_proposal_button',
                    'validation_error_text',
                    'cancel_popup_title',
                    'week_days',
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                    'total_hours',
                    'current_week',
                    'proposal_id',
                    'previous_bill',
                    'project_id',
                    'project_hours_data',
                    'total_job_wallet_amount',
                    'show_current_week_pay_out_button',
                    'previous_hours_data'
                )
            );
        }
    }

    public function EmployerWorkDiaryPayNow($job_id,$start_date,$end_date)
    {
        //Wallet Amount get
        /* Wallet Amount Show Work Start */
        $user_id = Auth::user()->id;
        $total_job_wallet_amount =  Wallet::where('job_id', $job_id)->where('employer_id', $user_id)->sum('amount');
        /* Wallet Amount Show Work End */

        $bill_hours = WorkDiary::where('status', 'submitted')->whereBetween('date', [$start_date, $end_date])->where('project_id', $job_id)->orderBy('WeekDay','ASC')->get()->toArray();
        $proposal = Proposal::where('job_id',$job_id)->where('status','hired')->first();
        
        if(empty($bill_hours))
        {
            //No Entry has been submitted yet
            Session::flash('error', "heeeee");
            return Redirect::back();
        }
        else
        {
            $total_hours = WorkDiary::where('status', 'submitted')->whereBetween('date', [$start_date, $end_date])->where('project_id', $job_id)->where('project_id', $job_id)->orderBy('WeekDay','ASC')->sum('hours');
            $job = Job::where('id',$job_id)->first();
            $total_job_amount = $proposal->amount * $total_hours;

            //To verify where we redirect checkout Or this controller
            if($total_job_amount < $total_job_wallet_amount || $total_job_amount == 0)
            {
                //Status Change paid Work Diary page start
                foreach ($bill_hours as $key => $bill) 
                {
                    $stauts_change = WorkDiary::where('id', $bill['id'])->where('status','submitted')->update(array ('status' => 'paid'));
                }
                //Status Change paid Work Diary page end

                //Wallet Debit Entry Start
                $wallet_data = array(
                            "type" => "debit",
                            "job_id" => $job->id,
                            "employer_id" => Auth::user()->id,
                            "freelancer_id" => 0,
                            "description" => "Intiallly Freelance debit First Week Amount",
                            "amount" => -$total_job_amount,
                            "wallet_type" => "employer"   
                        );
                Wallet::createentry($wallet_data);
                //Wallet Debit Entry End

                
                //Payout Entry Admin to freelance start
                $work_diaries_ids = implode(",",array_column($bill_hours, 'id'));
                $payout_data = array(
                            "job_id" => $job->id,
                            "freelance_id" => $proposal->freelancer_id,
                            "start_date" => $start_date,
                            "end_date" => $end_date,
                            "work_diaries_ids" => $work_diaries_ids,
                            "amount" => $total_job_amount   
                        );
                HourlyJobPayOut::createentry($payout_data);
                //Payout Entry Admin to freelance end
                return Redirect::back();
            }
            elseif($total_job_wallet_amount > 0)
            {
                $checkout_amount = $total_job_amount - $total_job_wallet_amount;   
                //checkout start
                return $this->CheckoutView($user_id,$proposal,$checkout_amount,0,$start_date,$end_date);    
                //checkout end
                
                //PaypalController@getExpressCheckout

                //Checkout success per Status Change paid Work Diary page 
                //Checkout success per debit wallet entry
                //Checkout success per payout entry
            }
            else
            {
                //Checkout success per Status Change paid Work Diary page
                $checkout_amount = $total_job_amount;
                
                //checkout start
                return $this->CheckoutView($user_id,$proposal,$checkout_amount,1,$start_date,$end_date);    
                //checkout end
            }
        }
    }

    public function CheckoutView($user_id,$proposal,$checkout_amount,$is_whole_checkout_amount,$start_date,$end_date)
    {
        $employer = User::find($user_id);
        $job = $proposal->job;
        $freelancer = User::find($proposal->freelancer_id);
        $freelancer_name = Helper::getUserName($proposal->freelancer_id);
        $profile = User::find($proposal->freelancer_id)->profile;
        $attachments = !empty($proposal->attachments) ? unserialize($proposal->attachments) : '';
        $user_image = !empty($profile) ? $profile->avater : '';
        $profile_image = !empty($user_image) ? '/uploads/users/' . $proposal->freelancer_id . '/' . $user_image : 'images/user-login.png';
        $payout_settings = SiteManagement::getMetaValue('commision');
        $payment_gateway = !empty($payout_settings) && !empty($payout_settings[0]['payment_method']) ? $payout_settings[0]['payment_method'] : null;
        $currency   = SiteManagement::getMetaValue('commision');
        $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $commision_amount = 0;
        
        if(!empty($payout_settings) && !empty($payout_settings[0]['commision']))
        {
            $commision_amount = ($payout_settings[0]['commision']/100)*$checkout_amount;
            $total_amount = $checkout_amount + $commision_amount;
        }
        else
        {
            $total_amount = $checkout_amount;
        }
        if (session()->get('project_type') == 'service')
        {
            session()->forget('project_type');
        }
        if (file_exists(resource_path('views/extend/back-end/employer/jobs/workdiay_checkout.blade.php'))) {
            return view(
                        'extend.back-end.employer.jobs.checkout',
                        compact(
                            'job',
                            'freelancer_name',
                            'profile_image',
                            'proposal',
                            'payment_gateway',
                            'symbol',
                            'total_amount',
                            'commision_amount',
                            'checkout_amount',
                            'is_whole_checkout_amount',
                            'start_date',
                            'end_date'
                        )
                    );
        } else {
           return view(
                        'back-end.employer.jobs.workdiay_checkout',
                        compact(
                            'job',
                            'freelancer_name',
                            'profile_image',
                            'proposal',
                            'payment_gateway',
                            'symbol',
                            'total_amount',
                            'commision_amount',
                            'checkout_amount',
                            'is_whole_checkout_amount',
                            'start_date',
                            'end_date'
                        )
                    );
        }
    }


    public function showFreelancerWorkDiary($slug,$status,$id)
    {
        $project_id = $id;
        //dd($project_id);
        //print($project_id);

        $profile = array();
        $accepted_proposal = array();
        $freelancer_name = '';
        $profile_image = '';
        $user_slug = '';
        $attachments = array();
        $job = Job::where('slug', $slug)->first();
        $accepted_proposal = Job::find($job->id)->proposals()->where('hired', 1)
            ->first();
        $freelancer_name = Helper::getUserName($accepted_proposal->freelancer_id);
        $completion_time = !empty($accepted_proposal->completion_time) ?
            Helper::getJobDurationList($accepted_proposal->completion_time) : '';
        $profile = User::find($accepted_proposal->freelancer_id)->profile;
        $attachments = !empty($accepted_proposal->attachments) ? unserialize($accepted_proposal->attachments) : '';
        $user_image = !empty($profile) ? $profile->avater : '';
        $profile_image = !empty($user_image) ? '/uploads/users/' . $accepted_proposal->freelancer_id . '/' . $user_image : 'images/user-login.png';
        $employer_name = Helper::getUserName($job->user_id);
        $project_status = Helper::getProjectStatus();
        $duration = !empty($job->duration) ? Helper::getJobDurationList($job->duration) : '';
        $review_options = DB::table('review_options')->get()->all();
        $user_slug = User::find($accepted_proposal->freelancer_id)->slug;
        $feedbacks = Review::select('feedback')->where('receiver_id', $accepted_proposal->freelancer_id)->count();
        $avg_rating = Review::where('receiver_id', $accepted_proposal->freelancer_id)->sum('avg_rating');
        $rating  = $avg_rating != 0 ? round($avg_rating/Review::count()) : 0;
        $reviews = Review::where('receiver_id', $accepted_proposal->freelancer_id)->get();
        $stars  = $reviews->sum('avg_rating') != 0 ? (($reviews->sum('avg_rating')/$feedbacks)/5)*100 : 0;
        $average_rating_count = !empty($feedbacks) ? $reviews->sum('avg_rating')/$feedbacks : 0;
        $currency   = SiteManagement::getMetaValue('commision');
        $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $cancel_proposal_text = trans('lang.cancel_proposal_text');
        $cancel_proposal_button = trans('lang.send_request');
        $validation_error_text = trans('lang.field_required');
        $cancel_popup_title = trans('lang.reason');
        
        $bill_hours = WorkDiary::where('project_id', $project_id)->get()->all();

        /* Start */
        if(!empty($_GET['filter']))
        {
            $filter_start_day = date("l",strtotime($_GET['start_date']));
            $filter_end_day = date("l",strtotime($_GET['end_date']));
            
            if($filter_start_day == "Monday")
                $filter_start_offset_day = 0;
            elseif($filter_start_day =="Tuesday")
                $filter_start_offset_day = 1;
            elseif($filter_start_day == "Wednesday")
                $filter_start_offset_day = 2;
            elseif($filter_start_day == "Thursday")
                $filter_start_offset_day = 3;
            elseif($filter_start_day == "Friday")
                $filter_start_offset_day = 4;
            elseif($filter_start_day == "Saturday")
                $filter_start_offset_day = 5;
            else
                $filter_start_offset_day = 6;            
            
            $start_date = date('Y-m-d', strtotime($_GET['start_date'] . '-'.$filter_start_offset_day.' day'));
             
            if($filter_end_day == "Monday")
                $filter_end_offset_day = 6;
            elseif($filter_end_day =="Tuesday")
                $filter_end_offset_day = 5;
            elseif($filter_end_day == "Wednesday")
                $filter_end_offset_day = 4;
            elseif($filter_end_day == "Thursday")
                $filter_end_offset_day = 3;
            elseif($filter_end_day == "Friday")
                $filter_end_offset_day = 2;
            elseif($filter_end_day == "Saturday")
                $filter_end_offset_day = 1;
            else
                $filter_end_offset_day = 0; 

            $end_date = date('Y-m-d', strtotime($_GET['end_date'] . '+'.$filter_end_offset_day.' day'));
        }
        else
        {
            $today_day = date("l");

            if($today_day == "Monday")
                $offset_day = 1;
            elseif($today_day =="Tuesday")
                $offset_day = 2;
            elseif($today_day == "Wednesday")
                $offset_day = 3;
            elseif($today_day == "Thursday")
                $offset_day = 4;
            elseif($today_day == "Friday")
                $offset_day = 5;
            elseif($today_day == "Saturday")
                $offset_day = 6;
            else
                $offset_day = 7;
            $end_date = date('Y-m-d', strtotime($today_day . '-'.$offset_day.' day'));
            $start_offset = $offset_day + 27;
            $start_date = date('Y-m-d', strtotime($today_day . ' -'.$start_offset.' day'));
            
        }

        // $today_day = date("l");

        // if($today_day == "Monday")
        //     $offset_day = 1;
        // elseif($today_day =="Tuesday")
        //     $offset_day = 2;
        // elseif($today_day == "Wednesday")
        //     $offset_day = 3;
        // elseif($today_day == "Thursday")
        //     $offset_day = 4;
        // elseif($today_day == "Friday")
        //     $offset_day = 5;
        // elseif($today_day == "Saturday")
        //     $offset_day = 6;
        // else
        //     $offset_day = 7;


        // $end_date = date('Y-m-d', strtotime($today_day . ' -'.$offset_day.' day'));
        // $start_date = date('Y-m-d', strtotime($today_day . ' -28 day'));
        $project_hours_data = [];

        if(!empty($bill_hours))
        {
            $StartWeekNumber = date('W',strtotime($bill_hours[count($bill_hours)-1]['date']));
            for($start = strtotime($start_date) ; $start <= strtotime($end_date) ; $start= $start + 604800)
            {
                $WeekNumber = date('W',$start);
                // print_r($StartWeekNumber."|".$WeekNumber);
                // exit();
                if($StartWeekNumber <= $WeekNumber)
                {
                    $week_hours = [];
                    $total_hours = 0;
                    for($inner_loop = $start; $inner_loop < ($start + 604800) ; $inner_loop = $inner_loop + 86400) 
                    {   
                        
                        $no_of_hours = $this->sum_no_of_hours(date('Y-m-d',$inner_loop),$bill_hours);
                        $week_hours[date("l",$inner_loop)] = array(
                            "no_of_hours" => $no_of_hours,
                            "date" => date('m/d',$inner_loop),
                            "day" => date("l",$inner_loop)
                        );
                        $total_hours = $total_hours + $no_of_hours;
                    }
                     $is_show_pay_button = WorkDiary::where('status', 'submitted')->where('project_id', $project_id)->whereBetween('date', [date('Y-m-d',strtotime($week_hours['Monday']['date'])),date('Y-m-d',strtotime($week_hours['Sunday']['date']))])->get()->toArray();

                    $project_hours_data[] = array(
                        "total_hours" => $total_hours,
                        "week_hours" => $week_hours,
                        "is_show_pay_button" => !empty($is_show_pay_button) ? 1 : 0 
                    );


                }
            }
        }

        $project_hours_data = array_reverse($project_hours_data);

        /* End */

        $week_days = array ('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday');
        
        $current_week = WorkDiary::where('project_id', $project_id)->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

        $current_start_week = date('Y-m-d', strtotime("this week"));
        $current_end_date = date('Y-m-d', strtotime($current_start_week . '+6 day'));
        
        $monday =  WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Monday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        
        $tuesday =  WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Tuesday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $wednesday = WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Wednesday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $thursday = WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Thursday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $friday =  WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Friday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $saturday = WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Saturday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $sunday = WorkDiary::where('project_id', $project_id)->where('WeekDay', $week_days['Sunday'])->whereBetween('date', [$current_start_week, $current_end_date])->sum('hours');
        $total_hours = $monday + $tuesday + $wednesday + $thursday + $friday +  $saturday + $sunday;

        
        $bill_status = WorkDiary::where('project_id', $project_id)->whereBetween('date', [$current_start_week, $current_end_date])->first();
        
        $previous_bill = WorkDiary::where('project_id', $project_id)->whereBetween('date', [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()])->first();


        /* Submit Add Hour Button Start */
        $submitted_week = WorkDiary::where('status','!=' ,'pending')->where('project_id', $project_id)->whereBetween('date', [$current_start_week, $current_end_date])->get()->toArray();
        if(empty($submitted_week))
            $is_show_add_hour_button = 1;
        else
            $is_show_add_hour_button = 0;
        /* Submit Add Hour Button End */

        if (file_exists(resource_path('views/extend/back-end/freelancer/jobs/bill.blade.php'))) {
            return view(
                'extend.back-end.freelancer.jobs.bill',
                compact(
                    'average_rating_count',
                    'job',
                    'duration',
                    'accepted_proposal',
                    'project_status',
                    'employer_name',
                    'profile_image',
                    'completion_time',
                    'freelancer_name',
                    'attachments',
                    'review_options',
                    'user_slug',
                    'stars',
                    'rating',
                    'feedbacks',
                    'symbol',
                    'cancel_proposal_text',
                    'cancel_proposal_button',
                    'validation_error_text',
                    'cancel_popup_title',
                    'bill_hours',
        
                    'week_days',
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                    'total_hours',
                    'current_week',
                    
                    'bill_status',
                    'previous_bill',
                    'project_hours_data',
                    'is_show_add_hour_button'
                )
            );
        } else {
            return view(
                'back-end.freelancer.jobs.bill',
                compact(
                    'average_rating_count',
                    'job',
                    'duration',
                    'accepted_proposal',
                    'project_status',
                    'employer_name',
                    'profile_image',
                    'completion_time',
                    'freelancer_name',
                    'attachments',
                    'review_options',
                    'user_slug',
                    'stars',
                    'rating',
                    'feedbacks',
                    'symbol',
                    'cancel_proposal_text',
                    'cancel_proposal_button',
                    'validation_error_text',
                    'cancel_popup_title',
                    'bill_hours',
                  
                    'week_days',
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                    'total_hours',
                    'current_week',
                    
                    'bill_status',
                    'previous_bill',
                    'project_hours_data',
                    'is_show_add_hour_button'
                )
            );
        }
    }

     public function submitFreelancerBill($id){

        $project_id = $id;
        $job = Job::where('slug', $slug)->first();

        $stauts = WorkDiary::where('project_id', $project_id)->where('status','pending')->update(array ( 'status' => 'submitted') );
         return Redirect::back();


     }

     public function sum_no_of_hours($date,$bill_hours)
    {
        $no_of_hours = 0;
        foreach ($bill_hours as $key => $value) 
        {
            if($value['date'] == $date)
            {
                $no_of_hours = $no_of_hours + $value['hours'];
            }
        }
        return $no_of_hours;
    }

}
