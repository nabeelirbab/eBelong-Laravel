<?php

namespace App\Http\Controllers;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Srmklive\PayPal\Services\ExpressCheckout;
use Stripe\Error\Card;
use Illuminate\Http\Request;
use App\Language;
use App\Skill;
use App\Category;
use App\Location;
use App\Helper;
use App\ResponseTime;
use App\DeliveryTime;
use App\Service;
use App\Cource;
use App\Item;
use App\Invoice;
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
use Illuminate\Support\Facades\Crypt;
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

    protected $provider;

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
        $this->provider = new ExpressCheckout();
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
                'user_type'    => 'required',
                'english_level'    => 'required',
                'description'    => 'required',
            ]
        );
        // if (!empty($request['latitude']) || !empty($request['longitude'])) {
        //     $this->validate(
        //         $request,
        //         [
        //             'latitude' => ['regex:/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/'],
        //             'longitude' => ['regex:/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}$/'],
        //         ]
        //     );
        // }
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
        // dd($payment_settings);
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
                        $email_params['posted_cource_link'] = url('/course/' . $cource->slug);
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
                        $email_params['posted_cource_link'] = url('/course/' . $cource->slug);
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
                    $email_params['posted_cource_link'] = url('/course/' . $cource->slug);
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
                    $email_params['posted_cource_link'] = url('/course/' . $cource->slug);
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
            if (Auth::user()) {
                $boughtcourse = DB::table('cource_user')->where('cource_id', $selected_cource->id)->where('user_id', Auth::user()->id)->where('status', 'bought')->get();
                $boughtcourse = !empty($boughtcourse[0]) ? true : false;
                $waiting_status = DB::table('cource_user')->where('cource_id', $selected_cource->id)->where('user_id', Auth::user()->id)->where('status', 'waiting')->get();
                $waiting_status = !empty($waiting_status[0]) ? true : false;
            } else {
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

            $total_orders = Helper::getCourceCount($cource->id, 'bought');
            $attachments = !empty($seller) ? Helper::getUnserializeData($cource->attachments) : '';
            // $service_reviews = DB::table('reviews')->where('job_id', $service->id)->get();
            $saved_cources = !empty(auth()->user()->profile->saved_cources) ? unserialize(auth()->user()->profile->saved_cources) : array();
            $course_saved = array_search($selected_cource->id, $saved_cources);
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
            $orders = Helper::getCourseOrdersCount($request['id'], 'bought');
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
    public function adminCourses()
    {
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $courses = $this->cource::where('title', 'like', '%' . $keyword . '%')->paginate(6)->setPath('');
            $pagination = $courses->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $courses = $this->cource->latest()->paginate(8);
        }
        $currency   = SiteManagement::getMetaValue('commision');
        $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $status_list = array_pluck(Helper::getFreelancerServiceStatus(), 'title', 'value');
        if (file_exists(resource_path('views/extend/back-end/admin/courses/index.blade.php'))) {
            return view(
                'extend.back-end.admin.courses.index',
                compact('courses', 'symbol', 'status_list')
            );
        } else {
            return view(
                'back-end.admin.courses.index',
                compact('courses', 'symbol', 'status_list')
            );
        }
    }

    /**
     * Show services orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminCourseOrders()
    {
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $orders = DB::table('cource_user')->where('type', 'employer')->paginate(8);
            $pagination = $orders->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $orders = DB::table('cource_user')->where('type', 'employer')->paginate(8);
        }
        $currency   = SiteManagement::getMetaValue('commision');
        $symbol = !empty($currency) && !empty($currency[0]['currency']) ? Helper::currencyList($currency[0]['currency']) : array();
        $payment_methods = Arr::pluck(Helper::getPaymentMethodList(), 'title', 'value');
        if (file_exists(resource_path('views/extend/back-end/admin/courses/order.blade.php'))) {
            return view(
                'extend.back-end.admin.courses.order',
                compact('orders', 'symbol', 'payment_methods')
            );
        } else {
            return view(
                'back-end.admin.courses.order',
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
                $service_list[$key]['seller_image'] = !empty($service->seller[0]) ? asset(Helper::getProfileImage($service->seller[0]->id)) : '';
                if (!empty($attachments)) {
                    foreach ($attachments as $attachment_key => $attachment) {
                        $service_list[$key]['attachments'][$attachment_key] =  !empty($service->seller[0]) ? asset(Helper::getImageWithSize('uploads/services/' . $service->seller[0]->id, $attachment, 'medium')) : '';
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

                if (!empty($payout_settings) && !empty($payout_settings[0]['commision'] || $payout_settings[0]['commision'] == 0 || $payout_settings[0]['commision'] == 'Null')) {
                    $commision_amount = ($payout_settings[0]['emp_commision'] / 100) * $service->price;
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
                $buyers = DB::table('cource_user')->where('cource_id', $course_id)->where('status', 'bought')->pluck('user_id');
                if ($count > 1) {
                    $users = User::where('first_name', 'like', '%' . $keyword_tokens[0] . '%')->where('last_name', 'like', '%' . $keyword_tokens[$count - 1] . '%')->whereIn('id', $buyers)->paginate(7)->setPath('');
                } else {
                    $users = User::whereIn('id', $buyers)
                        ->where(function ($query) use ($keyword) {
                            $query->where('first_name', 'like', '%' . $keyword . '%')
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
            return view('back-end.freelancer.courses.enrolled-students', compact('users', 'course_id'));
            // }
        } else {
            abort(404);
        }
    }
    public function stripePage(Request $request)
    {
        $encryptedAmount = $request->input('amount');
        try {
            $cost = Crypt::decrypt($encryptedAmount);

            $stripe = Stripe::make('sk_test_ws2GR8HLb9gMtA9dAyvnclCL');
            $paymentIntent = $stripe->paymentIntents()->create([
                'amount' => $cost, // Replace with your actual amount, in cents
                'currency' => 'usd',
            ]);

            $clientSecret = $paymentIntent['client_secret'];
            return view('back-end.freelancer.courses.stripe-payment', compact('clientSecret', 'cost'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Handle the exception if decryption fails
        }
    }
    public function generateOrder($id)
    {

        $symbol = !empty($payout_settings) && !empty($payout_settings[0]['currency']) ? Helper::currencyList($payout_settings[0]['currency']) : array();
        $mode = !empty($payout_settings) && !empty($payout_settings[0]['payment_mode']) ? $payout_settings[0]['payment_mode'] : 'true';
        $bank_detail = SiteManagement::getMetaValue('bank_detail');
        $subtitle = '';
        $options = '';
        $seller = '';
        $payrols = Helper::getPayoutsList();
        $payout_settings = SiteManagement::getMetaValue('commision');
        $payment_methods = !empty($payout_settings) && !empty($payout_settings[0]['payment_method']) ? $payout_settings[0]['payment_method'] : null;
        // dd($payment_methods);
        $user = User::find(Auth::user()->id);
        // $location = Location::select('title')->where('id',$user->location_id)->first();
        // $user->location_name = $location->title; 
        $course = Cource::find($id);
        $title = $course->title;
        $seller = Helper::getCourceSeller($course->id);
        $freelancer = User::find($seller->user_id);
        $cost = $course->price;
        // Create a Payment Intent

        $payout_settings = $user->profile->count() > 0 ? Helper::getUnserializeData($user->profile->payout_settings) : '';
        return view('back-end.freelancer.courses.checkout', compact('course', 'freelancer', 'symbol', 'mode', 'bank_detail', 'subtitle', 'options', 'seller', 'title', 'cost', 'payrols', 'user', 'payout_settings', 'payment_methods'));
    }
    public function courseOrders()
    {
        $courses = DB::table('cource_user')->where('status', 'waiting')->where('seller_id', Auth::user()->id)->get();
        $status_list = array_pluck(Helper::getFreelancerCourseStatus(), 'title', 'value');

        return view('back-end.freelancer.courses.course-orders', compact('courses', 'status_list'));
    }
    public function waitingStudents($course_id)
    {
        $courses = DB::table('cource_user')->where('status', 'waiting')->where('seller_id', Auth::user()->id)
            ->where('cource_id', $course_id)->get();
        $status_list = array_pluck(Helper::getFreelancerCourseStatus(), 'title', 'value');

        return view('back-end.freelancer.courses.course-orders', compact('courses', 'status_list'));
    }
    public function changeCourseStatus(Request $request)
    {
        $json = array();
        if (!empty($request['id'])) {
            $invoice_id = DB::table('cource_user')->where('id', $request['id'])->pluck('invoice_id')->first();
            $paymentmode = DB::table('invoices')->where('id', $invoice_id)->pluck('payment_mode')->first();
            if ($request['status'] == 'enroll') {

                if ($paymentmode == 'stripe') {
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
                        $invoice_id = DB::table('cource_user')->where('id', $request['id'])->pluck('invoice_id')->first();
                        $transaction_id = DB::table('invoices')->where('id', $invoice_id)->pluck('transaction_id')->first();
                        $amount = DB::table('invoices')->where('id', $invoice_id)->pluck('price')->first();
                        $capture = $stripe->charges()->capture($transaction_id);
                        if ($capture['status'] == 'succeeded') {
                            DB::table('cource_user')->where('id', $request['id'])->update(['status' => "bought"]);
                            $courseid = DB::table('cource_user')->where('id', $request['id'])->pluck('cource_id')->first();
                            $userid = DB::table('cource_user')->where('id', $request['id'])->pluck('user_id')->first();
                            $freelancer = User::find($userid);
                            // code for changing order status from pending to completed
                            DB::table('orders')->where('product_id', $courseid)->where('user_id', $userid)->update(['status' => "completed"]);
                            $course = Cource::find($courseid);
                            $user = User::find(intval(Auth::user()->id));


                            // send message to student
                            $message = new Message();
                            $message->user()->associate($user);
                            $message->receiver_id = intval($userid);
                            $message->body = 'Your Request For the Course is Accepted by the Instructor ' . Helper::getUserName(Auth::user()->id) . ' ' . 'welcome to' . ' ' . $course->title;
                            $message->status = 0;
                            $message->save();
                            // send mail
                            if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                                $email_params = array();
                                $template_data = (object)array();
                                $template_data->content = Helper::getFreelancerCourseEnrollEmailContent();
                                $template_data->subject = "Course Enrollment Confirmed";
                                $email_params['title'] = $course->title;
                                $email_params['course_link'] = url('course/' . $course->slug);
                                $email_params['amount'] = $course->price;
                                $email_params['freelancer_name'] = Helper::getUserName($userid);
                                $email_params['employer_profile'] = url('profile/' . $user->slug);
                                $email_params['employer_name'] = Helper::getUserName($user->id);
                                $freelancer_data = User::find(intval($userid));
                                Mail::to($freelancer_data->email)
                                    ->send(
                                        new FreelancerEmailMailable(
                                            'freelancer_email_course_enrolled',
                                            $template_data,
                                            $email_params
                                        )
                                    );
                            }
                            $json['type'] = 'success';
                            $json['message'] = trans('lang.status_update');
                            return $json;
                        } else {
                            $json['type'] = 'error';
                            $json['message'] = trans('lang.money_not_add');
                            return $json;
                        }
                    } catch (Exception $e) {
                        $json['type'] = 'error';
                        $json['message'] = $e->getMessage();
                        return $json;
                    }
                } elseif ($paymentmode = "bacs") {

                    DB::table('cource_user')->where('id', $request['id'])->update(['status' => "bought", 'paid' => 'completed']);
                    $courseid = DB::table('cource_user')->where('id', $request['id'])->pluck('cource_id')->first();
                    $userid = DB::table('cource_user')->where('id', $request['id'])->pluck('user_id')->first();
                    $freelancer = User::find($userid);
                    // code for changing order status from pending to completed
                    DB::table('orders')->where('product_id', $courseid)->where('user_id', $userid)->where('type', 'course')->update(['status' => "completed"]);
                    $course = Cource::find($courseid);
                    $user = User::find(intval(Auth::user()->id));


                    // send message to student
                    $message = new Message();
                    $message->user()->associate($user);
                    $message->receiver_id = intval($userid);
                    $message->body = 'Your Request For the Course is Accepted by the Instructor ' . Helper::getUserName(Auth::user()->id) . ' ' . 'welcome to' . ' ' . $course->title;
                    $message->status = 0;
                    $message->save();
                    // send mail
                    if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                        $email_params = array();
                        $template_data = (object)array();
                        $template_data->content = Helper::getFreelancerCourseEnrollEmailContent();
                        $template_data->subject = "Course Enrollment Confirmed";
                        $email_params['title'] = $course->title;
                        $email_params['course_link'] = url('course/' . $course->slug);
                        $email_params['amount'] = $course->price;
                        $email_params['freelancer_name'] = Helper::getUserName($userid);
                        $email_params['employer_profile'] = url('profile/' . $user->slug);
                        $email_params['employer_name'] = Helper::getUserName($user->id);
                        $freelancer_data = User::find(intval($userid));
                        Mail::to($freelancer_data->email)
                            ->send(
                                new FreelancerEmailMailable(
                                    'freelancer_email_course_enrolled',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                    $json['type'] = 'success';
                    $json['message'] = trans('lang.status_update');
                    return $json;
                } else {
                    //paypal 
                    DB::table('cource_user')->where('id', $request['id'])->update(['status' => "bought"]);
                    $courseid = DB::table('cource_user')->where('id', $request['id'])->pluck('cource_id')->first();
                    $userid = DB::table('cource_user')->where('id', $request['id'])->pluck('user_id')->first();
                    $freelancer = User::find($userid);
                    // code for changing order status from pending to completed
                    DB::table('orders')->where('product_id', $courseid)->where('user_id', $userid)->update(['status' => "completed"]);
                    $course = Cource::find($courseid);
                    $user = User::find(intval(Auth::user()->id));


                    // send message to student
                    $message = new Message();
                    $message->user()->associate($user);
                    $message->receiver_id = intval($userid);
                    $message->body = 'Your Request For the Course is Accepted by the Instructor ' . Helper::getUserName(Auth::user()->id) . ' ' . 'welcome to' . ' ' . $course->title;
                    $message->status = 0;
                    $message->save();
                    // send mail
                    if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                        $email_params = array();
                        $template_data = (object)array();
                        $template_data->content = Helper::getFreelancerCourseEnrollEmailContent();
                        $template_data->subject = "Course Enrollment Confirmed";
                        $email_params['title'] = $course->title;
                        $email_params['course_link'] = url('course/' . $course->slug);
                        $email_params['amount'] = $course->price;
                        $email_params['freelancer_name'] = Helper::getUserName($userid);
                        $email_params['employer_profile'] = url('profile/' . $user->slug);
                        $email_params['employer_name'] = Helper::getUserName($user->id);
                        $freelancer_data = User::find(intval($userid));
                        Mail::to($freelancer_data->email)
                            ->send(
                                new FreelancerEmailMailable(
                                    'freelancer_email_course_enrolled',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                    $json['type'] = 'success';
                    $json['message'] = trans('lang.status_update');
                    return $json;
                }
            }
            if ($request['status'] == 'cancel') {
                if ($paymentmode == "stripe") {
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
                        $invoice_id = DB::table('cource_user')->where('id', $request['id'])->pluck('invoice_id')->first();
                        $transaction_id = DB::table('invoices')->where('id', $invoice_id)->pluck('transaction_id')->first();
                        $amount = DB::table('invoices')->where('id', $invoice_id)->pluck('price')->first();
                        $refund = $stripe->refunds()->create(
                            $transaction_id

                        );
                        if ($refund['status'] == 'succeeded') {
                            $courseid = DB::table('cource_user')->where('id', $request['id'])->pluck('cource_id')->first();
                            $invoice = DB::table('cource_user')->where('id', $request['id'])->pluck('invoice_id')->first();
                            $userid = DB::table('cource_user')->where('id', $request['id'])->pluck('user_id')->first();
                            $freelancer = User::find($userid);
                            DB::table('cource_user')->where('id', $request['id'])->delete();
                            DB::table('orders')->where('product_id', $request['id'])->where('invoice_id', $invoice)->delete();
                            $course = Cource::find($courseid);
                            $user = User::find(intval(Auth::user()->id));
                            // send message to student
                            $message = new Message();
                            $message->user()->associate($user);
                            $message->receiver_id = intval($userid);
                            $message->body = 'Your Request For the Course ' . $course->title . ' is Denied by the Instructor ' . Helper::getUserName(Auth::user()->id) . '. Your Payment has been refunded';
                            $message->status = 0;
                            $message->save();
                            //add mail code
                            if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                                $email_params = array();
                                $template_data = (object)array();
                                $template_data->content = Helper::getFreelancerCoursePaymentRefundEmailContent();
                                $template_data->subject = "Course Order Cancelled";
                                // $template_data = Helper::getFreelancerCoursePaymentRefundEmailContent();
                                $email_params['title'] = $course->title;
                                $email_params['course_link'] = url('course/' . $course->slug);
                                $email_params['amount'] = $course->price;
                                $email_params['freelancer_name'] = Helper::getUserName($userid);
                                $email_params['employer_profile'] = url('profile/' . $user->slug);
                                $email_params['employer_name'] = Helper::getUserName($user->id);
                                $freelancer_data = User::find(intval($userid));
                                Mail::to($freelancer_data->email)
                                    ->send(
                                        new FreelancerEmailMailable(
                                            'freelancer_email_course_cancelled',
                                            $template_data,
                                            $email_params
                                        )
                                    );
                            }

                            $json['type'] = 'success';
                            $json['message'] = trans('lang.status_update');
                            return $json;
                        } else {

                            $json['type'] = 'error';
                            $json['message'] = trans('lang.money_not_add');
                            return $json;
                        }
                    } catch (Exception $e) {
                        $json['type'] = 'error';
                        $json['message'] = $e->getMessage();
                        return $json;
                    }
                } elseif ($paymentmode == "paypal") {
                    $invoice_id = DB::table('cource_user')->where('id', $request['id'])->pluck('invoice_id')->first();
                    $transaction_id = DB::table('invoices')->where('id', $invoice_id)->pluck('transaction_id')->first();

                    $response = $this->provider->RefundTransaction($transaction_id);
                    if ($response['ACK'] == 'Failure') {
                        $json['type'] = 'error';
                        $json['message'] = $response['L_LONGMESSAGE0'];
                        return $json;
                    } else {
                        $courseid = DB::table('cource_user')->where('id', $request['id'])->pluck('cource_id')->first();
                        $userid = DB::table('cource_user')->where('id', $request['id'])->pluck('user_id')->first();
                        $freelancer = User::find($userid);
                        DB::table('cource_user')->where('id', $request['id'])->delete();
                        DB::table('orders')->where('product_id', $courseid)->where('user_id', $userid)->delete();
                        $course = Cource::find($courseid);
                        $user = User::find(intval(Auth::user()->id));
                        // send message to student
                        $message = new Message();
                        $message->user()->associate($user);
                        $message->receiver_id = intval($userid);
                        $message->body = 'Your Request For the Course ' . $course->title . ' is Denied by the Instructor ' . Helper::getUserName(Auth::user()->id) . '. Your Payment has been refunded';
                        $message->status = 0;
                        $message->save();
                        //add mail code
                        if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                            $email_params = array();
                            $template_data = (object)array();
                            $template_data->content = Helper::getFreelancerCoursePaymentRefundEmailContent();
                            $template_data->subject = "Course Order Cancelled";
                            // $template_data = Helper::getFreelancerCoursePaymentRefundEmailContent();
                            $email_params['title'] = $course->title;
                            $email_params['course_link'] = url('course/' . $course->slug);
                            $email_params['amount'] = $course->price;
                            $email_params['freelancer_name'] = Helper::getUserName($userid);
                            $email_params['employer_profile'] = url('profile/' . $user->slug);
                            $email_params['employer_name'] = Helper::getUserName($user->id);
                            $freelancer_data = User::find(intval($userid));
                            Mail::to($freelancer_data->email)
                                ->send(
                                    new FreelancerEmailMailable(
                                        'freelancer_email_course_cancelled',
                                        $template_data,
                                        $email_params
                                    )
                                );
                        }

                        $json['type'] = 'success';
                        $json['message'] = "Sucessfully Refunded";
                        return $json;
                    }
                } else {
                    $courseid = DB::table('cource_user')->where('id', $request['id'])->pluck('cource_id')->first();
                    $userid = DB::table('cource_user')->where('id', $request['id'])->pluck('user_id')->first();
                    $freelancer = User::find($userid);
                    DB::table('cource_user')->where('id', $request['id'])->delete();
                    DB::table('orders')->where('product_id', $courseid)->where('user_id', $userid)->delete();
                    $course = Cource::find($courseid);
                    $user = User::find(intval(Auth::user()->id));
                    // send message to student
                    $message = new Message();
                    $message->user()->associate($user);
                    $message->receiver_id = intval($userid);
                    $message->body = 'Your Request For the Course ' . $course->title . ' is Denied by the Instructor ' . Helper::getUserName(Auth::user()->id) . '. Your Payment has been refunded';
                    $message->status = 0;
                    $message->save();
                    //add mail code
                    if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                        $email_params = array();
                        $template_data = (object)array();
                        $template_data->content = Helper::getFreelancerCoursePaymentRefundEmailContent();
                        $template_data->subject = "Course Order Cancelled";
                        // $template_data = Helper::getFreelancerCoursePaymentRefundEmailContent();
                        $email_params['title'] = $course->title;
                        $email_params['course_link'] = url('course/' . $course->slug);
                        $email_params['amount'] = $course->price;
                        $email_params['freelancer_name'] = Helper::getUserName($userid);
                        $email_params['employer_profile'] = url('profile/' . $user->slug);
                        $email_params['employer_name'] = Helper::getUserName($user->id);
                        $freelancer_data = User::find(intval($userid));
                        Mail::to($freelancer_data->email)
                            ->send(
                                new FreelancerEmailMailable(
                                    'freelancer_email_course_cancelled',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }

                    $json['type'] = 'success';
                    $json['message'] = "Sucessfully Refunded";
                    return $json;
                }
            }
        }
    }
    public function bacspayment()
    {
        $user_id = Auth::user() ? Auth::user()->id : '';
        $product_id = Session::has('product_id') ? session()->get('product_id') : '';
        $product_title = Session::has('product_title') ? session()->get('product_title') : '';
        $product_price = Session::has('product_price') ? session()->get('product_price') : 0;
        $id = session()->get('product_id');
        $type = Session::has('type') ? session()->get('type') : '';
        $invoice = new Invoice();
        $invoice->title = 'Bank Transfer';
        $invoice->price = $product_price;
        $invoice->payer_name = filter_var(Helper::getUserName(Auth::user()->id), FILTER_SANITIZE_STRING);
        $invoice->payer_email = filter_var(Auth::user()->email, FILTER_SANITIZE_EMAIL);
        $invoice->seller_email = 'test@email.com';
        $invoice->currency_code = '';
        $invoice->payer_status = '';
        $invoice->transaction_id = '';
        $invoice->invoice_id = '';
        $invoice->customer_id = filter_var(Auth::user()->id, FILTER_SANITIZE_STRING);
        $invoice->shipping_amount = 0;
        $invoice->handling_amount = 0;
        $invoice->insurance_amount = 0;
        $invoice->sales_tax = 0;
        $invoice->payment_mode = filter_var('bacs', FILTER_SANITIZE_STRING);
        $invoice->paypal_fee = '';
        $invoice->paid = 0;
        $product_type = $type;
        $invoice->type = $product_type;
        $invoice->save();
        $invoice_id = DB::getPdo()->lastInsertId();
        $freelancer = session()->get('course_seller');
        DB::table('orders')->insert(
            ['user_id' => $user_id, 'product_id' => $id, 'type' => 'course', 'cource_product_id' => $id, 'invoice_id' => $invoice_id, 'status' => 'pending', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
        );
        $course = Cource::find($id);
        $course->users()->attach(Auth::user()->id, ['type' => 'employer', 'status' => 'waiting', 'seller_id' => $freelancer, 'paid' => 'pending', 'invoice_id' => $invoice_id,]);
        $course->save();
        // send message to freelancer
        $message = new Message();
        $user = User::find(intval(Auth::user()->id));
        $message->user()->associate($user);
        $message->receiver_id = intval($freelancer);
        $message->body = Helper::getUserName(Auth::user()->id) . ' has requested to buy your course ' . $course->title . " thorugh offline bank payment";
        $message->status = 0;
        $message->save();
        // send mail
        if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
            $email_params = array();
            $template_data = (object)array();
            $template_data->content = Helper::getFreelancerNewCourseOrderEmailContent();
            $template_data->subject = "Course Order";
            $email_params['title'] = $course->title;
            $email_params['course_link'] = url('course/' . $course->slug);
            $email_params['amount'] = $course->price;
            $email_params['freelancer_name'] = Helper::getUserName($freelancer);
            $email_params['employer_profile'] = url('profile/' . $user->slug);
            $email_params['employer_name'] = Helper::getUserName($user->id);
            $email_params['payment_mode'] = "offline bank payment";
            $freelancer_data = User::find(intval($freelancer));

            Mail::to($freelancer_data->email)
                ->send(
                    new FreelancerEmailMailable(
                        'freelancer_email_new_course_order',
                        $template_data,
                        $email_params
                    )
                );
        }
        $json['type'] = 'success';
        $json['message'] = 'Your Order has been sent to the Instructor please pay offline for the course and use message system for communication';
        return $json;
    }
    public function sendMessage(Request $request)
    {

        $json = array();
        $course_title = DB::table('cources')->select('title')->where('id', $request['id'])->first();
        $msg = $request['message'] . "       ~" . $course_title->title;
        $students = DB::table('cource_user')->select('user_id')->where('cource_id', $request['id'])->where('status', 'bought')->get();
        foreach ($students as $student) {
            $message = new Message();
            $user = User::find(intval(Auth::user()->id));
            $message->user()->associate($user);
            $message->receiver_id = intval($student->user_id);
            $message->body = $msg;
            $message->status = 0;
            $message->save();
        }

        $json['type'] = 'success';
        $json['message'] = 'Message Sent';
        $json['url'] = '/freelancer/courses/posted';
        return $json;
    }
    public function sendMessagetoInstructor(Request $request)
    {

        $json = array();
        $course_title = DB::table('cources')->select('title')->where('id', $request['id'])->first();
        $course_seller = Helper::getCourceSeller($request['id']);
        $msg = $request['message'] . "       ~" . $course_title->title;

        $message = new Message();
        $user = User::find(intval(Auth::user()->id));
        $message->user()->associate($user);
        $message->receiver_id = intval($course_seller->user_id);
        $message->body = $msg;
        $message->status = 0;
        $message->save();


        $json['type'] = 'success';
        $json['message'] = 'Message Sent';
        $json['url'] = '/freelancer/courses/bought';
        return $json;
    }

    public function courseList($slug)
    {

        // $blogs = Blog::select('*')->where('status','published')->orderBy('id','DESC');
        $locations  = Location::all();
        $languages  = Language::all();
        $categories = Category::all();
        $delivery_time = DeliveryTime::all();
        $response_time = ResponseTime::all();
        $skills     = Skill::orderBy('title')->get();
        $course_id = array();
        $services = array();
        $type = "category";
        foreach ($skills as $key => $skill) {
            if ($skill->slug == $slug) {
                $type = 'skill';
            }
        }
        foreach ($categories as $key => $cat) {
            if ($cat->slug == $slug) {
                $type = 'category';
            }
        }
        foreach ($locations as $key => $loc) {
            if ($loc->slug == $slug) {
                $type = 'location';
            }
        }
        foreach ($delivery_time as $key => $time) {
            if ($time->slug == $slug) {
                $type = 'delivery-time';
            }
        }
        foreach ($response_time as $key => $time) {
            if ($time->slug == $slug) {
                $type = 'response-time';
            }
        }
        foreach ($languages as $key => $lang) {
            if ($lang->slug == $slug) {
                $type = 'language';
            }
        }
        if ($type == 'category') {
            $categor_obj = Category::where('slug', $slug)->first();
            if (!empty($categor_obj->id)) {
                $category = Category::find($categor_obj->id);

                if (!empty($category->courses)) {
                    $category_courses = $category->courses->pluck('id')->toArray();
                    foreach ($category_courses as $id) {
                        $course_id[] = $id;
                    }
                    if (
                        $categor_obj->title == 'E-Commerce' || $categor_obj->title == 'Cloud Computing' || $categor_obj->title == 'Data Science' ||
                        $categor_obj->title == 'Graphic Designing' || $categor_obj->title == 'Artificial Intelligence' || $categor_obj->title == 'Growth Hacking'
                    ) {
                        $skill_obj = Skill::where('title', $categor_obj->title)->get();
                        $skill = Skill::find($skill_obj[0]->id);
                        if (!empty($skill->courses)) {
                            $skill_courses = $skill->courses->pluck('id')->toArray();
                            foreach ($skill_courses as $id) {
                                $course_id[] = $id;
                            }
                        }
                    }
                }
                $services = Cource::where('status', 'published')->whereIn('id', $course_id)->orderBy('id', 'DESC')->paginate(10)->setPath('');
            }
        }
        if ($type == 'skill') {
            $skill_obj = Skill::where('slug', $slug)->first();
            if (!empty($skill_obj->id)) {
                $skill = Skill::find($skill_obj->id);
                if (!empty($skill->courses)) {
                    $skill_courses = $skill->courses->pluck('id')->toArray();
                    foreach ($skill_courses as $id) {
                        $course_id[] = $id;
                    }
                }

                $services = Cource::where('status', 'published')->whereIn('id', $course_id)->orderBy('id', 'DESC')->paginate(10)->setPath('');
            }
        }
        if ($type == 'location') {
            $location = Location::select('id')->where('slug', $slug)->get()->pluck('id')->toArray();
            $services = Cource::where('status', 'published')->whereIn('location_id', $location)->paginate(10)->setPath('');
        }
        if ($type == 'language') {
            $language = Language::where('slug', $slug)->first();
            $lang = Language::find($language['id']);
            if (!empty($lang->courses)) {
                $lang_courses = $lang->courses->pluck('id')->toArray();
                foreach ($lang_courses as $id) {
                    $course_id[] = $id;
                }
            }
            $services = Cource::where('status', 'published')->whereIn('id', $course_id)->orderBy('id', 'DESC')->paginate(10)->setPath('');
        }
        if ($type == 'delivery-time') {
            $deliverytime = DeliveryTime::select('id')->where('slug', $slug)->get()->pluck('id')->toArray();
            $services = Cource::where('status', 'published')->whereIn('delivery_time_id', $deliverytime)->paginate(10)->setPath('');
        }
        if ($type == 'response-time') {
            $responsetime = ResponseTime::select('id')->where('slug', $slug)->get()->pluck('id')->toArray();
            $services = Cource::where('status', 'published')->whereIn('response_time_id', $responsetime)->paginate(10)->setPath('');
        }
        $type = "instructors";
        if (file_exists(resource_path('views/extend/front-end/cources/courseList.blade.php'))) {
            return view(
                'extend.front-end.cources.courseList',
                compact(
                    'locations',
                    'languages',
                    'categories',
                    'skills',
                    'type',
                    'delivery_time',
                    'response_time',
                    'services'
                )
            );
        } else {
            return view(
                'front-end.cources.courseList',
                compact(
                    'locations',
                    'languages',
                    'categories',
                    'skills',
                    'type',
                    'delivery_time',
                    'response_time',
                    'services'
                )
            );
        }
    }
    public function coursesListing()
    {
        $locations  = Location::all();
        $languages  = Language::all();
        $categories = Category::orderBy('title')->get();
        $skills     = Skill::orderBy('title')->get();
        $delivery_time = DeliveryTime::all();
        $response_time = ResponseTime::all();
        $services = Cource::where('status', 'published')->orderByRaw("is_featured DESC, updated_at DESC")->paginate(10)->setPath('');

        // Check if the user is authenticated
        if (Auth::user()) {
            // Adding boughtcourse and waiting_status attributes to each service
            $services->transform(function ($service, $key) {
                $service->boughtcourse = DB::table('cource_user')
                    ->where('cource_id', $service->id)
                    ->where('user_id', Auth::user()->id)
                    ->where('status', 'bought')
                    ->exists();

                $service->waiting_status = DB::table('cource_user')
                    ->where('cource_id', $service->id)
                    ->where('user_id', Auth::user()->id)
                    ->where('status', 'waiting')
                    ->exists();

                return $service;
            });
        }
        $type = "instructors";
        if (file_exists(resource_path('views/extend/front-end/cources/courseList.blade.php'))) {
            return view(
                'extend.front-end.cources.courseList',
                compact(
                    'locations',
                    'languages',
                    'categories',
                    'skills',
                    'type',
                    'delivery_time',
                    'response_time',
                    'services'
                )
            );
        } else {
            return view(
                'front-end.cources.courseList',
                compact(
                    'locations',
                    'languages',
                    'categories',
                    'skills',
                    'type',
                    'delivery_time',
                    'response_time',
                    'services'
                )
            );
        }
    }
}
