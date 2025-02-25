<?php

/**
 * Class PublicController
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers;

use App\Mail\FindMatchEmailAdminMailable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\User;
use Alert;
use App\AgencyUser;
use App\Cource;
use App\Blog;
use App\Language;
use App\FindMatchRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationMailable;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Redirect;
use Hash;
use Auth;
use DB;
use App\Helper;
use App\Profile;
use App\Category;
use App\Location;
use App\Skill;
use Session;
use Storage;
use App\Report;
use App\Job;
use App\Proposal;
use App\EmailTemplate;
use App\Mail\GeneralEmailMailable;
use App\Mail\AdminEmailMailable;

use App\SiteManagement;
use App\Review;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Payout;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use App\Service;
use App\DeliveryTime;
use App\ResponseTime;
use App\Article;
use App\Mail\SendMailable;
use App\Rules\Captcha;
/**
 * Class PublicController
 *
 */
class PublicController extends Controller
{

    /**
     * User Login Function
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
     public function generateCompletion(Request $request)
      {
          $prompt = $request->input('cmd');
          $completion = Helper::generateCompletion($prompt);

          return response()->json($completion);
      }
    public function loginUser(Request $request)
    {
        $json = array();
        if (Session::has('user_id')) {
            $id = Session::get('user_id');
            $user = User::find($id);
            Auth::login($user);
            $json['type'] = 'success';
            $json['role'] = $user->getRoleNames()->first();
            session()->forget('user_id');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }
    public function loginUserRole(Request $request)
    {
        $json = array();
        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            $json['type'] = 'success';
            $json['role'] = $user->getRoleNames()->first();
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Step1 Registeration Validation
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function registerStep1Validation(Request $request)
    {
        $this->validate(
            $request,
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
            ]
        );
        //$email = Session::get('email');
        $email = $request['email'];
        $request->session()->put('email', $email);
    }

    /**
     * Step2 Registeration Validation
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function registerStep2Validation(Request $request)
    {
        
       $this->validate(
            $request,
            [
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
                'termsconditions' => 'required',
                 'g-recaptcha-response' => new Captcha(),
            ]
       
        ); 
       
         $email_params = array();
         $email = Session::get('email');
         $code = Helper::generateRandomCode(4);
         $request->session()->put('code', $code);

        // $email_params = array();
        // $email = Session::get('email');
         // Mail::to($email)->send(new  SendMailable($data));  //This is Working 
        //$code= 1234;
      
        //Code my start 
      
       // $code = Helper::generateRandomCode(4);
      //  $request->session()->put('code', $code);
      //  Mail::to($email)->send(new  GeneralEmailMailable('verification_code','',['name' => Session::get('name'),'email' => Session::get('email'),'verification_code' => $code]));  
        
        //Code my end
         
        // Mail::to($email)->send(new  EmailVerificationMailable($code));       
        
        /*  $template = DB::table('email_types')->select('id')->where('email_type', 'verification_code')->get()->first();
                        if (!empty($template->id)) {
                           $template_data = 2;
                            $email_params['email'] = $email;
                           
                            Mail::to($email)
                                ->send(
                                    new GeneralEmailMailable(
                                        'verification_code',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        } */
       
       
    }

    /**
     * Set slug before saving in DB
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
  public function verifyUserCode(Request $request)
    {
        $json = array();
        if (Session::has('user_id')) {
            $id = Session::get('user_id');
            $email = Session::get('email');
                   
            $password = Session::get('password');
            $user = User::find($id);
            if (!empty($request['code'])) {
                if ($request['code'] === $user->verification_code) {
                    $user->user_verified = 1;
                    $user->verification_code = null;
                    $user->save();
                    $json['type'] = 'success';
                    //send mail
                    if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                        $email_params = array();
                        $template = DB::table('email_types')->select('id')->where('email_type', 'new_user')->get()->first();
                        if (!empty($template->id)) {
                            $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                            $email_params['name'] = Helper::getUserName($id);
                            $email_params['email'] = $email;
                            $email_params['password'] = $password;
                            Mail::to($email)
                                ->send(
                                    new GeneralEmailMailable(
                                        'new_user',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        }
                        $admin_template = DB::table('email_types')->select('id')->where('email_type', 'admin_email_registration')->get()->first();
                        if (!empty($template->id)) {
                            $template_data = EmailTemplate::getEmailTemplateByID($admin_template->id);
                            $email_params['name'] = Helper::getUserName($id);
                            $email_params['email'] = $email;
                            $email_params['link'] = url('profile/' . $user->slug);
                           // Mail::to(config('mail.username'))
                            Mail::to(getenv('MAIL_FROM_ADDRESS'))
                                ->send(
                                    new AdminEmailMailable(
                                        'admin_email_registration',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        } 
                     }
                    session()->forget('password');
                    session()->forget('email');
                    return $json;
                } else {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.invalid_verify_code');
                    return $json;
                }
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.verify_code');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.session_expire');
            return $json;
        }
    } 

    /**
     * Download file.
     *
     * @param type    $type     file type
     * @param string  $filename file typname
     * @param integer $id       id
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    function getFile($type, $filename, $id)
    {
        // dd(public_path());
        if (!empty($type) && !empty($filename) && !empty($id)) {
            if (public_path().'uploads/' . $type . '/' . $id . '/' . $filename) {
                $path = public_path('uploads/' . $type . '/' . $id . '/' . $filename);
                return response()->download($path);
            } else {
                Session::flash('error', trans('lang.file_not_found'));
                return Redirect::back();
            }
        } else {
            abort(404);
        }
    }


    function agencyView($slug)

    {
        $agency = null;

        if(!empty($slug)) {

            $agency = DB::table('agency_user')
                ->where('slug', '=', $slug)
                ->first();
            $agency_ = AgencyUser::find($agency->id);

                $skills = $agency_->skills()->get();
                $members = DB::table('agency_associated_users')
                ->where('agency_id', $agency->id)->where('is_pending', 0)->where('is_accepted',1)
                ->get();
                // dd($skills);
             
            if (!empty($agency)) {
                $agency = @json_decode(json_encode($agency), true);
                return View('front-end.agencies.profile-show', compact('agency','skills','members'));

            } else {
                abort(404);
            }
        } else {
            abort(404);
        }

    }

    /**
     * Show user profile.
     *
     * @param string $slug slug
     *
     * @return \Illuminate\Http\Response
     */
    public function showUserProfile($slug)
    {
        $user = User::select('id')->where('slug', $slug)->first();
        if (!empty($user)) {
            $user = User::find($user->id);
            if ($user->is_disabled == 'true') {
                abort(404);
            }
            $skills = $user->skills()->get();
            $job = Job::where('user_id', $user->id)->orderBy('id','desc')->get();
            $profile = Profile::all()->where('user_id', $user->id)->first();
            $percentage = $this->getProfileCompletionPercentage($profile);
            
            $reasons = Helper::getReportReasons();
            $avatar = !empty($profile->avater) ? '/uploads/users/' . $profile->user_id . '/' . $profile->avater : '/images/user.jpg';
            $banner = !empty($profile->banner) ? '/uploads/users/' . $profile->user_id . '/' . $profile->banner : Helper::getUserProfileBanner($user->id);
            $auth_user = Auth::user() ? true : false;
            $user_name = Helper::getUserName($profile->user_id);
            $current_date = Carbon::now()->format('M d, Y');
            $tagline = !empty($profile) ? $profile->tagline : '';
            $desc = !empty($profile) ? $profile->description : '';
            if ($user->getRoleNames()->first() === 'freelancer') {
                $services = array();
                if (Schema::hasTable('services') && Schema::hasTable('service_user')) {
                    $services = $user->services;
                }
                if (Schema::hasTable('cources') && Schema::hasTable('cource_user')) {
                    if (Schema::hasColumn('cource_user','cource_id') && Schema::hasColumn('cource_user','paid') && Schema::hasColumn('cource_user','paid_progress') && Schema::hasColumn('cource_user','status') && Schema::hasColumn('cource_user','type') && Schema::hasColumn('cource_user','seller_id') && Schema::hasColumn('cource_user','user_id')) {
                       $cources = Helper::getFreelancerCourses('posted', $user->id);
                }
            }
                $reviews = Review::where('receiver_id', $user->id)->orderBy('id','desc')->get();
                $awards = !empty($profile->awards) ? unserialize($profile->awards) : array();
                $projects = !empty($profile->projects) ? unserialize($profile->projects) : array();
                $experiences = !empty($profile->experience) ? unserialize($profile->experience) : array();
                usort($experiences, function ($a, $b) {
                    return strtotime($b['start_date']) - strtotime($a['start_date']);
                });
                $education = !empty($profile->education) ? unserialize($profile->education) : array();
                $freelancer_rating  = !empty($user->profile->ratings) ? Helper::getUnserializeData($user->profile->ratings) : 0;
                $rating = !empty($freelancer_rating) ? $freelancer_rating[0] : 0;
                $joining_date = !empty($profile->created_at) ? Carbon::parse($profile->created_at)->format('M d, Y') : '';
                $jobs = Job::select('title', 'id')->get()->pluck('title', 'id');
                $save_freelancer = !empty(auth()->user()->profile->saved_freelancer) ? unserialize(auth()->user()->profile->saved_freelancer) : array();
                $badge = Helper::getUserBadge($user->id);
                $feature_class = !empty($badge) ? 'wt-featured' : '';
                $badge_color = !empty($badge) ? $badge->color : '';
                $badge_img  = !empty($badge) ? $badge->image : '';
                $amount = Payout::where('user_id', $user->id)->select('amount')->pluck('amount')->first();
                $employer_projects = Auth::user() ? Helper::getEmployerJobs(Auth::user()->id) : array();
                $currency_symbol  = !empty($payment_settings) && !empty($payment_settings[0]['currency']) ? Helper::currencyList($payment_settings[0]['currency']) : array();
                $symbol = !empty($currency_symbol['symbol']) ? $currency_symbol['symbol'] : '$';
                $settings = !empty(SiteManagement::getMetaValue('settings')) ? SiteManagement::getMetaValue('settings') : array();
                $display_chat = !empty($settings[0]['chat_display']) ? $settings[0]['chat_display'] : false;
                $payment_settings = SiteManagement::getMetaValue('commision');
                $enable_package = !empty($payment_settings) && !empty($payment_settings[0]['enable_packages']) ? $payment_settings[0]['enable_packages'] : 'true';
                $videos = !empty($profile->videos) ? Helper::getUnserializeData($profile->videos) : '';
                if( !empty($videos) && $videos[0]["url"]==null ){
                    $videos = array();
                }
                $feedbacks = Review::select('feedback')->where('receiver_id', $user->id)->count(); 
                $average_rating_count = !empty($feedbacks) ? $reviews->sum('avg_rating')/$feedbacks : 0;
                if (file_exists(resource_path('views/extend/front-end/users/freelancer-show.blade.php'))) {
                    return View(
                        'extend.front-end.users.freelancer-show',
                        compact(
                            'average_rating_count',
                            'videos',
                            'services',
                            'cources',
                            'profile',
                            'amount',
                            'skills',
                            'user',
                            'job',
                            'reasons',
                            'reviews',
                            'avatar',
                            'banner',
                            'user_name',
                            'jobs',
                            'rating',
                            'education',
                            'experiences',
                            'projects',
                            'awards',
                            'joining_date',
                            'save_freelancer',
                            'auth_user',
                            'badge',
                            'feature_class',
                            'badge_color',
                            'badge_img',
                            'employer_projects',
                            'currency_symbol',
                            'current_date',
                            'symbol',
                            'tagline',
                            'desc',
                            'display_chat',
                            'enable_package',
                            'percentage'
                        )
                    );
                } else {
                    return View(
                        'front-end.users.freelancer-show',
                        compact(
                            'average_rating_count',
                            'videos',
                            'services',
                            'cources',
                            'profile',
                            'amount',
                            'skills',
                            'user',
                            'job',
                            'reasons',
                            'reviews',
                            'avatar',
                            'banner',
                            'user_name',
                            'jobs',
                            'rating',
                            'education',
                            'experiences',
                            'projects',
                            'awards',
                            'joining_date',
                            'save_freelancer',
                            'auth_user',
                            'badge',
                            'feature_class',
                            'badge_color',
                            'badge_img',
                            'employer_projects',
                            'currency_symbol',
                            'current_date',
                            'symbol',
                            'tagline',
                            'desc',
                            'display_chat',
                            'enable_package',
                            'percentage'
                        )
                    );
                }
            } elseif ($user->getRoleNames()->first() === 'employer') {
                $jobs = Job::where('user_id', $profile->user_id)->latest()->paginate(7);
                $followers = DB::table('followers')->where('following', $profile->user_id)->get();
                $save_employer = !empty(auth()->user()->profile->saved_employers) ? unserialize(auth()->user()->profile->saved_employers) : array();
                $save_jobs = !empty(auth()->user()->profile->saved_jobs) ? unserialize(auth()->user()->profile->saved_jobs) : array();
                $currency = SiteManagement::getMetaValue('commision');
                $symbol   = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
                $breadcrumbs_settings = SiteManagement::getMetaValue('show_breadcrumb');
                $show_breadcrumbs = !empty($breadcrumbs_settings) ? $breadcrumbs_settings : 'true';
                if (file_exists(resource_path('views/extend/front-end/users/employer-show.blade.php'))) {
                    return View(
                        'extend.front-end.users.employer-show',
                        compact(
                            'profile',
                            'skills',
                            'user',
                            'job',
                            'reasons',
                            'avatar',
                            'banner',
                            'user_name',
                            'jobs',
                            'followers',
                            'save_employer',
                            'save_jobs',
                            'auth_user',
                            'current_date',
                            'symbol',
                            'tagline',
                            'desc',
                            'show_breadcrumbs'
                        )
                    );
                } else {
                    return View(
                        'front-end.users.employer-show',
                        compact(
                            'profile',
                            'skills',
                            'user',
                            'job',
                            'reasons',
                            'avatar',
                            'banner',
                            'user_name',
                            'jobs',
                            'followers',
                            'save_employer',
                            'save_jobs',
                            'auth_user',
                            'current_date',
                            'symbol',
                            'tagline',
                            'desc',
                            'show_breadcrumbs'
                        )
                    );
                }
            }
        } else {
            abort(404);
        }
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
    /**
     * Get filtered list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFilterlist()
    {
        $json = array();
        $filters = Helper::getSearchFilterList();
        if (!empty($filters)) {
            $json['type'] = 'success';
            $json['result'] = $filters;
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }
    /**
     * Post Skill Data.
     *
     * @param mixed $request request->attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function saveSkillData(Request $request){

        $db_responce=DB::table('change_request')->insert(
            [
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'full_name' => $request['full_name'],
                'positions' => $request['positions'],
                'collaborative' => $request['collaborative'],
                'agile_approach' => $request['agile_approach'],
                'creative' => $request['creative'],
                'follower' => $request['follower'],
                'initiator' => $request['initiator'],
                'instructions_follower' => $request['instructions_follower'],
                'product_focus' => $request['product_focus'],
                'project_focused' => $request['project_focused'],
                'silent_shy' => $request['silent_shy'],
                'structed_methodical' => $request['structed_methodical'],
                'vocal_blunt' => $request['vocal_blunt'],
                'waterfall_approach' => $request['waterfall_approach'],
                'selected_categories' => $request['selectedCategories'],
                'selected_skills' => $request['selectedSkills']
            ]
        );

        // $findmatchRequest = new FindMatchRequest;
        // $findmatchRequest->email= $request['email'];
        // $findmatchRequest->phone_number= $request['phone_number'];
        // $findmatchRequest->full_name= $request['full_name'];
        // $findmatchRequest->positions= $request['positions'];
        // $findmatchRequest->collaborative= $request['collaborative'];
        // $findmatchRequest->agile_approach= $request['agile_approach'];
        // $findmatchRequest->creative= $request['creative'];
        // $findmatchRequest->follower= $request['follower'];
        // $findmatchRequest->initiator= $request['initiator'];
        // $findmatchRequest->instructions_follower= $request['instructions_follower'];
        // $findmatchRequest->product_focus= $request['product_focus'];
        // $findmatchRequest->project_focused= $request['project_focused'];
        // $findmatchRequest->silent_shy= $request['silent_shy'];
        // $findmatchRequest->structed_methodical= $request['structed_methodical'];
        // $findmatchRequest->vocal_blunt= $request['vocal_blunt'];
        // $findmatchRequest->waterfall_approach= $request['waterfall_approach'];
        // $findmatchRequest->selected_categories= $request['selectedCategories'];
        // $findmatchRequest->selected_skills= $request['selectedSkills'];
        // $findmatchRequest->save();
        // if($request['selectedCandidateHours']){
        //     foreach($request['selectedCandidateHours'])
        // }

        $data = [
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'full_name' => $request['full_name'],
            'positions' => $request['positions'],
            'collaborative' => $request['collaborative'],
            'agile_approach' => $request['agile_approach'],
            'creative' => $request['creative'],
            'follower' => $request['follower'],
            'initiator' => $request['initiator'],
            'instructions_follower' => $request['instructions_follower'],
            'product_focus' => $request['product_focus'],
            'project_focused' => $request['project_focused'],
            'silent_shy' => $request['silent_shy'],
            'structed_methodical' => $request['structed_methodical'],
            'vocal_blunt' => $request['vocal_blunt'],
            'waterfall_approach' => $request['waterfall_approach'],
            'selected_categories' => $request['selectedCategories'],
            'selected_skills' => $request['selectedSkills'],
            'selected_freelancers' => $request['selectedCandidateHours'],

        ];

        Mail::to('uraizy@gmail.com')->send(new  FindMatchEmailAdminMailable($data));


        $status['status']=true;
        return $status;
    }
    /**
     * Get searchable data.
     *
     * @param mixed $request request->attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function getSearchableData(Request $request)
    {
        $json = array();
        if (!empty($request['type'])) {
            $searchables = Helper::getSearchableList($request['type']);
            if (!empty($searchables)) {
                $json['type'] = 'success';
                $json['searchables'] = $searchables;
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Get search result.
     *
     * @param string $search_type search type
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserRelatedFreelancers()
    {
        $json = array();
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        if(!empty($user)){
        $profile = Profile::where('user_id',$user_id)->first();
        $user->user_image = asset(!empty($profile->avater) ? Helper::getUserImageWithSize('uploads/users/'.$profile->user_id, $profile->avater, 'listing') : '/images/user.jpg');
        $skills = $user->skills()->get();
        foreach ($skills as $key => $skill) {
            $skill_slugs[] = $skill->slug;
        }
        $search_skills = $skill_slugs;
        $h = 'user_skilll';
        $ids_to_skip = array();
        $user_by_role =  User::role(3)->pluck('id')->toArray();
        $skills = Skill::whereIn('slug', $search_skills)->get();
        $user->$h=$skills;
        foreach ($user->$h as $key => $skill) {
            $user_ids = array();
            $userid = DB::table('skill_user')->select('user_id')->where('skill_id',$skill->id)->get();
            foreach($userid as $ui){
                $user_ids[] = $ui->user_id;
            }
            $skill->relations =  User::whereIn('id', $user_by_role)->whereIn('id', $user_ids)->whereNotIn('id',$ids_to_skip)->where('id','!=',$user_id)->where('is_disabled', 'false')->where('status',1)->get();
            foreach($userid as $ui){
                $ids_to_skip[] = $ui->user_id;
            }
            foreach ($skill->relations as $key => $related_users) {
                $profile = Profile::where('user_id',$related_users->id)->first();
                $related_users->user_image = asset(!empty($profile->avater) ? Helper::getUserImageWithSize('uploads/users/'.$profile->user_id, $profile->avater, 'listing') : '/images/user.jpg');
            
            }
        }
        $json['users']=$user;
        return $json;

    }
    else{
    abort(404);
    }
}
    public function getSearchResult($search_type = "")
    {

        $categories = array();
        $locations  = array();
        $languages  = array();
        $categories = Category::orderBy('title')->get();
        $locations  = Location::all();
        $languages  = Language::all();
        $skills     = Skill::orderBy('title')->get();
        $currency   = SiteManagement::getMetaValue('commision');
        $symbol     = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $freelancer_skills = Helper::getFreelancerLevelList();
        $project_length = Helper::getJobDurationList();
        $keyword = !empty($_GET['s']) ? $_GET['s'] : '';
        $picture = !empty($_GET['wpicture']) ? $_GET['wpicture'] : '';
        $type = !empty($_GET['type']) ? $_GET['type'] : $search_type;
        // if ($type == 'job') {
        //     if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'services') {
        //         abort(404);
        //     }
        // }
        // if ($type == 'service') {
        //     if (Helper::getAccessType() == 'both' || Helper::getAccessType() == 'jobs') {
        //         abort(404);
        //     }
        // }
        $search_skills = !empty($_GET['skills']) ? $_GET['skills'] : array();
        $search_categories = !empty($_GET['category']) ? $_GET['category'] : array();
        $search_locations = !empty($_GET['locations']) ? $_GET['locations'] : array();
        $search_skill = !empty($_GET['skill']) ? $_GET['skill'] : array();
        $search_project_lengths = !empty($_GET['project_lengths']) ? $_GET['project_lengths'] : array();
        $search_languages = !empty($_GET['languages']) ? $_GET['languages'] : array();
        $search_employees = !empty($_GET['employees']) ? $_GET['employees'] : array();
        $search_hourly_rates = !empty($_GET['hourly_rate']) ? $_GET['hourly_rate'] : array();
        $search_freelaner_types = !empty($_GET['freelaner_type']) ? $_GET['freelaner_type'] : array();
        $search_english_levels = !empty($_GET['english_level']) ? $_GET['english_level'] : array();
        $search_delivery_time = !empty($_GET['delivery_time']) ? $_GET['delivery_time'] : array();
        $search_response_time = !empty($_GET['response_time']) ? $_GET['response_time'] : array();
        $current_date = Carbon::now()->toDateTimeString();
        $currency = SiteManagement::getMetaValue('commision');
        $symbol   = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $inner_page  = SiteManagement::getMetaValue('inner_page_data');
        $payment_settings = SiteManagement::getMetaValue('commision');
        $enable_package = !empty($payment_settings) && !empty($payment_settings[0]['enable_packages']) ? $payment_settings[0]['enable_packages'] : 'true';
        $breadcrumbs_settings = SiteManagement::getMetaValue('show_breadcrumb');
        $show_breadcrumbs = !empty($breadcrumbs_settings) ? $breadcrumbs_settings : 'true';
        if (!empty($_GET['type'])) {
            if ($type == 'employer' || $type == 'freelancer') {
                $users_total_records = User::count();
                // dd($users_total_records);
                $search =  User::getSearchResult(
                    $type,
                    $keyword,
                    $search_locations,
                    $search_employees,
                    $search_skills,
                    $search_hourly_rates,
                    $search_freelaner_types,
                    $search_english_levels,
                    $search_languages,
                    $search_categories
                );
                $users = count($search['users']) > 0 ? $search['users'] : '';
                $save_freelancer = !empty(auth()->user()->profile->saved_freelancer) ?
                    unserialize(auth()->user()->profile->saved_freelancer) : array();
                $save_employer = !empty(auth()->user()->profile->saved_employers) ?
                    unserialize(auth()->user()->profile->saved_employers) : array();
                if ($type === 'employer') {
                    $emp_list_meta_title = !empty($inner_page) && !empty($inner_page[0]['emp_list_meta_title']) ? $inner_page[0]['emp_list_meta_title'] : trans('lang.emp_listing');
                    $emp_list_meta_desc = !empty($inner_page) && !empty($inner_page[0]['emp_list_meta_desc']) ? $inner_page[0]['emp_list_meta_desc'] : trans('lang.emp_meta_desc');
                    $show_emp_banner = !empty($inner_page) && !empty($inner_page[0]['show_emp_banner']) ? $inner_page[0]['show_emp_banner'] : 'true';
                    $e_inner_banner = !empty($inner_page) && !empty($inner_page[0]['e_inner_banner']) ? $inner_page[0]['e_inner_banner'] : null;
                    if (file_exists(resource_path('views/extend/front-end/employers/index.blade.php'))) {
                        return view(
                            'extend.front-end.employers.index',
                            compact(
                                'users',
                                'locations',
                                'languages',
                                'freelancer_skills',
                                'project_length',
                                'keyword',
                                'type',
                                'users_total_records',
                                'save_employer',
                                'current_date',
                                'emp_list_meta_title',
                                'emp_list_meta_desc',
                                'show_emp_banner',
                                'e_inner_banner',
                                'enable_package',
                                'show_breadcrumbs'
                            )
                        );
                    } else {
                        return view(
                            'front-end.employers.index',
                            compact(
                                'users',
                                'locations',
                                'languages',
                                'freelancer_skills',
                                'project_length',
                                'keyword',
                                'type',
                                'users_total_records',
                                'save_employer',
                                'current_date',
                                'emp_list_meta_title',
                                'emp_list_meta_desc',
                                'show_emp_banner',
                                'e_inner_banner',
                                'enable_package',
                                'show_breadcrumbs'
                            )
                        );
                    }
                } elseif ($type === 'freelancer') {
                    $f_list_meta_title = !empty($inner_page) && !empty($inner_page[0]['f_list_meta_title']) ? $inner_page[0]['f_list_meta_title'] : trans('lang.freelancer_listing');
                    $f_list_meta_desc = !empty($inner_page) && !empty($inner_page[0]['f_list_meta_desc']) ? $inner_page[0]['f_list_meta_desc'] : trans('lang.freelancer_meta_desc');
                    $show_f_banner = !empty($inner_page) && !empty($inner_page[0]['show_f_banner']) ? $inner_page[0]['show_f_banner'] : 'true';
                    $f_inner_banner = !empty($inner_page) && !empty($inner_page[0]['f_inner_banner']) ? $inner_page[0]['f_inner_banner'] : null;
                    
                    if (file_exists(resource_path('views/extend/front-end/freelancers/index.blade.php'))) {
                        return view(
                            'extend.front-end.freelancers.index',
                            compact(
                                'type',
                                'users',
                                'categories',
                                'locations',
                                'languages',
                                'skills',
                                'project_length',
                                'keyword',
                                'users_total_records',
                                'save_freelancer',
                                'symbol',
                                'current_date',
                                'f_list_meta_title',
                                'f_list_meta_desc',
                                'show_f_banner',
                                'f_inner_banner',
                                'enable_package',
                                'show_breadcrumbs'
                            )
                        );
                    } else {
                        return view(
                            'front-end.freelancers.index',
                            compact(
                                'type',
                                'users',
                                'categories',
                                'locations',
                                'languages',
                                'skills',
                                'project_length',
                                'keyword',
                                'users_total_records',
                                'save_freelancer',
                                'symbol',
                                'current_date',
                                'f_list_meta_title',
                                'f_list_meta_desc',
                                'show_f_banner',
                                'f_inner_banner',
                                'enable_package',
                                'show_breadcrumbs'
                            )
                        );
                    }
                } else {
                    abort(404);
                }
            } elseif ($type == 'service') {
                $service_list_meta_title = !empty($inner_page) && !empty($inner_page[0]['service_list_meta_title']) ? $inner_page[0]['service_list_meta_title'] : trans('lang.service_listing');
                $service_list_meta_desc = !empty($inner_page) && !empty($inner_page[0]['service_list_meta_desc']) ? $inner_page[0]['service_list_meta_desc'] : trans('lang.service_meta_desc');
                $show_service_banner = !empty($inner_page) && !empty($inner_page[0]['show_service_banner']) ? $inner_page[0]['show_service_banner'] : 'true';
                $service_inner_banner = !empty($inner_page) && !empty($inner_page[0]['service_inner_banner']) ? $inner_page[0]['service_inner_banner'] : null;
                // $services= Service::all();
                $delivery_time = DeliveryTime::all();
                $response_time = ResponseTime::all();
                $services_total_records = Service::count();
                $results = Service::getSearchResult(
                    $keyword,
                    $search_categories,
                    $search_locations,
                    $search_languages,
                    $search_delivery_time,
                    $search_response_time,
                    $search_skill
                );
                $services = $results['services'];
                if (file_exists(resource_path('views/extend/front-end/services/index.blade.php'))) {
                    return view(
                        'extend.front-end.services.index',
                        compact(
                            'services_total_records',
                            'type',
                            'services',
                            'skills',
                            'symbol',
                            'keyword',
                            'categories',
                            'locations',
                            'languages',
                            'delivery_time',
                            'response_time',
                            'service_list_meta_title',
                            'service_list_meta_desc',
                            'show_service_banner',
                            'service_inner_banner',
                            'show_breadcrumbs'
                        )
                    );
                } else {
                    return view(
                        'front-end.services.index',
                        compact(
                            'services_total_records',
                            'type',
                            'services',
                            'skills',
                            'symbol',
                            'keyword',
                            'categories',
                            'locations',
                            'languages',
                            'delivery_time',
                            'response_time',
                            'service_list_meta_title',
                            'service_list_meta_desc',
                            'show_service_banner',
                            'service_inner_banner',
                            'show_breadcrumbs'
                        )
                    );
                }
            } 
            elseif ($type == 'instructors') {
                $service_list_meta_title = !empty($inner_page) && !empty($inner_page[0]['service_list_meta_title']) ? $inner_page[0]['service_list_meta_title'] : trans('lang.service_listing');
                $service_list_meta_desc = !empty($inner_page) && !empty($inner_page[0]['service_list_meta_desc']) ? $inner_page[0]['service_list_meta_desc'] : trans('lang.service_meta_desc');
                $show_service_banner = !empty($inner_page) && !empty($inner_page[0]['show_service_banner']) ? $inner_page[0]['show_service_banner'] : 'true';
                $service_inner_banner = !empty($inner_page) && !empty($inner_page[0]['service_inner_banner']) ? $inner_page[0]['service_inner_banner'] : null;
                $delivery_time = DeliveryTime::all();
                $response_time = ResponseTime::all();
                $services_total_records = Cource::count();
                $results = Cource::getSearchResult(
                    $keyword,
                    $search_categories,
                    $search_locations,
                    $search_languages,
                    $search_delivery_time,
                    $search_response_time,
                    $search_skill
                );
                $services = $results['services'];
                
                if (file_exists(resource_path('views/extend/front-end/cources/index.blade.php'))) {
                    return view(
                        'extend.front-end.cources.index',
                        compact(
                            'services_total_records',
                            'type',
                            'services',
                            'symbol',
                            'keyword',
                            'categories',
                            'locations',
                            'languages',
                            'delivery_time',
                            'response_time',
                            'service_list_meta_title',
                            'service_list_meta_desc',
                            'show_service_banner',
                            'service_inner_banner',
                            'show_breadcrumbs',
                            'skills'
                        )
                    );
                } else {
                    return view(
                        'front-end.cources.index',
                        compact(
                            'services_total_records',
                            'type',
                            'services',
                            'symbol',
                            'keyword',
                            'categories',
                            'locations',
                            'languages',
                            'delivery_time',
                            'response_time',
                            'service_list_meta_title',
                            'service_list_meta_desc',
                            'show_service_banner',
                            'service_inner_banner',
                            'show_breadcrumbs',
                            'skills'
                        )
                    );
                }
            }
            elseif ($type == 'blogs') {
                
                $blogs_total_records = Blog::count();
                $results = Blog::getSearchResult(
                    $keyword,
                    $search_categories,
                    $search_skill
                );
                $blogs= $results['blogs'];
                
                if (file_exists(resource_path('views/extend/front-end/blogs/index.blade.php'))) {
                    return view(
                        'extend.front-end.blogs.index',
                        compact(
                            'blogs_total_records',
                            'type',
                            'blogs',
                            'keyword',
                            'categories',
                            'skills'
                        )
                    );
                } else {
                    return view(
                        'front-end.blogs.index',
                        compact(
                            'blogs_total_records',
                            'type',
                            'blogs',
                            'keyword',
                            'categories',
                            'skills'
                        )
                    );
                }
            }
            elseif ($type === 'freelancerjobs') 
            {
                $jobs = array();
                $freelancer_skills = Skill::getFreelancerSkill(Auth::user()['id']);
                $job_ids = DB::table('job_skill')->whereIn('skill_id', $freelancer_skills)->pluck('job_id')->toArray();
                if(!empty($job_ids)){
                $jobs = Job::whereIn('id',$job_ids)->where('expiry_date', '>', date('Y-m-d'))->get();
                }
               
                $Jobs_total_records = Job::count();
                $job_list_meta_title = !empty($inner_page) && !empty($inner_page[0]['job_list_meta_title']) ? $inner_page[0]['job_list_meta_title'] : trans('lang.job_listing');
                $job_list_meta_desc = !empty($inner_page) && !empty($inner_page[0]['job_list_meta_desc']) ? $inner_page[0]['job_list_meta_desc'] : trans('lang.job_meta_desc');
                $show_job_banner = !empty($inner_page) && !empty($inner_page[0]['show_job_banner']) ? $inner_page[0]['show_job_banner'] : 'true';
                $job_inner_banner = !empty($inner_page) && !empty($inner_page[0]['job_inner_banner']) ? $inner_page[0]['job_inner_banner'] : null;
                $project_settings = !empty(SiteManagement::getMetaValue('project_settings')) ? SiteManagement::getMetaValue('project_settings') : array();
                $completed_project_setting = !empty($project_settings) && !empty($project_settings['enable_completed_projects']) ? $project_settings['enable_completed_projects'] : 'true';
           
            
                if (!empty($jobs)) {
                     
                    // if (file_exists(resource_path('views/extend/front-end/jobs/index.blade.php'))) {
                        
                        return view(
                            'front-end.jobs.index',
                            compact(
                                'jobs',
                                'categories',
                                'locations',
                                'languages',
                                'freelancer_skills',
                                'project_length',
                                'Jobs_total_records',
                                'keyword',
                                'skills',
                                'type',
                                'current_date',
                                'symbol',
                                'job_list_meta_title',
                                'job_list_meta_desc',
                                'show_job_banner',
                                'job_inner_banner',
                                'show_breadcrumbs'
                            )
                        );
                    // }
                }
                else{
                    
                    return view(
                        'front-end.jobs.index',
                        compact(
                            'jobs',
                            'categories',
                            'locations',
                            'languages',
                            'freelancer_skills',
                            'project_length',
                            'Jobs_total_records',
                            'keyword',
                            'skills',
                            'type',
                            'current_date',
                            'symbol',
                            'job_list_meta_title',
                            'job_list_meta_desc',
                            'show_job_banner',
                            'job_inner_banner',
                            'show_breadcrumbs'
                        )
                    );
                }
                
            }
            else {
                $Jobs_total_records = Job::count();
                $job_list_meta_title = !empty($inner_page) && !empty($inner_page[0]['job_list_meta_title']) ? $inner_page[0]['job_list_meta_title'] : trans('lang.job_listing');
                $job_list_meta_desc = !empty($inner_page) && !empty($inner_page[0]['job_list_meta_desc']) ? $inner_page[0]['job_list_meta_desc'] : trans('lang.job_meta_desc');
                $show_job_banner = !empty($inner_page) && !empty($inner_page[0]['show_job_banner']) ? $inner_page[0]['show_job_banner'] : 'true';
                $job_inner_banner = !empty($inner_page) && !empty($inner_page[0]['job_inner_banner']) ? $inner_page[0]['job_inner_banner'] : null;
                $project_settings = !empty(SiteManagement::getMetaValue('project_settings')) ? SiteManagement::getMetaValue('project_settings') : array();
                $completed_project_setting = !empty($project_settings) && !empty($project_settings['enable_completed_projects']) ? $project_settings['enable_completed_projects'] : 'true';
                $results = Job::getSearchResult(
                    $keyword,
                    $search_categories,
                    $search_locations,
                    $search_skills,
                    $search_project_lengths,
                    $search_languages,
                    $completed_project_setting
                );
                $jobs = $results['jobs'];
                if (!empty($jobs)) {
                    if (file_exists(resource_path('views/extend/front-end/jobs/index.blade.php'))) {
                        return view(
                            'extend.front-end.jobs.index',
                            compact(
                                'jobs',
                                'categories',
                                'locations',
                                'languages',
                                'freelancer_skills',
                                'project_length',
                                'Jobs_total_records',
                                'keyword',
                                'skills',
                                'type',
                                'current_date',
                                'symbol',
                                'job_list_meta_title',
                                'job_list_meta_desc',
                                'show_job_banner',
                                'job_inner_banner',
                                'show_breadcrumbs'
                            )
                        );
                    } else {
                        return view(
                            'front-end.jobs.index',
                            compact(
                                'jobs',
                                'categories',
                                'locations',
                                'languages',
                                'freelancer_skills',
                                'project_length',
                                'Jobs_total_records',
                                'keyword',
                                'skills',
                                'type',
                                'current_date',
                                'symbol',
                                'job_list_meta_title',
                                'job_list_meta_desc',
                                'show_job_banner',
                                'job_inner_banner',
                                'show_breadcrumbs'
                            )
                        );
                    }
                }
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get Pass Reset Form
     *
     * @param mixed $verification_code verification_code
     *
     * @access public
     *
     * @return View
     */
    public function resetPasswordView($verification_code)
    {
        //dd($verification_code);
        if (!empty($verification_code)) {
            session()->put(['verification_code' => $verification_code]);
            if (file_exists(resource_path('views/extend/front-end/reset-password.blade.php'))) {
                return View('extend.front-end.reset-password');
            } else {
                return View('front-end.reset-password');
            }
        } else {
            abort(404);
        }
    }

    /**
     * Reset user password.
     *
     * @param mixed $request req->attr
     *
     * @access public
     *
     * @return View
     */
    public function resetUserPassword(Request $request)
    {
        if (Session::has('verification_code')) {
            $verification_code = Session::get('verification_code');
            if (!empty($request)) {
                $this->validate(
                    $request,
                    [
                        'new_password' => 'required',
                        'confirm_password' => 'required',
                    ]
                );
               
                $user_id = User::select('verification_code', 'id')
                    ->where('verification_code', $verification_code)
                    ->pluck('id')->first();
                $user = User::find($user_id);
                if ($request->new_password === $request->confirm_password) {
                    if ($verification_code === $user->verification_code) {
                        $user->password = Hash::make($request->confirm_password);
                        $user->verification_code = null;
                        $user->save();
                        Auth::logout();
                        session()->forget('verification_code');
                        return Redirect::to('/');
                    } else {
                        Session::flash('error', trans('lang.invalid_verify_code'));
                        return Redirect::back();
                    }
                } else {
                    Session::flash('error', trans('lang.pass_mismatched'));
                    return Redirect::back();
                }
            } else {
                Session::flash('error', trans('lang.something_wrong'));
                return Redirect::back();
            }
        } else {
            Session::flash('error', trans('lang.invalid_verify_code'));
            return Redirect::back();
        }
    }

    /**
     * Check user authorization.
     *
     * @access public
     *
     * @return View
     */
    public function checkProposalAuth()
    {
        $json = array();
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'freelancer') {
            $json['auth'] = true;
            return $json;
        } else {
            $json['auth'] = false;
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Check user authorization.
     *
     * @access public
     *
     * @return View
     */
    public function checkServiceAuth()
    {
        $json = array();
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'employer') {
            $json['auth'] = true;
            return $json;
        } else {
            $json['auth'] = false;
            $json['message'] = trans('lang.not_authorize');
            return $json;
        }
    }

    /**
     * Check user authorization.
     *
     * @access public
     *
     * @return unserialize array
     */
    public function getFreelancerExperience(Request $request)
    {
        $json = array();
        $id = $request['id'];
        $freelancer = User::find($id);
        if (!empty($freelancer)) {
            $experiences = !empty($freelancer->profile->experience) ? unserialize($freelancer->profile->experience) : array();
                usort($experiences, function ($a, $b) {
                    return strtotime($b['start_date']) - strtotime($a['start_date']);
                });
            $json['type'] = 'success';
            $json['experience'] = $experiences;
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Check user authorization.
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getFreelancerEducation(Request $request)
    {
        $json = array();
        $id = $request['id'];
        $freelancer = User::find($id);
        if (!empty($freelancer)) {
            $educations = !empty($freelancer->profile->education) ? unserialize($freelancer->profile->education) : array();
                usort($educations, function ($a, $b) {
                    return strtotime($b['start_date']) - strtotime($a['start_date']);
                });
            $json['type'] = 'success';
            $json['education'] = $educations;
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Check user authorization.
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getFreelancerService(Request $request)
    {
        $json = array();
        $id = $request['id'];
        $freelancer = User::find($id);
        if (!empty($freelancer)) {
            $json['type'] = 'success';
            $json['user'] = $freelancer;
            $json['services'] = Helper::getUnserializeData($freelancer->services);
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * get video
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function getVideo($video)
    {
        $json = array();
        if (!empty($video)) {
            $width 	= 367;
            $height = 206;
            $url = parse_url($video);
            if (isset($url['host']) && ($url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com')) {
                $content_exp = explode("/", $url);
                $content_vimo = array_pop($content_exp);
                $json['video_content'] = '<iframe width="' . intval($width) . '" height="' . intval($height) . '" src="https://player.vimeo.com/video/' . $content_vimo . '" 
        ></iframe>';
            } else {
                $json['video'] = '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.str_replace("v=", '', $url['query']).'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            }
            $json['type'] = 'success';
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    /**
     * Get article data
     *
     * @return \Illuminate\Http\Response
     */
    public function getArticles()
    {
        $json = array();
        $articles = Article::get()->toArray();
        $aticle_list = array();
        if (!empty($articles)) {
            foreach ($articles as $key => $article) {
                $article_obj = Article::find($article['id']);
                $aticle_list[$key]['id'] = $article['id'];
                $aticle_list[$key]['title'] = $article['title'];
                $aticle_list[$key]['slug'] = $article['slug'];
                $aticle_list[$key]['banner'] = asset(Helper::getImage('uploads/articles', $article['banner'], 'small-', 'small-default-article.png'));
                $aticle_list[$key]['published_date'] = $article['created_at'];
                $aticle_list[$key]['description'] = $article['description'];
                $aticle_list[$key]['name'] = Helper::getUserName($article['user_id']);
                $aticle_list[$key]['image'] = asset(Helper::getProfileImage($article['user_id']));
                if (!empty($article_obj->categories) && $article_obj->categories->count() > 0) {
                    foreach ($article_obj->categories as $cat_key => $category) {
                        $aticle_list[$key]['cat'][$cat_key]['title'] = $category->title;
                        $aticle_list[$key]['cat'][$cat_key]['slug'] = $category->slug;
                    }
                }
            }
            if (!empty($aticle_list)) {
                $json['type'] = 'success';
                $json['articles'] = $aticle_list;
                return $json;
            } else {
                $json['type'] = 'error';
                return $json;
            }
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }

    public function Guestwishlist(){
        $skills = Skill::all();
        $categories = Category::all();
        return view(
            'wishlist.index',compact('skills','categories'));
    }
    public function getWishlistFreelancers(Request $request){
        $data = array();
        $json = array();
        if(!empty($request->ids)){
          
                $freelancer = User::whereIn('id',$request->ids)->get();
                foreach ($freelancer as $key => $data) {
                    $freelancer_profile = Profile::where('user_id',$data->id)->first();
                    $data->avater = $freelancer_profile->avater;
                    $data->avater_imagePath = asset(!empty($freelancer_profile->avater) ? '/uploads/users/' . $data->id . '/' . $freelancer_profile->avater : '/images/user.jpg');
                    $data->avater_imagePath = Helper::getUserImageWithSize('uploads/users/'.$data->id, $freelancer_profile->avater, 'listing');
                    $data->hourly_rates = $freelancer_profile->hourly_rate;
                    $instructor = DB::table('cource_user')->where('seller_id',$data->id)->where('status','posted')->first();
                    $location = DB::table('locations')->where('id',$data->location_id)->first();
                    if(!empty($location)){
                        
                            $data->location_flag = $location->flag;
                            $data->location_title = $location->title;
                            $data->location_imagePath = asset(Helper::getLocationFlag($location->flag));
                        
                    }
                    else{
                        $data->location_flag = null;
                            $data->location_title = null;
                            $data->location_imagePath = null;
                    }
                    if(!empty($data->skills[0])){
                        foreach ($data->skills as $key => $skill) {
                            if($key==0){
                                $data->skill = $skill->title;
                            }
                        }
                    }
                    else{
                        $data->skill = null;
                    }
                    if(!empty($instructor))
                    {
                        $data->instructor = 1;
                    }
                    else
                    {
                        $data->instructor = 0;
                    }
                 
                }
              
            
            $json['type']="success";
            $json['data'] = $freelancer;
            return $json;
        }
        else{
            $json['type']="error";
            return $json;
        }
    }

    public function remoteDevPage(){
        $inner_page  = SiteManagement::getMetaValue('inner_page_data');
        $remote_list_meta_title = !empty($inner_page) && !empty($inner_page[0]['remote_list_meta_title']) ? $inner_page[0]['remote_list_meta_title'] : 'Hire Remote Developers';
        $remote_list_meta_desc = !empty($inner_page) && !empty($inner_page[0]['remote_list_meta_desc']) ? $inner_page[0]['remote_list_meta_desc'] : 'Hire Remote Developers';
    
        return view('front-end.remoteDeveloper.index',compact('remote_list_meta_title','remote_list_meta_desc'));
    }
    public function storeGuestMsg(Request $request){
        $json = array();
        // $server = Helper::worketicIsDemoSiteAjax();
        // if (!empty($server)) {
        //     $response['message'] = $server->getData()->message;
        //     return $response;
        // }
        request()->validate
            (
                [
                'name' => 'required',
                'guest_email' => 'required|email',
                'message' => 'required',
                'phone' => 'required|numeric|digits:11'
               
            ]
        );
        $data =DB::table('contact_info')->insertGetId(
            [
                'name' => filter_var($request['name'], FILTER_SANITIZE_STRING),
                'message' => filter_var($request['message'], FILTER_SANITIZE_STRING),
                'guest_email' => $request['guest_email'],
                'phone' => $request['phone'],
                "created_at" => Carbon::now(), "updated_at" => Carbon::now()
            ]
        );
       
        if(!empty($data))
            {
                Alert::success('Message Sent', 'Thankyou for Showing Interest');
                return redirect('/hire-remote-developers');
            } 
            
        else{
            Alert::error('errror', 'Something went wrong!');
            return redirect('/');
        }
    }
    public function showGuestInfo(){
        $users = DB::table('contact_info')->paginate(15);
        return view('back-end/editor/guests/index',compact('users'));

    }

    }

