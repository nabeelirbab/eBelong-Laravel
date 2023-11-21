<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiteManagement;
use App\Helper;
use App\Page;
use View;
use App\Category;
use App\Skill;
use App\Location;
use App\Cource;
use App\Language;
use App\Job;
use App\User;
use App\Review;
use Illuminate\Support\Facades\Schema;
use DB;

class HomeController extends Controller
{

    public function theme5()
    {
        $categories = Category::select('id', 'title', 'slug', 'image')->get();
        $all_skills = Skill::select('id', 'title', 'slug', 'logo', 'is_featured')->get();
        $ai_skills = Skill::where('category_id', 22)->select('id', 'title', 'slug', 'logo', 'is_featured')->get();
        $services = DB::table('cources')
            ->join('cource_user', 'cources.id', '=', 'cource_user.cource_id')
            ->join('users', 'users.id', '=', 'cource_user.user_id')
            ->where('cources.status', 'published')
            ->where('cources.is_featured', 'true')
            ->where('cource_user.type', 'seller')
            ->orderByRaw("cources.is_featured DESC, cources.updated_at DESC")
            ->select('cources.id', 'cources.title', 'cources.slug', 'cources.attachments', 'cources.status', 'cources.is_featured', 'cources.price', 'cources.user_type', 'users.id as seller_id', 'users.is_certified', 'users.is_instructor')
            ->get()
            ->toArray();

        if (!empty($services)) {
            foreach ($services as $key => $service) {
                $instructor = DB::table('cource_user')->where('seller_id', $service->seller_id)->where('status', 'posted')->count();
                if (!empty($instructor) && $instructor > 0) {
                    $service->is_instructor = 1;
                } else {
                    $service->is_instructor = 0;
                }

                $services[$key]->sellerName =  Helper::getUserName($service->seller_id);
                $attachments = Helper::getUnserializeData($service->attachments);
                if (!empty($attachments)) {
                    foreach ($attachments as $attachment) {
                        $services[$key]->imagePath = asset(Helper::getImageWithSize('uploads/courses/' . $service->seller_id, $attachment, 'medium'));
                    }
                } else {
                    $services[$key]->imagePath  = asset('uploads/settings/general/imgae-not-availabe.png');
                }
                // dd($service);

            }
        }
        // dd($services);

        $i = 0;
        // foreach($categories as $cat){
        // 	$categorycount = DB::table('catables')
        // 		->select('catables.id as catableid')
        // 		->join('jobs', 'jobs.id', '=', 'catables.catable_id')
        // 		->where(array('category_id'=>$cat->id,'catable_type'=>"App\Job"))
        // 		->where('jobs.status','posted')
        // 		->where('jobs.expiry_date','>',date('Y-m-d'))				
        // 		->get();
        // 	if(count($categorycount) == 0){ 
        // 		unset($categories[$i]);
        // 	}
        // 	$i++;
        // }

        $jobs = Job::latest()->where('status', 'posted')->get()->all();
        if (!empty($jobs)) {
            foreach ($jobs as $key => $job) {
                $location = Location::where('id', '=', $job['location_id'])->first();
                $jobs[$key]['location_name'] = $location['title'];
                $employeer = User::where('id', '=', $job['user_id'])->first();
                $jobs[$key]['employeers_name'] = $employeer['first_name'] . " " . $employeer['last_name'];
                $jobs[$key]['employee_slug'] = $employeer['slug'];
            }
        }
        // $search =  User::getSearchResult(
        //             'freelancer',
        //             [],
        //             [],
        //             [],
        //             [],
        //             [],
        //             [],
        //             [],
        //             []
        //         );
        // $freelancers = count($search['users']) > 0 ? $search['users'] : '';

        /*$freelancers = Review::join('profiles', 'profiles.user_id', '=', 'receiver_id')->join('users', 'users.id', '=', 'receiver_id')->selectRaw('AVG(avg_rating) average, receiver_id as id,users.slug,users.first_name,users.last_name,profiles.avater,profiles.tagline,profiles.hourly_rate,users.location_id as userlocation')->groupBy( 'receiver_id' )
	   >whereNotNull('users.location_id')
	   ->where('profiles.hourly_rate','<>','')
	   ->orderBy('average', 'DESC')->get()->toArray(); */

        $freelancers = DB::table('users')
            ->join('profiles', 'profiles.user_id', '=', 'users.id')
            ->selectRaw('users.id as id,users.slug, users.first_name, users.is_certified, users.last_name, profiles.avater, profiles.tagline, profiles.hourly_rate, users.location_id as userlocation,users.is_agency as has_agency,users.agency_id')
            ->where('users.is_featured', 1)
            ->orderBy('users.id', 'DESC')->get()->toArray();

        if (!empty($freelancers)) {
            foreach ($freelancers as $key => $freelancer) {
                // $skills = Skill::join('skill_user', 'skill_user.skill_id', '=', 'id')->selectRaw('skills.title,skills.slug')->get()->toArray();
                $instructor = DB::table('cource_user')->where('seller_id', $freelancer->id)->where('status', 'posted')->count();
                if (!empty($instructor) && $instructor > 0) {
                    $freelancer->is_instructor = 1;
                } else {
                    $freelancer->is_instructor = 0;
                }

                if ($freelancer->has_agency == 0) {

                    $agency_id = DB::table('agency_associated_users')->where('user_id', $freelancer->id)->first();
                    // dd($agency_id);
                    if (!empty($agency_id)) {
                        $freelancer->has_agency = 1;
                        $freelancer->agency_id = $agency_id->agency_id;
                        $freelancer->agency_name = DB::table('agency_user')->where('id', $agency_id->agency_id)->pluck('agency_name')->first();
                        $freelancer->agency_avatar = DB::table('agency_user')->where('id', $agency_id->agency_id)->pluck('agency_logo')->first();
                        $freelancer->agency_slug = DB::table('agency_user')->where('id', $agency_id->agency_id)->pluck('slug')->first();
                        // dd($freelancer->agency_avatar);
                        // if(empty($freelancer->agency_avatar)){
                        //     $freelancer->is_null_logo = true;
                        // }
                    } else {
                        $freelancer->agency_avatar = null;
                        $freelancer->agency_name = null;
                        $freelancer->agency_slug = null;
                        // $freelancer->is_null_logo = null;
                    }
                } else {
                    $freelancer->agency_name = DB::table('agency_user')->where('id', $freelancer->agency_id)->pluck('agency_name')->first();
                    $freelancer->agency_avatar = DB::table('agency_user')->where('id', $freelancer->agency_id)->pluck('agency_logo')->first();
                    $freelancer->agency_slug = DB::table('agency_user')->where('id', $freelancer->agency_id)->pluck('slug')->first();

                    // if(empty($freelancer->agency_avatar)){
                    //     $freelancer->is_null_logo = true;
                    // }
                    // else{
                    //     $freelancer->is_null_logo = false;
                    // }
                }
                // dd($freelancers);
                $skills = Skill::getFreelancerSkill($freelancer->id);
                $feedbacks = \App\Review::select('feedback')->where('receiver_id', $freelancer->id)->count();
                $avg_rating = \App\Review::where('receiver_id', $freelancer->id)->sum('avg_rating');
                $rating  = $avg_rating != 0 ? round($avg_rating / \App\Review::count()) : 0;
                $reviews = \App\Review::where('receiver_id', $freelancer->id)->get();
                $freelancers[$key]->rating_width  = $reviews->sum('avg_rating') != 0 ? (($reviews->sum('avg_rating') / $feedbacks) / 5) * 100 : 0;
                $freelancers[$key]->average_rating_count = round(!empty($feedbacks) ? $reviews->sum('avg_rating') / $feedbacks : 0);
                $freelancers[$key]->imagePath = asset(!empty($freelancer->avater) ? Helper::getUserImageWithSize('uploads/users/' . $freelancer->id, $freelancer->avater, 'listing') : '/images/user.jpg');
                if (!empty($skills)) {
                    foreach ($skills as $key1 => $skill) {
                        $skill_name = Skill::where('id', '=', $skill)->first();
                        $skills_user[] = array(
                            'title' => $skill_name['title'],
                            'slug'  => $skill_name['slug']
                        );
                    }
                    $freelancers[$key]->skills = $skills_user;
                    $skills = [];
                } else {

                    $freelancers[$key]->skills = [];
                }

                if (!empty($freelancer->userlocation)) {
                    $location = Location::where('id', '=', (int) $freelancer->userlocation)->first();
                    if (!empty($location))
                        $freelancers[$key]->location_name = $location['title'];
                    else
                        $freelancers[$key]->location_name = "";
                } else {
                    $freelancers[$key]->location_name = "";
                }
            }
        }

        return View::make(
            'homeV5',
            compact(
                'categories',
                'jobs',
                'freelancers',
                'all_skills',
                'services',
                'ai_skills'
            )
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Schema::hasTable('site_managements')) {
            $homepage = SiteManagement::getMetaValue('homepage');
            if (!empty($homepage['home'])) {
                $sections = Helper::getPageSections();
                $selected_page = Page::find($homepage['home']);
                $page_data = $selected_page->toArray();
                $page = array();
                $home = true;
                $page['id'] = $page_data['id'];
                $page['title'] = $page_data['title'];
                $page['slug'] = $page_data['slug'];
                $page['section_list'] = !empty($page_data['sections']) ? Helper::getUnserializeData($page_data['sections']) : array();
                $description = $page_data['body'];
                $page_meta = SiteManagement::where('meta_key', 'seo-desc-' . $homepage['home'])->select('meta_value')->pluck('meta_value')->first();
                $page_banner = SiteManagement::where('meta_key', 'page-banner-' . $homepage['home'])->select('meta_value')->pluck('meta_value')->first();
                $show_banner = SiteManagement::where('meta_key', 'show-banner-' . $homepage['home'])->select('meta_value')->pluck('meta_value')->first();
                $breadcrumbs_settings = SiteManagement::getMetaValue('show_breadcrumb');
                $show_breadcrumbs = !empty($breadcrumbs_settings) ? $breadcrumbs_settings : 'true';
                $show_banner_image = false;
                if ($show_banner == false) {
                    $show_banner_image = false;
                } else {
                    $show_banner_image = true;
                }
                $banner = !empty($page_banner) ? Helper::getBannerImage('uploads/pages/' . $page_banner) : 'images/bannerimg/img-02.jpg';
                $meta_desc = !empty($page_meta) ? $page_meta : '';
                $type = Helper::getAccessType() == 'services' ? 'service' : Helper::getAccessType();
                $slider_section = '';
                $slider_style = '';
                $slider_order = '';
                foreach ($selected_page->meta->toArray() as $key => $meta) {
                    preg_match_all('!\d+!', $meta['meta_key'], $matches);
                    $meta_key_modify = preg_replace('/\d/', '', $meta['meta_key']);
                    if ($meta_key_modify == 'sliders') {
                        $slider_section = Helper::getUnserializeData($meta['meta_value']);
                        $slider_style = !empty($slider_section['style']) ? $slider_section['style'] : '';
                        $slider_order = !empty($slider_section['parentIndex']) ? $slider_section['parentIndex'] : '';
                    }
                }
                $categories = Category::latest()->get()->take(8);
                $skills = Skill::latest()->get()->take(8);
                $locations = Location::latest()->get()->take(8);
                $languages = Language::latest()->get()->take(8);
                if (file_exists(resource_path('views/extend/front-end/pages/show.blade.php'))) {

                    return View::make(
                        'extend.front-end.pages.show',
                        compact(
                            'page',
                            'meta_desc',
                            'banner',
                            'show_banner',
                            'show_banner_image',
                            'show_breadcrumbs',
                            'selected_page',
                            'sections',
                            'type',
                            'slider_style',
                            'slider_section',
                            'description',
                            'slider_order',
                            'home',
                            'categories',
                            'skills',
                            'locations',
                            'languages'
                        )
                    );
                } else {

                    return View::make(
                        'front-end.pages.show',
                        compact(
                            'page',
                            'meta_desc',
                            'banner',
                            'show_banner',
                            'show_banner_image',
                            'show_breadcrumbs',
                            'selected_page',
                            'sections',
                            'type',
                            'slider_style',
                            'slider_section',
                            'description',
                            'slider_order',
                            'home',
                            'categories',
                            'skills',
                            'locations',
                            'languages'
                        )
                    );
                }
            } else {
                if (file_exists(resource_path('views/extend/front-end/index.blade.php'))) {
                    return view('extend.front-end.index');
                } else {
                    return view('front-end.index');
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
        //
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
}
