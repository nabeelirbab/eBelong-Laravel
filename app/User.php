<?php

/**
 * Class User.
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Facades\Input;
use File;
use App\Payout;
use Illuminate\Support\Facades\Schema;
use App\Location;
use App\Profile;
use Auth;
use App\Package;
use App\Helper;
use App\Job;
use Carbon\Carbon;
use canResetPassword;
use App\Notifications;
use Event;

/**
 * Class User
 *
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'slug', 'email', 'password',
        'avatar', 'banner', 'tagline', 'description',
        'location_id', 'verification_code', 'address',
        'longitude', 'latitude', 'oauth_type', 'oauth_id'
    ];

    /**
     * For creating event.
     *
     * @return event
     */
    public static function boot()
    {
        parent::boot();
        static::created(
            function ($user) {
                // Event::fire('user.created', $user);
            }
        );
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User Can have multiple articles
     *
     * @return void
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * The skills that belong to the user.
     *
     * @return relation
     */
    public function skills()
    {
        return $this->belongsToMany('App\Skill')->withPivot('skill_rating');
    }

    /**
     * Get all of the categories for the user.
     *
     * @return relation
     */
    public function categories()
    {
        return $this->morphToMany('App\Category', 'catable');
    }

    /**
     * Get all of the languages for the user.
     *
     * @return relation
     */
    public function languages()
    {
        return $this->morphToMany('App\Language', 'langable');
    }

    public function connections()
    {
        return $this->hasMany(Connection::class, 'user_id', 'id')
            ->orWhere('connected_user_id', $this->id);
    }



    /**
     * Get the location that owns the user.
     *
     * @return relation
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     * Get the profile record associated with the user.
     *
     * @return relation
     */
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    /**
     * Get the payout record associated with the user.
     *
     * @return relation
     */
    public function payout()
    {
        return $this->hasOne('App\Payout');
    }

    /**
     * Get the jobs for the employer.
     *
     * @return relation
     */
    public function jobs()
    {
        return $this->hasMany('App\Job')->orderBy('id', 'desc');
    }

    /**
     * Get the services for the freelancer.
     *
     * @return relation
     */
    public function services()
    {
        return $this->belongsToMany('App\Service')->withPivot('type', 'status', 'seller_id', 'paid');
    }
    /**
     * Get the cources for the freelancer.
     *
     * @return relation
     */
    public function cources()
    {
        return $this->belongsToMany('App\Cource')->withPivot('type', 'status', 'seller_id', 'paid');
    }


    /**
     * Get the employer purchased services
     *
     * @return relation
     */
    public function purchasedServices()
    {
        return $this->belongsToMany('App\Service')->withPivot('id', 'type', 'status', 'seller_id', 'paid')->wherePivot('status', 'hired');
    }

    /**
     * Get the employer completed services
     *
     * @return relation
     */
    public function completedServices()
    {
        return $this->belongsToMany('App\Service')->withPivot('id', 'type', 'status', 'seller_id', 'paid')->wherePivot('status', 'completed');
    }

    /**
     * Get the employer cancelled services
     *
     * @return relation
     */
    public function cancelledServices()
    {
        return $this->belongsToMany('App\Service')->withPivot('id', 'type', 'status', 'seller_id', 'paid')->wherePivot('status', 'cancelled');
    }

    /**
     * Get the proposals for the freelancer.
     *
     * @return relation
     */
    public function proposals()
    {
        return $this->hasMany('App\Proposal', 'freelancer_id');
    }

    /**
     * Get the reviews for the user.
     *
     * @return relation
     */
    public function reviews()
    {
        return $this->hasMany('App\Review', 'user_id');
    }

    /**
     * Get the user that owns the offer.
     *
     * @return offers
     */
    public function offers()
    {
        return $this->hasOne('App\Offer');
    }

    /**
     * Get all of reported employers.
     *
     * @return relation
     */
    public function reports()
    {
        return $this->morphMany('App\Report', 'reportable');
    }

    /**
     * Get the message for the user.
     *
     * @return relation
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    /**
     * Get the item record associated with the user.
     *
     * @return relation
     */
    public function item()
    {
        return $this->hasMany('App\item', 'subscriber');
    }

    /**
     * Set slug before saving in DB
     *
     * @param string $value value
     *
     * @access public
     *
     * @return string
     */
    public function setSlugAttribute($value)
    {
        if (!empty($value)) {
            $temp = str_slug($value, '-');
            if (!User::all()->where('slug', $temp)->isEmpty()) {
                $i = 1;
                $new_slug = $temp . '-' . $i;
                while (!User::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp . '-' . $i;
                }
                $temp = $new_slug;
            }
            $this->attributes['slug'] = $temp;
        }
    }

    /**
     * Store user
     *
     * @param \Illuminate\Http\Request $request           code
     * @param code                     $verification_code verification code
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public function storeUser($request, $verification_code)
    {
        if (!empty($request)) {
            $this->first_name = filter_var($request['first_name'], FILTER_SANITIZE_STRING);
            $this->last_name = filter_var($request['last_name'], FILTER_SANITIZE_STRING);
            $this->slug = filter_var($request['first_name'], FILTER_SANITIZE_STRING) . '-' .
                filter_var($request['last_name'], FILTER_SANITIZE_STRING);
            $this->email = filter_var($request['email'], FILTER_VALIDATE_EMAIL);
            $this->password = Hash::make($request['password']);
            $this->verification_code = $verification_code;
            $this->user_verified = 0;
            $this->assignRole($request['role']);
            if (!empty($request['locations'])) {
                $location = Location::find($request['locations']);
                $this->location()->associate($location);
            }
            if (!empty($request['oauth_id'])) {

                $this->oauth_id = $request['oauth_id'];
            }
            if (!empty($request['oauth_type'])) {

                $this->oauth_type = $request['oauth_type'];
            }
            $this->badge_id = null;
            $this->expiry_date = null;
            $this->save();
            $user_id = $this->id;
            $user_name = $this->first_name;
            $profile = new Profile();
            $profile->user()->associate($user_id);
            if (!empty($request['employees'])) {
                $profile->no_of_employees = intval($request['employees']);
            }
            if (!empty($request['department_name'])) {
                $department = Department::find($request['department_name']);
                $profile->department()->associate($department);
            }
            if (!empty($request['hidden_avater_image'])) {
                $file_original_name = substr($request['hidden_avater_image'], strrpos($request['hidden_avater_image'], '/') + 1);
                $file_original_name = explode('?', $file_original_name);
                $file_original_name = $file_original_name[0];
                $small_img = Image::make($request['hidden_avater_image']);
                $path = Helper::PublicPath() . '/uploads/users/' . $user_id . '/';
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }
                // generate small image size
                $small_img->fit(
                    36,
                    36,
                    function ($constraint) {
                        $constraint->upsize();
                    }
                );
                $small_img->save($path . '/small-' . $file_original_name . "-" . $user_name . ".jpg");
                // generate medium image size
                $medium_img = Image::make($request['hidden_avater_image']);
                $medium_img->fit(
                    100,
                    100,
                    function ($constraint) {
                        $constraint->upsize();
                    }
                );
                $medium_img->save($path . '/medium-' . $file_original_name . "-" . $user_name . ".jpg");
                // save original image size
                $img = Image::make($request['hidden_avater_image']);
                $img->save($path . '/' . $file_original_name . "-" . $user_name . ".jpg");
                $profile->avater = $file_original_name . "-" . $user_name . ".jpg";
            } else {
                $profile->avater = null;
            }
            $profile->save();
            $role_id = Helper::getRoleByUserID($user_id);
            $package = Package::select('id', 'title', 'cost')->where('role_id', $role_id)->where('trial', 1)->get()->first();
            $trial_invoice = Invoice::select('id')->where('type', 'trial')->get()->first();
            if (!empty($package) && !empty($trial_invoice)) {
                DB::table('items')->insert(
                    [
                        'invoice_id' => $trial_invoice->id, 'product_id' => $package->id, 'subscriber' => $user_id,
                        'item_name' => $package->title, 'item_price' => $package->cost, 'item_qty' => 1,
                        "created_at" => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()
                    ]
                );
            }
            return $user_id;
        }
    }

    /**
     * Get user role type by user ID
     *
     * @param integer $user_id code
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public static function getUserRoleType($user_id)
    {
        if (!empty($user_id) && is_numeric($user_id)) {
            $role_id = DB::table('model_has_roles')->select('role_id')->where('model_id', $user_id)
                ->get()->pluck('role_id')->toArray();
            if (!empty($role_id)) {
                return DB::table('roles')->select('id', 'role_type', 'name')->where('id', $role_id[0])->get()->first();
            } else {
                return '';
            }
        }
    }

    /**
     * Get search results
     *
     * @param integer $type                   type
     * @param integer $keyword                keyword
     * @param integer $search_locations       search_locations
     * @param integer $search_employees       search_employees
     * @param integer $search_skills          search_skills
     * @param integer $search_hourly_rates    search_hourly_rates
     * @param integer $search_freelaner_types search_freelaner_types
     * @param integer $search_english_levels  search_english_levels
     * @param integer $search_languages       search_languages
     *
     * @access public
     *
     * @return \Illuminate\Http\Response
     */
    public static function getSearchResult(
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
    ) {
        $json = array();
        $user_id = array();
        $user_by_role =  User::role($type)->pluck('id')->toArray();
        $picture = Profile::whereNotNull('avater')->whereIn('user_id', $user_by_role)->get();
        $ids = null;
        $idss = null;
        $idsss = null;
        foreach ($picture as $id) {
            $ids[] = $id->user_id;
        }

        $ids_ordered = implode(',', $ids);
        $users_certified_and_pics =  User::whereIn('id', $ids)->where('is_disabled', 'false')->where('status', 1)->where('is_certified', 1)->get();
        foreach ($users_certified_and_pics as $id_) {
            $idss[] = $id_->id;
        }
        // dd($idss);
        //  dd($idss);
        $users_not_certified_and_pics = !empty($user_by_role) ? User::whereIn('id', $user_by_role)->where('is_disabled', 'false')->where('status', 1)->where('is_certified', 0)->get() : array();
        foreach ($users_not_certified_and_pics as $id__) {
            $idsss[] = $id__->id;
        }
        // dd($idsss);
        // dd($ids_ordered);
        $users = !empty($user_by_role) ? User::whereIn('id', $user_by_role)->where('is_disabled', 'false')->where('status', 1) : array();
        // dd($users->paginate(20)->setPath('') );
        $filters = array();


        $filters['type'] = $type;
        if (!empty($keyword)) {
            $filters['s'] = $keyword;
            $users = !empty($user_by_role) ? User::whereIn('id', $user_by_role)->where(DB::raw('CONCAT(first_name," ",last_name)'), 'like', '%' . $keyword . '%')->where('is_disabled', 'false')->where('status', 1) : array();
        }

        if (!empty($search_categories)) {
            $filters['category'] = $search_categories;
            $user_id = array();
            $freelancers = Profile::whereIn('category_id', $search_categories)->get();
            foreach ($freelancers as $key => $freelancer) {
                if (!empty($freelancer->user_id)) {
                    $user_id[] = $freelancer->user_id;
                }
            }
            $users->whereIn('id', $user_id)->orderBy('is_certified', 'DESC');
        }

        if (!empty($search_locations)) {
            $filters['locations'] = $search_locations;
            $locations = Location::select('id')->whereIn('slug', $search_locations)
                ->get()->pluck('id')->toArray();
            $users->whereIn('location_id', $locations);
        }


        // $dp_users = !empty($user_by_role) ? User::whereIn('id', $ids)
        // ->orderByRaw("FIELD(id, $ids_ordered)")->where('is_disabled', 'false')->where('status',1)->paginate(20)->setPath('') :array();
        //     dd($dp_users);

        if (!empty($search_employees)) {
            $filters['employees'] = $search_employees;
            $employees = Profile::whereIn('no_of_employees', $search_employees)->get();
            foreach ($employees as $key => $employee) {
                if (!empty($employee->user_id)) {
                    $user_id[] = $employee->user_id;
                }
            }
            $users->whereIn('id', $user_id);
        }
        if (!empty($search_skills)) {
            $user_id = array();
            $filters['skills'] = $search_skills;
            $skills = Skill::whereIn('slug', $search_skills)->get();
            foreach ($skills as $key => $skill) {
                /* if (!empty($skill->freelancers[$key]->id)) {
                        $user_id[] = $skill->freelancers[$key]->id;
                    } */
                $userid = DB::table('skill_user')->select('user_id')->where('skill_id', $skill->id)->get();
                foreach ($userid as $ui) {
                    $user_id[] = $ui->user_id;
                }
            }
            // dd($user_id);
            $users->whereIn('id', $user_id)->orderBy('is_certified', 'DESC');
        }
        if (!empty($search_hourly_rates)) {
            $user_id = array();
            $filters['hourly_rate'] = $search_hourly_rates;
            $min = '';
            $max = '';
            foreach ($search_hourly_rates as $search_hourly_rate) {
                $hourly_rates = explode("-", $search_hourly_rate);
                $min = $hourly_rates[0];
                if (!empty($hourly_rates[1])) {
                    $max = $hourly_rates[1];
                }
                $userid = Profile::select('user_id')->whereIn('user_id', $user_by_role)
                    ->whereBetween('hourly_rate', [$min, $max])->get()->pluck('user_id')->toArray();
                foreach ($userid as $ui) {
                    $user_id[] = $ui;
                }
            }
            $users->whereIn('id', $user_id);
        }
        if (!empty($search_freelaner_types)) {
            $user_id = array();
            $filters['freelaner_type'] = $search_freelaner_types;
            $freelancers = Profile::whereIn('freelancer_type', $search_freelaner_types)->get();
            foreach ($freelancers as $key => $freelancer) {
                if (!empty($freelancer->user_id)) {
                    $user_id[] = $freelancer->user_id;
                }
            }
            $users->whereIn('id', $user_id);
        }
        if (!empty($search_english_levels)) {
            $user_id = array();
            $filters['english_level'] = $search_english_levels;
            $freelancers = Profile::whereIn('english_level', $search_english_levels)->get();
            foreach ($freelancers as $key => $freelancer) {
                if (!empty($freelancer->user_id)) {
                    $user_id[] = $freelancer->user_id;
                }
            }
            $users->whereIn('id', $user_id);
        }

        if (
            empty($keyword) &&
            empty($search_locations) &&
            empty($search_employees) &&
            empty($search_skills) &&
            empty($search_hourly_rates) &&
            empty($search_freelaner_types) &&
            empty($search_english_levels) &&
            empty($search_languages) &&
            empty($search_categories)
        ) {
            $users = User::join('profiles', 'users.id', '=', 'profiles.user_id')
                ->select('users.*')
                ->whereIn('users.id', $user_by_role)->where('users.is_disabled', 'false')->where('users.status', 1)
                ->orderBy('users.is_certified', 'DESC')
                ->orderBy('profiles.avater', 'DESC');
        }
        // dd($users->get());

        //   $users = $users->orderBy('is_certified', 'DESC')->orderByRaw('id',$idss)->orderByRaw('id',$idsss); 
        //   dd($users->get());
        //   $users = $users->profile->orderByRaw('ISNULL(sortOrder), sortOrder ASC');
        $users = $users->paginate(20)->setPath('');
        //   dd($users);
        //   $users = $dp_users->appends($users);


        foreach ($filters as $key => $filter) {
            $pagination = $users->appends(
                array(
                    $key => $filter
                )
            );
        }
        $json['users'] = $users;
        return $json;
    }

    /**
     * Save dispute.
     *
     * @param string $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function saveDispute($request)
    {
        $user = User::find(Auth::user()->id);
        DB::table('disputes')->insert(
            [
                'proposal_id' => $request['proposal_id'], 'user_id' => $user->id,
                'reason' => $request['reason'], 'description' => $request['description'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        return 'success';
    }

    /**
     * Update calcel project
     *
     * @param string $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function updateCancelProject($request)
    {
        $job = Job::find($request['job_id']);
        if (!empty($job)) {
            $job->status = trans('lang.completed');
            $job->save();
            $proposal = Proposal::find($request['order_id']);
            if (!empty($proposal)) {
                $proposal->status = trans('lang.completed');
                $proposal->save();
                return 'error';
            }
            return 'success';
        } else {
            return 'error';
        }
    }

    /**
     * Update calcel project
     *
     * @param string $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function updateCancelService($request)
    {
        $order = DB::table('service_user')
            ->where('id', $request['order_id'])
            ->update(['status' => 'completed']);
        return 'success';
    }

    /**
     * Save refound payout.
     *
     * @param string $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function transferRefund($request)
    {
        $json = array();
        if (!empty($request['refundable_user_id'])) {
            $payment_settings = SiteManagement::getMetaValue('commision');
            $currency  = !empty($payment_settings) && !empty($payment_settings[0]['currency']) ? $payment_settings[0]['currency'] : 'USD';
            $user = User::find($request['refundable_user_id']);
            $payout_id = !empty($user->profile->payout_id) ? $user->profile->payout_id : '';
            $payout_detail = !empty($user->profile->payout_settings) ? $user->profile->payout_settings : array();
            if (!empty($payout_id) || !empty($payout_detail)) {
                $payout = new Payout();
                $payout->user()->associate($request['refundable_user_id']);
                $payout->amount = $request['amount'];
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
                    } else {
                        $payout->paypal_id = '';
                    }
                    $payout->payment_method = Helper::getPayoutsList()[$payment_details['type']]['title'];
                } else if (!empty($payout_id)) {
                    $payout->payment_method = 'paypal';
                    if (Schema::hasColumn('payouts', 'email')) {
                        $payout->email = $payout_id;
                    } elseif (Schema::hasColumn('payouts', 'paypal_id')) {
                        $payout->paypal_id = $payout_id;
                    }
                }
                $payout->status = 'pending';
                if (!empty($request['order_id'])) {
                    $payout->order_id = intval($request['order_id']);
                }
                $payout->type = $request['type'];
                $payout->save();
                return 'success';
            } else {
                return 'payout_not_available';
            }
        } else {
            return 'error';
        }
    }

    /**
     * Get the reviews for the user.
     *
     * @return relation
     */
    public static function getTopFreelancers()
    {
        return
            DB::select(
                DB::raw(
                    "SELECT users.id, users.user_verified, users.badge_id, users.location_id , SUM(reviews.avg_rating) AS rating, COUNT(reviews.id) AS total_reviews
                FROM users 
                INNER JOIN reviews
                WHERE users.id = reviews.receiver_id
                GROUP BY users.id
                Order BY rating DESC Limit 4"
                )
            );
    }
    public static function getFilterUsers($role = "")
    {

        $query = '';
        if ($role == "agency_member") {
            $agency_members = DB::table('agency_associated_users')->where('is_pending', 0)->where('is_accepted', 1)->pluck('user_id')->toArray();
            $query = User::whereIn('id', $agency_members)
                ->latest()
                ->paginate(10)->setPath('');
        }
        if ($role == "agency_creator") {
            $agency_members = DB::table('agency_user')->pluck('user_id')->toArray();
            $query = User::whereIn('id', $agency_members)
                ->latest()
                ->paginate(10)->setPath('');
        }

        if ($role == "instructors") {
            $instructor_ids = DB::table('cource_user')->distinct()->pluck('seller_id')->toArray();
            $query = User::whereIn('id', $instructor_ids)
                ->latest()
                ->paginate(10)->setPath('');
        }
        if ($role == "freelancers") {
            $instructor_ids = DB::table('cource_user')->distinct()->pluck('seller_id')->toArray();
            $query = User::whereNotIn('id', $instructor_ids)
                ->latest()
                ->paginate(10)->setPath('');
        }
        if ($role == "new_members") {
            $query = User::select('*')->latest()->paginate(10)->setPath('');
        }
        if ($role == "old_members") {
            $query = User::oldest()->paginate(10)->setPath('');
        }
        if ($role == "Email_asc") {
            $query = User::orderBy('email', 'asc')->paginate(10)->setpath('');
        }
        if ($role == "Email_desc") {
            $query = User::orderBy('email', 'desc')->paginate(10)->setpath('');
        }
        if ($role == "name_asc") {
            $query = User::orderBy('first_name', 'asc')->paginate(10)->setpath('');
        }
        if ($role == "name_desc") {
            $query = User::orderBy('first_name', 'desc')->paginate(10)->setpath('');
        }
        if ($role == "certified") {
            $query =  User::select('*')->where('is_certified', 1)->latest()->paginate(10)->setPath('');
        }
        if ($role == "featured") {
            $query =  User::select('*')->where('is_featured', 1)->latest()->paginate(10)->setPath('');
        }
        return $query;

        // if (!empty($role)) {
        //     $pagination = $query->appends(
        //         array(
        //             'role' => Input::get('role')
        //         )
        //     );
        //     return $query;
        // }

    }
}
