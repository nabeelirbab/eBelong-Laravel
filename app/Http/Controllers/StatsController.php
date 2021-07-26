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

use Charts;
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
    	$users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
    				->get();
        $chart = Charts::database($users, 'bar', 'highcharts')
			      ->title("Users Joining Stats")
			      ->elementLabel("Users Joined - Monthly")
			      ->dimensions(700, 400)
			      ->responsive(true)
			      ->groupByMonth(date('Y'), true);

        $pie  =	 Charts::create('pie', 'highcharts')
                  ->title('Freelancers & Employee %')
                  ->labels(['Employers', 'Freelancers'])
                  ->values([7,92])
                  ->dimensions(1000,500)
                  ->responsive(true);

        return view('back-end.admin.stats.index',compact('chart','pie'));
    }

}