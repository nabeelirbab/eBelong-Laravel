<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;
use App\Category;
use App\Location;
use App\Helper;
use App\ResponseTime;
use App\DeliveryTime;
use App\Cource;
use App\Item;
use Auth;
use Illuminate\Support\Facades\Input;
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

class CourceController extends Controller
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
            $reviews = !empty($seller) ? Helper::getCourceReviews($seller->id, $cource->id) : '';
            $auth_profile = Auth::user() ? auth()->user()->profile : '';
            if (!empty($reviews)) {
                $rating  = $reviews->sum('avg_rating') != 0 ? round($reviews->sum('avg_rating') / $reviews->count()) : 0;
            } else {
                $rating = 0;
            }

            $total_orders = Helper::getCourceCount($cource->id);
            $attachments = !empty($seller) ? Helper::getUnserializeData($cource->attachments) : '';
            // $service_reviews = DB::table('reviews')->where('job_id', $service->id)->get();
            $saved_cources = !empty(auth()->user()->profile->saved_cources) ? unserialize(auth()->user()->profile->saved_cources) : array();
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
                            'show_breadcrumbs',
                            'mode'
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
                            'saved_cources',
                            'show_breadcrumbs',
                            'mode'
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
}