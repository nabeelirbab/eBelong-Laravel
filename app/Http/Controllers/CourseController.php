<?php

namespace App\Http\Controllers;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;
use Illuminate\Http\Request;
use App\Language;
use App\Category;
use App\Location;
use App\Helper;
use App\ResponseTime;
use App\DeliveryTime;
use App\Service;
use App\Cource;
use App\Item;
use App\Message;
use Auth;
use App\Package;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\User;
use DB;
use App\SiteManagement;
use App\Review;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Mail\AdminEmailMailable;
use App\Mail\FreelancerEmailMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class CourseController extends Controller
{
    /**
     * Defining scope of the variable
     *
     * @access protected
     * @var    array $job
     */
    protected $cource;

    /**
     * Create a new controller instance.
     *
     * @param instance $job instance
     *
     * @return void
     */
    public function __construct(Cource $cource)
    {
        $this->cource = $cource;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = 'cource';
        $categories = Category::all();
        $locations  = Location::all();
        $languages  = Language::all();
        $inner_page  = SiteManagement::getMetaValue('inner_page_data');
        $service_list_meta_title = !empty($inner_page) && !empty($inner_page[0]['service_list_meta_title']) ? $inner_page[0]['service_list_meta_title'] : trans('lang.service_listing');
        $service_list_meta_desc = !empty($inner_page) && !empty($inner_page[0]['service_list_meta_desc']) ? $inner_page[0]['service_list_meta_desc'] : trans('lang.service_meta_desc');
        $show_service_banner = !empty($inner_page) && !empty($inner_page[0]['show_service_banner']) ? $inner_page[0]['show_service_banner'] : 'true';
        $service_inner_banner = !empty($inner_page) && !empty($inner_page[0]['service_inner_banner']) ? $inner_page[0]['service_inner_banner'] : null;
        $delivery_time = DeliveryTime::all();
        $response_time = ResponseTime::all();
        $services_total_records = '';
        $services = $this->service->latest()->paginate(8);
        $keyword = '';
        if (file_exists(resource_path('views/extend/front-end/services/index.blade.php'))) {
            return view(
                'extend.front-end.services.index',
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
                    'service_inner_banner'
                )
            );
        } else {
            return view(
                'front-end.services.index',
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
                    'service_inner_banner'
                )
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::pluck('title', 'id');
        $locations = Location::pluck('title', 'id');
        $response_time = ResponseTime::pluck('title', 'id');
        $delivery_time = DeliveryTime::pluck('title', 'id');
        $english_levels = Helper::getEnglishLevelList();
        $categories = Category::pluck('title', 'id');
        if (file_exists(resource_path('views/extend/back-end/freelancer/courses/create.blade.php'))) {
            return view(
                'extend.back-end.freelancer.courses.create',
                compact(
                    'english_levels',
                    'languages',
                    'categories',
                    'locations',
                    'response_time',
                    'delivery_time'
                )
            );
        } else {
            return view(
                'back-end.freelancer.courses.create',
                compact(
                    'english_levels',
                    'languages',
                    'categories',
                    'locations',
                    'response_time',
                    'delivery_time'
                )
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $json = array();
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['message'] = $server->getData()->message;
            return $response;
        }
        if (Helper::getAccessType() == 'jobs') {
            $json['type'] = 'error';
            $json['message'] = trans('lang.course_warning');
            return $json;
        }
        $this->validate(
            $request,
            [
                'title' => 'required',
                'delivery_time'    => 'required',
                'course_price'    => 'required',
                'response_time'    => 'required',
                'english_level'    => 'required',
                'description'    => 'required',
            ]
        );
        if (!empty($request['latitude']) || !empty($request['longitude'])) {
            $this->validate(
                $request,
                [
                    'latitude' => ['regex:/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/'],
                    'longitude' => ['regex:/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}$/'],
                ]
            );
        }
        $user = User::find(Auth::user()->id);
        $package_item = Item::where('subscriber', Auth::user()->id)->first();
        $package = !empty($package_item) ? Package::find($package_item->product_id) : '';
        $option = !empty($package) ? unserialize($package->options) : '';
        $expiry = !empty($option) ? $package_item->created_at->addDays($option['duration']) : '';
        $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->format('Y-m-d') : '';
        $current_date = Carbon::now()->format('Y-m-d');
        $posted_cources = $user->cources->count();
        $posted_featured_cources = $user->cources->where('is_featured', 'true')->count();
        $payment_settings = SiteManagement::getMetaValue('commision');
        $package_status = '';
        if (empty($payment_settings)) {
            $package_status = 'true';
        } else {
            $package_status = !empty($payment_settings[0]['enable_packages']) ? $payment_settings[0]['enable_packages'] : 'true';
        }
        if ($package_status === 'true') {
            if (!empty($package->count()) && $current_date > $expiry_date) {
                $json['type'] = 'error';
                $json['message'] = trans('lang.need_to_purchase_pkg');
                return $json;
            }

            if ($request['is_featured'] == 'true') {
                if (!empty($option['no_of_featured_cources']) && $posted_featured_cources >= intval($option['no_of_featured_cources'])) {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.sorry_can_only_feature')  . ' ' . $option['no_of_featured_cources'] . ' ' . trans('lang.services_acc_to_pkg');
                    return $json;
                }
            }
            if (!empty($option['no_of_cources']) && $posted_cources >= intval($option['no_of_cources'])) {
                $json['type'] = 'error';
                $json['message'] = trans('lang.sorry_cannot_submit') . ' ' . $option['no_of_cources'] . ' ' . trans('lang.services_acc_to_pkg');
                return $json;
            } else {
                $image_size = array(
                    'small',
                    'medium'
                );
                $cource_post = $this->cource->storeCource($request, $image_size);
                if ($cource_post['type'] == 'success') {
                    $json['type'] = 'success';
                    $json['progress'] = trans('lang.course_publishing');
                    $json['message'] = trans('lang.course_post_success');
                    // Send Email
                    $user = User::find(Auth::user()->id);
                    //send email to admin
                    if (trim(config('mail.username')) != "" && trim(config('mail.password')) != "") {
                        $cource = $this->cource::where('id', $cource_post['new_course'])->first();
                        $email_params = array();
                        $email_params['cource_title'] = $cource->title;
                        $email_params['posted_cource_link'] = url('/instructor/' . $cource->slug);
                        $email_params['name'] = Helper::getUserName(Auth::user()->id);
                        $email_params['link'] = url('profile/' . $user->slug);
                        $template_data = (object)array();
                        $template_data->content = Helper::getAdminCoursePostedEmailContent();
                        $template_data->subject = "Course Posted";
                        // $template_data = Helper::getFreelancerCoursePostedEmailContent();
                        Mail::to(env('MAIL_FROM_ADDRESS'))
                            ->send(
                                new AdminEmailMailable(
                                    'admin_email_new_course_posted',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                    if (trim(config('mail.username')) != "" && trim(config('mail.password')) != "") {
                        $cource = $this->cource::where('id', $cource_post['new_course'])->first();
                        $email_params = array();
                        $email_params['cource_title'] = $cource->title;
                        $email_params['posted_cource_link'] = url('/instructor/' . $cource->slug);
                        $email_params['name'] = Helper::getUserName(Auth::user()->id);
                        $email_params['link'] = url('profile/' . $user->slug);
                        $template_data = Helper::getFreelancerCoursePostedEmailContent();
                        $template_data = (object)array();
                        $template_data->content = Helper::getFreelancerCoursePostedEmailContent();
                        $template_data->subject = "Course Posted";
                        Mail::to(Helper::getUserEmail(Auth::user()->id))
                            ->send(
                                new FreelancerEmailMailable(
                                    'freelancer_email_new_course_posted',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                    return $json;
                } elseif ($cource_post['type'] == 'error') {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.need_to_purchase_pkg');
                    return $json;
                } elseif ($cource_post['type'] == 'service_warning') {
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.not_authorize');
                    return $json;
                }
            }
        } else {
            $image_size = array(
                'small',
                'medium'
            );
            $cource_post = $this->cource->storeCource($request, $image_size);
            if ($cource_post['type'] == 'success') {
                $json['type'] = 'success';
                $json['progress'] = trans('lang.course_publishing');
                $json['message'] = trans('lang.course_post_success');
                // Send Email
                $user = User::find(Auth::user()->id);
                //send email to admin
                if (trim(config('mail.username')) != "" && trim(config('mail.password')) != "") {
                    $cource = $this->cource::where('id', $cource_post['new_cource'])->first();
                    $email_params = array();
                    $email_params['cource_title'] = $cource->title;
                    $email_params['posted_cource_link'] = url('/instructor/' . $cource->slug);
                    $email_params['name'] = Helper::getUserName(Auth::user()->id);
                    $email_params['link'] = url('profile/' . $user->slug);
                    $template_data = (object)array();
                    $template_data->content = Helper::getAdminCoursePostedEmailContent();
                    $template_data->subject = "Course Posted";
                    // $template_data = Helper::getFreelancerCoursePostedEmailContent();
                    Mail::to(env('MAIL_FROM_ADDRESS'))
                        ->send(
                            new AdminEmailMailable(
                                'admin_email_new_course_posted',
                                $template_data,
                                $email_params
                            )
                        );
                }
                if (trim(config('mail.username')) != "" && trim(config('mail.password')) != "") {
                    $cource = $this->cource::where('id', $cource_post['new_cource'])->first();
                    $email_params = array();
                    $email_params['cource_title'] = $cource->title;
                    $email_params['posted_cource_link'] = url('/instructor/' . $cource->slug);
                    $email_params['name'] = Helper::getUserName(Auth::user()->id);
                    $email_params['link'] = url('profile/' . $user->slug);
                    $template_data = Helper::getFreelancerCoursePostedEmailContent();
                    $template_data = (object)array();
                    $template_data->content = Helper::getFreelancerCoursePostedEmailContent();
                    $template_data->subject = "Course Posted";
                    Mail::to(Helper::getUserEmail(Auth::user()->id))
                        ->send(
                            new FreelancerEmailMailable(
                                'freelancer_email_new_course_posted',
                                $template_data,
                                $email_params
                            )
                        );
                }
                return $json;
            } elseif ($cource_post['type'] == 'error') {
                $json['type'] = 'error';
                $json['message'] = trans('lang.need_to_purchase_pkg');
                return $json;
            } elseif ($cource_post['type'] == 'service_warning') {
                $json['type'] = 'error';
                $json['message'] = trans('lang.not_authorize');
                return $json;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug slug
     *
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $selected_cource = $this->cource::select('id')->where('slug', $slug)->first();
        if (!empty($selected_cource)) {
            $cource = $this->cource::find($selected_cource->id);
            $currency   = SiteManagement::getMetaValue('commision');
            $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
            $mode = !empty($currency) && !empty($currency[0]['payment_mode']) ? $currency[0]['payment_mode'] : 'true';
            $delivery_time = DeliveryTime::where('id', $cource->delivery_time_id)->first();
            $response_time = ResponseTime::where('id', $cource->response_time_id)->first();
            $reasons = Helper::getReportReasons();
            $seller = $cource->seller->first();
            if(Auth::user()){
            $boughtcourse = DB::table('cource_user')->where('cource_id', $selected_cource->id)->where('user_id', Auth::user()->id)->where('status','bought')->get();
            $boughtcourse = !empty($boughtcourse[0]) ? true : false ;
            $waiting_status = DB::table('cource_user')->where('cource_id', $selected_cource->id)->where('user_id', Auth::user()->id)->where('status','waiting')->get();
            $waiting_status = !empty($waiting_status[0]) ? true : false ;
        }
           else{
               $boughtcourse = false;
               $waiting_status = false;
           }
            $reviews = !empty($seller) ? Helper::getCourceReviews($seller->id, $cource->id) : '';
            $auth_profile = Auth::user() ? auth()->user()->profile : '';
            if (!empty($reviews)) {
                $rating  = $reviews->sum('avg_rating') != 0 ? round($reviews->sum('avg_rating') / $reviews->count()) : 0;
            } else {
                $rating = 0;
            }

            $total_orders = Helper::getCourceCount($cource->id,'bought');
            $attachments = !empty($seller) ? Helper::getUnserializeData($cource->attachments) : '';
            // $service_reviews = DB::table('reviews')->where('job_id', $service->id)->get();
            $saved_cources = !empty(auth()->user()->profile->saved_cources) ? unserialize(auth()->user()->profile->saved_cources) : array();
            $course_saved = array_search($selected_cource->id,$saved_cources);
            $key = 'set_cource_view';
            $breadcrumbs_settings = SiteManagement::getMetaValue('show_breadcrumb');
            $show_breadcrumbs = !empty($breadcrumbs_settings) ? $breadcrumbs_settings : 'true';
            if (!isset($_COOKIE[$key . $selected_cource->id])) {
                setcookie($key . $selected_cource->id, $key, time() + 3600);
                $view_key = $key;
                $count = $cource->views;
                if ($count == '') {
                    $count = 1;
                } else {
                    $count++;
                }
                $cource->views = $count;
                $cource->save();
            }
            if (!empty($cource)) {
                if (file_exists(resource_path('views/extend/front-end/cources/show.blade.php'))) {
                    return view(
                        'extend.front-end.cources.show',
                        compact(
                            'cource',
                            'symbol',
                            'delivery_time',
                            'response_time',
                            'reasons',
                            'reviews',
                            'rating',
                            'seller',
                            'total_orders',
                            'attachments',
                            'saved_cources',
                            'course_saved',
                            'show_breadcrumbs',
                            'mode',
                            'boughtcourse',
                            'waiting_status'
                        )
                    );
                } else {
                    return view(
                        'front-end.cources.show',
                        compact(
                            'cource',
                            'symbol',
                            'delivery_time',
                            'response_time',
                            'reasons',
                            'reviews',
                            'rating',
                            'seller',
                            'total_orders',
                            'attachments',
                            'course_saved',
                            'saved_cources',
                            'show_breadcrumbs',
                            'mode',
                            'boughtcourse',
                            'waiting_status'
                        )
                    );
                }
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $languages = Language::pluck('title', 'id');
        $locations = Location::pluck('title', 'id');
        $response_time = ResponseTime::pluck('title', 'id');
        $delivery_time = DeliveryTime::pluck('title', 'id');
        $english_levels = Helper::getEnglishLevelList();
        $categories = Category::pluck('title', 'id');
        $cource = $this->cource::find($id);
        $serialize_attachment = preg_replace_callback(
            '!s:(\d+):"(.*?)";!',
            function ($match) {
                return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
            },
            $cource->attachments
        );
        $freelancer  = Helper::getCourceSeller($cource->id);
        $attachments = !empty($serialize_attachment) ? unserialize($serialize_attachment) : '';
        if (file_exists(resource_path('views/extend/back-end/freelancer/courses/edit.blade.php'))) {
            return view(
                'extend.back-end.freelancer.courses.edit',
                compact(
                    'english_levels',
                    'languages',
                    'categories',
                    'locations',
                    'response_time',
                    'delivery_time',
                    'cource',
                    'attachments',
                    'freelancer'
                )
            );
        } else {
            return view(
                'back-end.freelancer.courses.edit',
                compact(
                    'english_levels',
                    'languages',
                    'categories',
                    'locations',
                    'response_time',
                    'delivery_time',
                    'cource',
                    'attachments',
                    'freelancer'
                )
            );
        }
    }

    /**
     * Updated resource in DB.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $server = Helper::worketicIsDemoSiteAjax();
        if (!empty($server)) {
            $response['type'] = 'error';
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $json = array();
        if (!empty($request['latitude']) || !empty($request['longitude'])) {
            $this->validate(
                $request,
                [
                    'latitude' => ['regex:/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/'],
                    'longitude' => ['regex:/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}$/'],
                ]
            );
        }
        $this->validate(
            $request,
            [
                'title' => 'required',
                'delivery_time'    => 'required',
                'course_price'    => 'required',
                'response_time'    => 'required',
                'english_level'    => 'required',
                'description'    => 'required',
            ]
        );
        $id = $request['id'];
        if (!empty($id)) {
            $image_size = array(
                'small',
                'medium'
            );
            $course_update = $this->cource->updateCourse($request, $id, $image_size);
            if ($course_update['type'] = 'success') {
                $json['type'] = 'success';
                $json['role'] = Auth::user()->getRoleNames()->first();
                $json['progress'] = trans('lang.course_updating');
                $json['message'] = trans('lang.course_update_success');
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.something_wrong');
                return $json;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
            $course = $this->cource::find($request['id']);
            $course->users()->detach();
            $course->delete();
            DB::table('cource_user')->where('cource_id', $request['user_id'])->delete();
            $json['type'] = 'success';
            $json['message'] = trans('lang.course_delete');
            return $json;
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Upload image to temporary folder.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTempImage(Request $request)
    {
        if (!empty($request['file'])) {
            $attachments = $request['file'];
            $path = Helper::PublicPath() . '/uploads/courses/temp/';
            $image_size = array(
                'small' => array(
                    'width' => 80,
                    'height' => 80,
                ),
                'medium' => array(
                    'width' => 670,
                    'height' => 450,
                ),
            );
            return Helper::uploadTempImageWithSize($path, $attachments, '', $image_size);
        }
    }

    /**
     * Change service status
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
            $orders = Helper::getCourseOrdersCount($request['id'], 'hired');
            if ($orders == 0) {
                $cource = $this->cource::find($request['id']);
                $cource->status = $request['status'];
                $cource->save();
                $json['type'] = 'success';
                $json['message'] = trans('lang.status_update');
                return $json;
            } else {
                $json['type'] = 'error';
                $json['message'] = trans('lang.need_complete_orders');
                return $json;
            }
        } else {
            $json['type'] = 'error';
            $json['message'] = trans('lang.something_wrong');
            return $json;
        }
    }

    /**
     * Get service settings.
     *
     * @param integer $request $request->attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function getCourseSettings(Request $request)
    {
        $json = array();
        if ($request['id']) {
            $settings = Cource::find($request['id'])
                ->select('is_featured', 'show_attachments')->first();
            if (!empty($settings)) {
                $json['type'] = 'success';
                if ($settings->is_featured == 'true') {
                    $json['is_featured'] = 'true';
                }
                if ($settings->show_attachments == 'true') {
                    $json['show_attachments'] = 'true';
                }
            } else {
                $json['type'] = 'error';
            }
            return $json;
        }
    }

  

    /**
     * Upload Image to temporary folder.
     *
     * @param \Illuminate\Http\Request $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTempMessageAttachments(Request $request)
    {
        if (!empty($request['file'])) {
            $attachments = $request['file'];
            $path = 'uploads/services/temp/';
            return Helper::uploadTempMultipleAttachments($attachments, $path);
        }
    }

    /**
     * Show services.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminServices()
    {
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $services = $this->service::where('title', 'like', '%' . $keyword . '%')->paginate(6)->setPath('');
            $pagination = $services->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $services = $this->service->latest()->paginate(8);
        }
        $currency   = SiteManagement::getMetaValue('commision');
        $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $status_list = array_pluck(Helper::getFreelancerServiceStatus(), 'title', 'value');
        if (file_exists(resource_path('views/extend/back-end/admin/services/index.blade.php'))) {
            return view(
                'extend.back-end.admin.services.index',
                compact('services', 'symbol', 'status_list')
            );
        } else {
            return view(
                'back-end.admin.services.index',
                compact('services', 'symbol', 'status_list')
            );
        }
    }

    /**
     * Show services orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminServiceOrders()
    {
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $orders = DB::table('service_user')->where('type', 'employer')->paginate(8);
            $pagination = $orders->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $orders = DB::table('service_user')->where('type', 'employer')->paginate(8);
        }
        $currency   = SiteManagement::getMetaValue('commision');
        $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $payment_methods = Arr::pluck(Helper::getPaymentMethodList(), 'title', 'value');
        if (file_exists(resource_path('views/extend/back-end/admin/services/order.blade.php'))) {
            return view(
                'extend.back-end.admin.services.order',
                compact('orders', 'symbol', 'payment_methods')
            );
        } else {
            return view(
                'back-end.admin.services.order',
                compact('orders', 'symbol', 'payment_methods')
            );
        }
    }
    /**
     * Get services
     *
     * @param mixed $request request attributes
     *
     * @return \Illuminate\Http\Response
     */
    public function getServices()
    {
        $json = array();
        $service_list = array();
        if (Schema::hasTable('services') && Schema::hasTable('service_user')) {
            $services = $this->service::latest()->paginate(6);
            foreach ($services as $key => $service) {
                $service_list[$key]['title'] = $service->title;
                $service_list[$key]['is_featured'] = $service->is_featured;
                $service_list[$key]['slug'] = $service->slug;
                $service_list[$key]['price'] = $service->price;
                $service_list[$key]['seller'] = $service->seller->toArray();
                $service_list[$key]['seller_count'] = $service->seller->count();
                $service_reviews = $service->seller->count() > 0 ? Helper::getServiceReviews($service->seller[0]->id, $service->id) : ''; 
                $service_list[$key]['service_reviews'] = !empty($service_reviews) ? $service_reviews->count() : '';
                $service_list[$key]['service_rating']  = !empty($service_reviews) && $service_reviews->sum('avg_rating') != 0 ? round($service_reviews->sum('avg_rating') / $service_reviews->count()) : 0;
                $service_list[$key]['attachments'] = Helper::getUnserializeData($service->attachments);
                $attachments = Helper::getUnserializeData($service->attachments);
                // $service_list[$key]['enable_slider'] = !empty($attachments) ? 'wt-servicesslider' : '';
                $service_list[$key]['enable_slider'] = count($attachments) > 1 ? 'wt-freelancerslider owl-carousel' : '';
                $service_list[$key]['no_attachments'] = empty($attachments) ? 'la-service-info' : '';
                $service_list[$key]['total_orders'] = Helper::getServiceCount($service->id, 'hired');
                $service_list[$key]['seller_name'] = !empty($service->seller[0]) ? Helper::getUserName($service->seller[0]->id) : '';
                $service_list[$key]['seller_image'] = !empty($service->seller[0]) ? asset(Helper::getProfileImage($service->seller[0]->id)): '';
                if (!empty($attachments)) {
                    foreach ($attachments as $attachment_key => $attachment) {
                        $service_list[$key]['attachments'][$attachment_key] =  !empty($service->seller[0]) ? asset(Helper::getImageWithSize('uploads/services/'.$service->seller[0]->id, $attachment, 'medium')) : '';
                    }
                }
                $currency   = SiteManagement::getMetaValue('commision');
                $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
                $service_list[$key]['symbol'] = !empty($symbol['symbol']) ? $symbol['symbol'] : '$';
            }
        }
        if (!empty($service_list)) {
            $json['type'] = 'success';
            $json['services'] = $service_list;
            return $json;
        } else {
            $json['type'] = 'error';
            return $json;
        }
    }
    public function employerPaymentProcess($id)
    {
        if (Auth::user() && !empty($id)) {
            if (Auth::user()->getRoleNames()->first() === 'freelancer') {
                $user_id = Auth::user()->id;
                $employer = User::find($user_id);
                $service = Cource::find($id);
                $seller = Helper::getCourceSeller($service->id);
                $freelancer = User::find($seller->user_id);
                $freelancer_name = Helper::getUserName($freelancer->id);
                $profile = User::find($freelancer->id)->profile;
                $user_image = !empty($profile) ? $profile->avater : '';
                $profile_image = !empty($user_image) ? '/uploads/users/' . $freelancer->id . '/' . $user_image : 'images/user-login.png';
                $payout_settings = SiteManagement::getMetaValue('commision');
                $payment_gateway = !empty($payout_settings) && !empty($payout_settings[0]['payment_method']) ? $payout_settings[0]['payment_method'] : null;
                $currency   = SiteManagement::getMetaValue('commision');
                $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
               
               if(!empty($payout_settings) && !empty($payout_settings[0]['commision'] || $payout_settings[0]['commision'] == 0 || $payout_settings[0]['commision'] == 'Null'))
                {
                    $commision_amount = ($payout_settings[0]['emp_commision']/100)*$service->price;
                    $total_amount = $service->price + $commision_amount;
                }


                if (file_exists(resource_path('views/extend/back-end/employer/services/checkout.blade.php'))) {
                    return view(
                        'extend.back-end.employer.services.checkout',
                        compact(
                            'service',
                            'freelancer_name',
                            'profile_image',
                            'payment_gateway',
                            'symbol',
                            'user_id',
                            'freelancer',
                            'commision_amount',
                            'total_amount'
                        )
                    );
                } else {
                    return view(
                        'back-end.employer.services.checkout',
                        compact(
                            'service',
                            'freelancer_name',
                            'profile_image',
                            'payment_gateway',
                            'symbol',
                            'user_id',
                            'freelancer',
                            'commision_amount',
                            'total_amount'
                        )
                    );
                }
            } else {
                Session::flash('error', trans('lang.buy_course_warning'));
                return Redirect::back();
            }
        } else {
            Session::flash('error', trans('lang.buy_course_warning'));
            return Redirect::back();
        }
    }
    public function getCourseSkills(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
            // $course = $this->cource::where('slug', $request['slug'])->select('id')->first();
            
                $course = $this->cource::find($request['id']);
                if (!empty($course)) {
                $skills = $course->skills->toArray();
                if (!empty($skills)) {
                    $json['type'] = 'success';
                    $json['skills'] = $skills;
                    return $json;
                } else {
                    $json['error'] = 'error';
                    return $json;
                }
            } else {
                $json['error'] = 'error';
                return $json;
            }
      }
    }
    public function StudentsListing($course_id)
    {
        if (Auth::user() && Auth::user()->getRoleNames()->first() === 'freelancer') {
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                $keyword_tokens = explode(' ', $keyword);
                $count = count($keyword_tokens);
                $buyers =DB::table('cource_user')->where('cource_id', $course_id)->where('status', 'bought')->pluck('user_id');
                if($count>1){
                    $users = User::where('first_name', 'like', '%' . $keyword_tokens[0] . '%')->where('last_name', 'like', '%' . $keyword_tokens[$count-1] . '%')->whereIn('id',$buyers)->paginate(7)->setPath('');
                }
                else{
                    $users = User::whereIn('id',$buyers)
                    ->where(function ($query) use($keyword){ $query->where('first_name', 'like', '%' . $keyword . '%')
                        ->orWhere('last_name', 'like', '%' . $keyword . '%');
                    })->paginate(7)->setPath('');
                    // dd($users);
                }
                $pagination = $users->appends(
                    array(
                        'keyword' => Input::get('keyword')
                    )
                );
            } else {
                $users = Helper::getCourseBuyers($course_id);
                // dd($users);
            }
            /* if (file_exists(resource_path('views/extend/back-end/admin/users/index.blade.php'))) {
                return view('extend.back-end.admin.users.index', compact('users'));
            } else { */
                return view('back-end.freelancer.courses.enrolled-students', compact('users'));
           // }
        } else {
            abort(404);
        }
    }

    public function generateOrder($id){
        $symbol = !empty($payout_settings) && !empty($payout_settings[0]['currency']) ? Helper::currencyList($payout_settings[0]['currency']) : array();
        $mode = !empty($payout_settings) && !empty($payout_settings[0]['payment_mode']) ? $payout_settings[0]['payment_mode'] : 'true';
        $bank_detail = SiteManagement::getMetaValue('bank_detail');
        $subtitle = '';
        $options = '';
        $seller = '';
        $payrols = Helper::getPayoutsList();
        $user = User::find(Auth::user()->id);
        // $location = Location::select('title')->where('id',$user->location_id)->first();
        // $user->location_name = $location->title; 
        $course = Cource::find($id);
        $title = $course->title;
        $seller = Helper::getCourceSeller($course->id);
        $freelancer = User::find($seller->user_id);
        $cost = $course->price;
        $payout_settings = $user->profile->count() > 0 ? Helper::getUnserializeData($user->profile->payout_settings) : '';
        return view('back-end.freelancer.courses.checkout', compact('course','freelancer','symbol','mode','bank_detail','subtitle','options','seller','title', 'cost','payrols' , 'user' , 'payout_settings'));
    }
    public function courseOrders(){
        $courses = DB::table('cource_user')->where('status','waiting')->where('seller_id',Auth::user()->id)->get();
        $status_list = array_pluck(Helper::getFreelancerCourseStatus(), 'title', 'value');
    
        return view('back-end.freelancer.courses.course-orders',compact('courses','status_list'));
    }
    public function waitingStudents($course_id){
        $courses = DB::table('cource_user')->where('status','waiting')->where('seller_id',Auth::user()->id)
        ->where('cource_id',$course_id)->get();
        $status_list = array_pluck(Helper::getFreelancerCourseStatus(), 'title', 'value');
    
        return view('back-end.freelancer.courses.course-orders',compact('courses','status_list'));
    }
    public function changeCourseStatus(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
                if ($request['status']=='enroll'){
                    //capture Payment
                    if (!empty(env('STRIPE_SECRET'))) {
                        \Artisan::call('optimize:clear');
                        $stripe = Stripe::make(env('STRIPE_SECRET'));
                    } else {
                        // Session::flash('error', trans('lang.empty_stripe_key'));
                        // return Redirect::back();
                        $json['type'] = 'error';
                        $json['message'] = trans('lang.empty_stripe_key');
                        return $json;
                    }
                    try {
                        $invoice_id= DB::table('cource_user')->where('id',$request['id'])->pluck('invoice_id')->first();
                        $transaction_id = DB::table('invoices')->where('id',$invoice_id)->pluck('transaction_id')->first();
                        $amount = DB::table('invoices')->where('id',$invoice_id)->pluck('price')->first();
                        $capture = $stripe->charges()->capture($transaction_id);
                        if ($capture['status'] == 'succeeded') {
                            DB::table('cource_user')->where('id',$request['id'])->update(['status'=>"bought"]);
                            $courseid = DB::table('cource_user')->where('id',$request['id'])->pluck('cource_id')->first();
                            $userid = DB::table('cource_user')->where('id',$request['id'])->pluck('user_id')->first();
                            $freelancer = User::find($userid);
                            // code for changing order status from pending to completed
                            DB::table('orders')->where('product_id',$courseid)->where('user_id',$userid)->update(['status'=>"completed"]);
                            $course = Cource::find($courseid);
                            $user = User::find(intval(Auth::user()->id));
                            
            
                            // send message to student
                            $message = new Message();
                            $message->user()->associate($user);
                            $message->receiver_id = intval($userid);
                            $message->body = 'Your Request For the Course is Accepted by the Instructor '.Helper::getUserName(Auth::user()->id) . ' ' . 'welcome to' . ' ' . $course->title;
                            $message->status = 0;
                            $message->save();
                            // send mail
                            // if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                            //     $email_params = array();
                            //     $template_data = Helper::getFreelancerCourseEnrollEmailContent();
                            //     $email_params['title'] = $course->title;
                            //     $email_params['course_link'] = url('instructor/' . $course->slug);
                            //     $email_params['amount'] = $course->price;
                            //     $email_params['freelancer_name'] = Helper::getUserName($userid);
                            //     $email_params['employer_profile'] = url('profile/' . $user->slug);
                            //     $email_params['employer_name'] = Helper::getUserName($user->id);
                            //     $freelancer_data = User::find(intval($userid));
                            //     Mail::to($freelancer_data->email)
                            //         ->send(
                            //             new FreelancerEmailMailable(
                            //                 'freelancer_email_course_enrolled',
                            //                 $template_data,
                            //                 $email_params
                            //             )
                            //         );
                            
                                        
                            // } 
                            $json['type'] = 'success';
                            $json['message'] = trans('lang.status_update');
                            return $json;


                        }
                        else {
                            $json['type'] = 'error';
                            $json['message'] = trans('lang.money_not_add');
                            return $json;
                        }
                    
                    
                        }
        
                    
                    catch (Exception $e) {
                        $json['type'] = 'error';
                        $json['message'] = $e->getMessage();
                        return $json;
                    }
               }
               if ($request['status']=='cancel'){
                   //capture Payment
                   if (!empty(env('STRIPE_SECRET'))) {
                    \Artisan::call('optimize:clear');
                    $stripe = Stripe::make(env('STRIPE_SECRET'));
                } else {
                    // Session::flash('error', trans('lang.empty_stripe_key'));
                    // return Redirect::back();
                    $json['type'] = 'error';
                    $json['message'] = trans('lang.empty_stripe_key');
                    return $json;
                }
                try {
                    $invoice_id= DB::table('cource_user')->where('id',$request['id'])->pluck('invoice_id')->first();
                    $transaction_id = DB::table('invoices')->where('id',$invoice_id)->pluck('transaction_id')->first();
                    $amount = DB::table('invoices')->where('id',$invoice_id)->pluck('price')->first();
                    $refund = $stripe->refunds()->create(
                      $transaction_id

                    );
                    if ($refund['status'] == 'succeeded') {
                        $courseid = DB::table('cource_user')->where('id',$request['id'])->pluck('cource_id')->first();
                        $userid = DB::table('cource_user')->where('id',$request['id'])->pluck('user_id')->first();
                        $freelancer = User::find($userid);
                        DB::table('cource_user')->where('id',$request['id'])->delete();
                        DB::table('orders')->where('product_id',$courseid)->where('user_id',$userid)->delete();
                        $course = Cource::find($courseid);
                        $user = User::find(intval(Auth::user()->id));
                          // send message to student
                          $message = new Message();
                          $message->user()->associate($user);
                          $message->receiver_id = intval($userid);
                          $message->body = 'Your Request For the Course '.$course->title.' is Denied by the Instructor '.Helper::getUserName(Auth::user()->id).'. Your Payment has been refunded';
                          $message->status = 0;
                          $message->save();
                          //add mail code
                        //   if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                        //     $email_params = array();
                        //     $template_data = Helper::getFreelancerCoursePaymentRefundEmailContent();
                        //     $email_params['title'] = $course->title;
                        //     $email_params['course_link'] = url('instructor/' . $course->slug);
                        //     $email_params['amount'] = $course->price;
                        //     $email_params['freelancer_name'] = Helper::getUserName($userid);
                        //     $email_params['employer_profile'] = url('profile/' . $user->slug);
                        //     $email_params['employer_name'] = Helper::getUserName($user->id);
                        //     $freelancer_data = User::find(intval($userid));
                        //     Mail::to($freelancer_data->email)
                        //         ->send(
                        //             new FreelancerEmailMailable(
                        //                 'freelancer_email_course_cancelled',
                        //                 $template_data,
                        //                 $email_params
                        //             )
                        //         );
                        
                                    
                        // }

                        $json['type'] = 'success';
                        $json['message'] = trans('lang.status_update');
                        return $json;
                        
                    }
                    else{

                        $json['type'] = 'error';
                        $json['message'] = trans('lang.money_not_add');
                        return $json;

                    }
                        
                }
                catch (Exception $e) {
                    $json['type'] = 'error';
                    $json['message'] = $e->getMessage();
                    return $json;
                }

            }
        }  
    }     
}  