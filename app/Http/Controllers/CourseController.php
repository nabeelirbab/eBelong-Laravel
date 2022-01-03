<?php

namespace App\Http\Controllers;

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
use Auth;
use App\Package;
use Carbon\Carbon;
use App\User;
use DB;
use App\SiteManagement;
use App\Review;
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Mail\AdminEmailMailable;
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
                'cource_price'    => 'required',
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
                    if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                        $cource = $this->cource::where('id', $cource_post['new_course'])->first();
                        $email_params = array();
                        $email_params['cource_title'] = $cource->title;
                        $email_params['posted_cource_link'] = url('/instructor/' . $cource->slug);
                        $email_params['name'] = Helper::getUserName(Auth::user()->id);
                        $email_params['link'] = url('profile/' . $user->slug);
                        $template_data = Helper::getAdminServicePostedEmailContent();
                        Mail::to(getenv('MAIL_FROM_ADDRESS'))
                            ->send(
                                new AdminEmailMailable(
                                    'admin_email_new_course_posted',
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
                if (trim(env('MAIL_USERNAME')) != "" && trim(env('MAIL_PASSWORD')) != "") {
                    $cource = $this->cource::where('id', $cource_post['new_cource'])->first();
                    $email_params = array();
                    $email_params['cource_title'] = $cource->title;
                    $email_params['posted_cource_link'] = url('/instructor/' . $cource->slug);
                    $email_params['name'] = Helper::getUserName(Auth::user()->id);
                    $email_params['link'] = url('profile/' . $user->slug);
                    $template_data = Helper::getAdminServicePostedEmailContent();
                    Mail::to(getenv('MAIL_FROM_ADDRESS'))
                        ->send(
                            new AdminEmailMailable(
                                'admin_email_new_course_posted',
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
            $boughtcourse = DB::table('cource_user')->where('cource_id', $selected_cource->id)->where(function($query) {$query->where('user_id',Auth::user()->id)->orwhere('status','bought');})->get();
            }
            $boughtcourse = !empty($boughtcourse) ? true : false ;
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
                            'boughtcourse'
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
                            'boughtcourse'
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
                'cource_price'    => 'required',
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
}
