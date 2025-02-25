<?php

/**
 * Class UserController
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @version <PHP: 1.0.0>
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers;

use App\Charts\UserChart;
use App\EmailTemplate;
use App\Helper;
use App\Invoice;
use App\Job;
use App\Language;
use App\Mail\AdminEmailMailable;
use App\Mail\FreelancerEmailMailable;
use App\Mail\GeneralEmailMailable;
use App\Package;
use App\Profile;
use App\Cource;
use App\Proposal;
use App\Report;
use App\Review;
use App\SiteManagement;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Input;
use View;
use App\Offer;
use App\Message;
use Illuminate\Support\Arr;
use App\Payout;
use File;
use Storage;
use PDF;
use App\Item;
use App\Http\Controllers\Exception;
use App\Service;
use App\Order;
use App\Mail\EmployerEmailMailable;
use Illuminate\Support\Facades\Schema;
use App\Location;
use App\Skill;
use App\Department;
use App\Category;


/**
 * Class UserController
 *
 */
class StatsController extends Controller
{
    /**
     * Defining public scope of varriable
     *
     * @access public
     *
     * @var array $user
     */
    use HasRoles;
    protected $user;
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @param instance $user    make instance
     * @param instance $profile make profile instance
     *
     * @return void
     */
    public function __construct(User $user, Profile $profile)
    {
        $this->user = $user;
        $this->profile = $profile;
    }


    /**
     * Raise dispute
     *
     * @access public
     *
     * @return View
     */
    public function userStats()
    {
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'admin') {
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                $users = $this->user::where('first_name', 'like', '%' . $keyword . '%')->orWhere('last_name', 'like', '%' . $keyword . '%')->paginate(7)->setPath('');
                $pagination = $users->appends(
                    array(
                        'keyword' => Input::get('keyword')
                    )
                );
            } else {
                $users = User::select('*')->latest()->paginate(10);
            }

            return view('back-end.admin.users.index', compact('users'));
        } else {
            abort(404);
        }
    }

    public function index()
    {

        // 	$users = User::whereBetween('created_at', 
        //     [Carbon::now()->subMonth(6), Carbon::now()]
        // )->get();
        // dd(Carbon::now()->subMonth(6), Carbon::now()));
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        // Fetch users created within the current week
        $thisweek = User::whereBetween('created_at', [$startDate, $endDate])->get()->count();
        $users = User::get()->count();
        $profile = Profile::where('user_id', 196)->first();
        // dd($profile);

        $active_users = User::where('status', 1)->get()->count();
        $cources = Cource::get()->count();
        $services = Service::get()->count();
        $jobs = Job::get()->count();
        $profileCount = 0;
        User::whereHas('roles', function ($query) {
            $query->where('role_id', 3);
        })->chunk(200, function ($freelancers) use (&$profileCount) {
            foreach ($freelancers as $freelancer) {
                $profile = Profile::where('user_id', $freelancer->id)->first();
                $percentage = $this->getProfileCompletionPercentage($profile);

                if ($percentage > 59) {
                    $profileCount++;
                }
            }
        });

        $data = [];

        for ($i = 0; $i < 6; ++$i) {
            $date = now()->startOfMonth()->subMonth($i);
            $dates[$date->format('m')] = User::where('created_at', '>=', $date->startOfMonth()->startOfDay()->toDateTimeString())
                ->where('created_at', '<=', $date->endOfMonth()->endOfDay()->toDateTimeString())
                ->count();
            // dd($date->startOfMonth()->startOfDay()->toDateString());
        }
        $data = array_values($dates);
        foreach ($dates as $key => $value) {
            $_key = date('F', mktime(0, 0, 0, $key, 10));
            $curr_month = date('m');
            $curr_year = date('Y');
            $previous_year = $curr_year - 1;
            if ($key > $curr_month) {

                $_key = $_key . " ," . $previous_year;
            } else {

                $_key = $_key . " ," . $curr_year;
            }
            unset($dates[$key]);
            $dates[ucfirst($_key)] = $value;
        }
        // dd(array_keys($dates));

        // $chart = Charts::database($data,'bar', 'highcharts')
        // 	      ->title("Users Joining Stats")
        // 	      ->elementLabel("Users Joined - Monthly")
        // 	      ->dimensions(700, 400)
        // 	      ->responsive(true)
        // 	      ->labels(array_keys($dates))
        //           ->values($data);

        $chart = new UserChart;
        $chart->title('Users Joining Stats', 30, "rgb(255, 99, 132)", true, 'Helvetica Neue');
        $chart->barwidth(0.0);
        $chart->displaylegend(false);
        $chart->labels(array_keys($dates));
        $chart->dataset('Users Joined - Monthly', 'bar', $data)
            ->color("rgb(255, 99, 132)")
            ->backgroundcolor("rgb(255, 99, 132)")
            ->fill(false)
            ->linetension(0.1)
            ->dashed([5]);
        $pie = new UserChart;
        // $pie  =	 Charts::create('pie', 'highcharts')
        //           ->title('Freelancers & Employee %')
        //           ->labels(['Employers', 'Freelancers'])
        //           ->values([7,92])
        //           ->dimensions(1000,500)
        //           ->responsive(true);
        $pie->title('Freelancers & Employee %', 30, "rgb(255, 99, 132)", true, 'Helvetica Neue');
        $pie->labels(['Employers', 'Freelancers']);
        $pie->dataset('Users by trimester', 'pie', [7, 92])
            ->color("rgb(255, 99, 132)")
            ->backgroundcolor("rgb(255, 99, 132)");

        return view('back-end.admin.stats.index', compact('chart', 'pie', 'users', 'cources', 'services', 'jobs', 'active_users', 'profileCount', 'thisweek'));
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
