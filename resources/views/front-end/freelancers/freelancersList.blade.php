@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ?
'extend.front-end.master':
'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
<link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
@section('title'){{ $f_list_meta_title }} @stop
@section('description', $f_list_meta_desc)
@section('content')
@php

$show_f_banner = 'true'
@endphp
@if ($show_f_banner == 'true')
@php $breadcrumbs = Breadcrumbs::generate('freelancers'); @endphp
<style>
    .d-flex.agency-box-logo-name img {
        border-radius: 100%;
    }
    button.up-btn-link.text-left {
         background: none;
     }

</style>
<div class="wt-haslayout wt-innerbannerholder" style="background-image:url({{{ asset(Helper::getBannerImage($f_inner_banner, 'uploads/settings/general')) }}})">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-xs-12 col-sm-12 col-md-12 push-md-12 col-lg-12 push-lg-12">
                <div class="wt-innerbannercontent">
                    <div class="wt-title">
                        <h1>{{{  $heading }}}</h1>
                    </div>
                    @if (!empty($show_breadcrumbs) && $show_breadcrumbs === 'true')
                    @if (count($breadcrumbs))
                    <ol class="wt-breadcrumb">
                        @foreach ($breadcrumbs as $breadcrumb)
                        @if ($breadcrumb->url && !$loop->last)
                        <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
                        @else
                        <li class="active">{{{ $breadcrumb->title }}}</li>
                        @endif
                        @endforeach
                    </ol>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif
{{-- @if (!empty($categories) && $categories->count() > 0)
        <div class="wt-categoriesslider-holder wt-haslayout {{$show_f_banner == 'false' ? 'la-categorty-top-mt' : ''}}">
<div class="wt-title">
    <h2>{{ trans('lang.browse_job_cats') }}</h2>
</div>
<div id="wt-categoriesslider" class="wt-categoriesslider owl-carousel">
    @foreach ($categories as $cat)
    @php
    $category = \App\Category::find($cat->id);
    $active = (!empty($_GET['category']) && in_array($cat->id, $_GET['category'])) ? 'active-category' : '';
    $active_wrapper = ( !empty($_GET['category']) && in_array($cat->id, $_GET['category'])) ? 'active-category-wrapper' : '';
    @endphp
    <div class="wt-categoryslidercontent item {{$active_wrapper}}">
        <figure><img src="{{{ asset(Helper::getCategoryImage($cat->image)) }}}" alt="{{{ $cat->title }}}"></figure>
        <div class="wt-cattitle">
            <h3><a href="{{{url('search-results?type=job&category%5B%5D='.$cat->slug)}}}" class="{{$active}}">{{{ $cat->title }}}</a></h3>
            <span>Items: {{{$category->jobs->count()}}}</span>
        </div>
    </div>
    @endforeach
</div>
</div>
@endif--}}
<div class="wt-haslayout wt-main-section" id="user_profile">
    <div class="search-form">
        <search-form-home :placeholder="'{{ trans('lang.looking_for') }}'" :freelancer_placeholder="'{{ trans('lang.search_filter_list.freelancer') }}'" :employer_placeholder="'{{ trans('lang.search_filter_list.employers') }}'" :job_placeholder="'{{ trans('lang.search_filter_list.jobs') }}'" :service_placeholder="'{{ trans('lang.search_filter_list.services') }}'" :no_record_message="'{{ trans('lang.no_record') }}'">
        </search-form-home>
    </div>
    @if (Session::has('payment_message'))
    @php $response = Session::get('payment_message') @endphp
    <div class="flash_msg">
        <flash_messages :message_class="'{{{$response['code']}}}'" :time='5' :message="'{{{ $response['message'] }}}'" v-cloak></flash_messages>
    </div>
    @endif
    <div class="wt-haslayout">
        <div class="container">
            <div class="row">
                <div id="wt-twocolumns" class="wt-twocolumns wt-haslayout">
                    <div class="filter_icon btn btn-success"><i class="fa fa-filter"></i>Filter</div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 col-xl-4 filter-page float-left">
                        @if (file_exists(resource_path('views/extend/front-end/freelancers/filters.blade.php')))
                        @include('extend.front-end.freelancers.filters')
                        @else
                        @include('front-end.freelancers.filters')
                        @endif
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 col-xl-8 float-left">
                        <div class="wt-userlistingholder wt-userlisting wt-haslayout" id="list-layout">
                            <div class="row">
                                <div class="wt-userlistingtitle">
                                    @if (!empty($users))
                                    <span>{{ trans('lang.01') }} {{$users->count()}} of {{\App\User::role('freelancer')->count()}} results @if (!empty($keyword)) for <em>"{{{$keyword}}}"</em> @endif</span>
                                    @endif
                                </div>
                                @if (!empty($users  && $users->count()>0))
                                @foreach ($users as $key => $freelancer)
                                @php
                                $user_image = !empty($freelancer->profile['avater']) ?
                                '/uploads/users/'.$freelancer->id.'/'.$freelancer->profile['avater'] :
                                '';
                                $flag = !empty($freelancer->location->flag) ? Helper::getLocationFlag($freelancer->location->flag) :
                                '/images/img-01.png';
                                $feedbacks = \App\Review::select('feedback')->where('receiver_id', $freelancer->id)->count();
                                $avg_rating = App\Review::where('receiver_id', $freelancer->id)->sum('avg_rating');
                                $rating = $avg_rating != 0 ? round($avg_rating/\App\Review::count()) : 0;
                                $reviews = \App\Review::where('receiver_id', $freelancer->id)->get();
                                $stars = $reviews->sum('avg_rating') != 0 ? (($reviews->sum('avg_rating')/$feedbacks)/5)*100 : 0;
                                $average_rating_count = !empty($feedbacks) ? $reviews->sum('avg_rating')/$feedbacks : 0;
                                $verified_user = \App\User::select('user_verified')->where('id', $freelancer->id)->pluck('user_verified')->first();
                                $save_freelancer = !empty(auth()->user()->profile->saved_freelancer) ? unserialize(auth()->user()->profile->saved_freelancer) : array();
                                $badge = Helper::getUserBadge($freelancer->id);
                                if (!empty($enable_package) && $enable_package === 'true') {
                                $feature_class = (!empty($badge) && $freelancer->expiry_date >= $current_date) ? 'wt-featured' : 'wt-exp';
                                $badge_color = !empty($badge) ? $badge->color : '';
                                $badge_img = !empty($badge) ? $badge->image : '';
                                } else {
                                $feature_class = 'wt-exp';
                                $badge_color = '';
                                $badge_img = '';
                                }
                                @endphp
                                <div class="col-lg-12 col-md-12 col-sm-12 forhidingpadingleft">
                                    <div class="freelancerspage wt-userlistinghold {{ $feature_class }}">
                                        @if(!empty($enable_package) && $enable_package === 'true')
                                        @if ($freelancer->expiry_date >= $current_date && !empty($freelancer->badge_id))
                                        <span class="wt-featuredtag" style="border-top: 40px solid {{ $badge_color }};">
                                            @if (!empty($badge_img))
                                            <img src="{{{ asset(Helper::getBadgeImage($badge_img)) }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style">
                                            @else
                                            <i class="wt-expired fas fa-bold"></i>
                                            @endif
                                        </span>
                                        @endif
                                        @endif
                                        <div class="row find-talent-freelancers" onclick="location.href='{{{url('profile/'.$freelancer->slug)}}}';" style="cursor: pointer;" >
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="find-talent">
                                                    <div class="row samemargin">
                                                        <div class="col-lg-2 col-md-12 col-sm-12 removepaddingleft">
                                                            <figure class="wt-userlistingimg">
                                                                <img src="{{{ asset(Helper::getUserImageWithSize('uploads/users/'.$freelancer->id, $freelancer->profile['avater'], 'listing')) }}}" alt="{{ trans('lang.img') }}">
                                                            </figure>
                                                        </div>
                                                        <div class="col-lg-10 col-md-12 col-sm-12 removepadding">
                                                            <div class="find-talent-info">
                                                                <div class="wt-title">
                                                                    <a href="{{{ url('profile/'.$freelancer->slug) }}}">
                                                                        @if ($verified_user == 1)
                                                                        <i class="fa fa-check-circle"></i>
                                                                        @endif
                                                                        <!-- {{{ Helper::getUserName($freelancer->first_name) }}} -->
                                                                        {{{$freelancer->first_name}}}
                                                                    </a>
                                                                    <!-- @if (!empty($freelancer->profile->tagline))
                                                                                    <h2><a href="{{{ url('profile/'.$freelancer->slug) }}}">{{{ $freelancer->profile->tagline }}}</a></h2>
                                                                                @endif -->
                                                                </div>
                                                                <div class="wt-talent-skill">
                                                                    @if (!empty($freelancer->skills))
                                                                    @foreach($freelancer->skills as $i => $skill)
                                                                    @if($i==0)
                                                                    <!-- <img style="width: 16px" src="/uploads/logos/{{{ $skill->logo }}}" alt=""> -->
                                                                    <a href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="wt-talent-location">
                                                                    @if (!empty($freelancer->location))
                                                                    <span class="wt-locationarea">
                                                                        <img src="{{{asset(Helper::getLocationFlag($freelancer->location->flag))}}}" alt="{{{ trans('lang.location') }}}">
                                                                        {{{ !empty($freelancer->location->title) ? $freelancer->location->title : '' }}}
                                                                    </span>
                                                                    <!-- <span>
                                                                                        <i class="fas fa-map-marker-alt"></i> 
                                                                                        {{{ !empty($freelancer->location->title) ? $freelancer->location->title : '' }}}
                                                                                    </span> -->
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 samemargin ratingstarfordesktop">
                                                            <span class="wt-starcontent">
                                                            @if($average_rating_count == 0)
                                                                Yet to be rated!
                                                            @else
                                                            {{{ round($average_rating_count,2) }}}
                                                            @endif
                                                                
                                                            </span>
                                                            <span class="wt-stars">
                                                                <span style="width: {{ $stars }}%;">
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 samemargin">
                                                            @if (!empty($freelancer->skills))
                                                            <div class="wt-tag wt-widgettag">
                                                                <?php $count = 0; ?>
                                                                @foreach($freelancer->skills as $skill)
                                                                    <?php if($count == 4) break; ?>
                                                                        <a href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                                    <?php $count++; ?>
                                                                @endforeach

                                                                @if($freelancer->skills->count() > 3)
                                                                    <a class="wt-showall" href="{{{url('profile/'.$freelancer->slug)}}}">Show All</a>
                                                                @endif
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @php $instructor = DB::table('cource_user')->where('seller_id',$freelancer->id)->where('status','posted')->count();
                                                    if(!empty($instructor) && $instructor > 0){
                                                        $freelancer->is_instructor = 1;
                                                    }
                                                    else{
                                                        $freelancer->is_instructor = 0;
                                                    }@endphp
                                                    @if($freelancer->is_instructor == 1)
                                                    <a href="{{{ url('profile/'.$freelancer->slug) }}}" class="instructor-badge">
                                                        <img class="fix-blury-image-issue" src="/images/instructor/instructor_logo.png" />
                                                    </a>
                                                    @endif
                                                    @if($freelancer->is_certified == 1)
                                                    <a href="{{{ url('profile/'.$freelancer->slug) }}}" class="certified-badge">
                                                        <img src="/images/certified/Certified_Icon.svg" />
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-12 col-sm-12 removepaddingright samemargin">
                                                        <div class="wt-description">
                                                            @if (!empty($freelancer->profile->description))
                                                            <p>{{{ str_limit($freelancer->profile->description, 150) }}}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12 col-sm-12">
                                                        <div>
                                                            @if (!empty($freelancer->profile['hourly_rate']))
                                                            <span class="wt-hourlyrate">
                                                                <span>
                                                                    {{ (!empty($symbol['symbol'])) ? $symbol['symbol'] : '$' }}{{{ $freelancer->profile['hourly_rate'] }}} {{ trans('lang.per_hour') }}
                                                                </span>
                                                            </span>
                                                            @else
                                                            <span class="wt-hourlyrate">
                                                                <span>
                                                                    $0 / hr
                                                                </span>
                                                            </span>
                                                            @endif
                                                            <span class="ratingstarformobile">
                                                                <span class="wt-starcontent">
                                                                @if($average_rating_count == 0)
                                                                    Yet to be rated!
                                                                @else
                                                                {{{ round($average_rating_count,2) }}}
                                                                @endif
                                                                </span>
                                                                <span class="wt-stars">
                                                                    <span style="width: {{ $stars }}%;">
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($agency_data = \App\Helper::getUserAgency($freelancer->id) != null ? $agency_data = \App\Helper::getUserAgency($freelancer->id) : $agency_data = null)
                                                @foreach($agency_data as $data)
                                                    <div class="col-lg-12 col-md-12 col-sm-12" style="margin: 10px;">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-6" >
                                                                <div class="d-flex agency-box-logo-name">
                                                                    @if(isset($data['agency_logo']))
                                                                        <img src="{{{ url( 'uploads/agency_logos/'. $data['id']. '/' .$data['agency_logo']) }}}" alt="eBelong" class="up-avatar up-avatar-company flex-shrink-0 up-avatar-30" style="width: 50px;height: 50px;margin-right: 10px;">
                                                                    @else
                                                                        <img src="https://ebelongmaster-1517a.kxcdn.com/uploads/settings/general/imgae-not-availabe.png" alt="eBelong" class="up-avatar up-avatar-company flex-shrink-0 up-avatar-30" style="width: 50px;height: 50px;margin-right: 10px;">
                                                                    @endif
                                                                    <div class="ml-10 agency-box-name">
                                                                        <div>Associated with</div>
                                                                        <a href="{{{ url('/agency/'.$data['slug']) }}}" target="_blank" class="up-btn-link text-left">
                                                                            {{{ $data['agency_name'] }}}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
{{--                                                            <div class="col-md-4 col-sm-6">--}}
{{--                                                                <div class="ml-10 agency-box-stats">--}}
{{--                                                                    <p class="mb-0"><strong>$400k+</strong></p>--}}
{{--                                                                    <p class="mb-0">earned</p>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <!-- ======================== Old script ============================== -->
                                        <!-- <figure class="wt-userlistingimg">
                                                        <img src="{{{ asset(Helper::getImageWithSize('uploads/users/'.$freelancer->id, $freelancer->profile['avater'], 'listing')) }}}" alt="{{ trans('lang.img') }}">
                                                    </figure>
                                                    <div class="wt-userlistingcontent">
                                                        <div class="wt-contenthead">
                                                            <div class="wt-title">
                                                                @if($freelancer->is_certified == 1)
                                                                    <a href="{{{ url('profile/'.$freelancer->slug) }}}">
                                                                        @if ($verified_user == 1)
                                                                            <i class="fa fa-check-circle"></i>
                                                                        @endif
                                                                        {{{ Helper::getUserName($freelancer->id) }}} <img style="max-width: 45px;" src="/images/certified/Certified_Icon.png"/>
                                                                    </a>
                                                                @else 
                                                                    <a href="{{{ url('profile/'.$freelancer->slug) }}}">
                                                                        @if ($verified_user == 1)
                                                                            <i class="fa fa-check-circle"></i>
                                                                        @endif
                                                                        {{{ Helper::getUserName($freelancer->id) }}}
                                                                    </a>
                                                                @endif
                                                                @if (!empty($freelancer->profile->tagline))
                                                                    <h2><a href="{{{ url('profile/'.$freelancer->slug) }}}">{{{ $freelancer->profile->tagline }}}</a></h2>
                                                                @endif
                                                            </div>

                                                            <ul class="wt-userlisting-breadcrumb">
                                                            @if (!empty($freelancer->location))
                                                                    <li><span><i class="fas fa-map-marker-alt"></i> {{{ !empty($freelancer->location->title) ? $freelancer->location->title : '' }}}</span></li>
                                                                @endif
                                                                @if (!empty($freelancer->skills))
                                                                @foreach($freelancer->skills as $i =>  $skill)
                                                                @if($i==0)
                                                                <img style="width: 16px" src="/uploads/logos/{{{ $skill->logo }}}" alt="">
                                                                <a style="color: #2B2B2B" href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                                
                                                                @endif
                                                            @endforeach
                                                                    comment area start <li><span><i class="fas fa-th"></i>
                                                                        React Developer
                                                                        {{ (!empty($symbol['symbol'])) ? $symbol['symbol'] : '$' }}{{{ $freelancer->profile['hourly_rate'] }}} {{ trans('lang.per_hour') }}</span>
                                                                    </li> comment area end
                                                                @endif
                                                                @if (!empty($freelancer->skills))
                                                                <div class="wt-tag wt-widgettag">
                                                            comment area start @foreach($freelancer->skills as $skill)
                                                                <a href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                                <img src="/uploads/logos/{{{ $skill->logo }}}" alt="">
                                                            @endforeach comment area end
                                                                </div>
                                                                @endif
                                                                @if (in_array($freelancer->id, $save_freelancer))
                                                                    comment area start <li class="wt-btndisbaled">
                                                                        <a href="javascrip:void(0);" class="wt-clicksave wt-clicksave">
                                                                            <i class="fa fa-heart"></i>
                                                                            {{ trans('lang.saved') }}
                                                                        </a>
                                                                    </li> comment area end
                                                                @else
                                                                    comment area start <li v-cloak>
                                                                        <a href="javascrip:void(0);" class="wt-clicklike" id="freelancer-{{$freelancer->id}}" @click.prevent="add_wishlist('freelancer-{{$freelancer->id}}', {{$freelancer->id}}, 'saved_freelancer', '{{trans("lang.saved")}}')">
                                                                            <i class="fa fa-heart"></i>
                                                                            <span class="save_text">{{ trans('lang.click_to_save') }}</span>
                                                                        </a>
                                                                    </li> comment area end
                                                                @endif
                                                            </ul>
                                                        </div>
                                                        <div class="wt-rightarea">
                                                        @if (!empty($freelancer->profile['hourly_rate']))
                                                                    <span class="wt-hourlyrate">
                                                                        {{ (!empty($symbol['symbol'])) ? $symbol['symbol'] : '$' }}{{{ $freelancer->profile['hourly_rate'] }}} {{ trans('lang.per_hour') }}</span>
                                                                @endif
                                                            <div class="rating-area">
                                                            comment area start  <span class="wt-starcontent">
                                                                {{{ round($average_rating_count,2) }}}
                                                            </span>  comment area end
                                                            <span class="wt-stars"><span style="width: {{ $stars }}%;"></span></span> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if (!empty($freelancer->profile->description))
                                                        <div class="wt-description">
                                                            <p>{{{ str_limit($freelancer->profile->description, 180) }}}</p>
                                                        </div>
                                                    @endif
                                                    @if (!empty($freelancer->skills))
                                                        <div class="wt-tag wt-widgettag">
                                                            @foreach($freelancer->skills as $skill)
                                                            
                                                                <a href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                        
                                                            @endforeach
                                                        </div>
                                                    @endif -->

                                        <!-- ============= old script end =============== -->
                                    </div>
                                </div>
                                @endforeach
                                @if ( method_exists($users,'links') )
                                {{ $users->links('pagination.custom') }}
                                @endif
                                @else
                                @if (file_exists(resource_path('views/extend/errors/no-record.blade.php')))
                                @include('extend.errors.no-record')
                                @else
                                @include('errors.no-record')
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="wt-userlistingholder wt-userlisting wt-haslayout" id="grid-layout">
                            <div class="row">
                                <div class="wt-userlistingtitle">
                                    @if (!empty($users))
                                    <span>{{ trans('lang.01') }} {{$users->count()}} of {{\App\User::role('freelancer')->count()}} results @if (!empty($keyword)) for <em>"{{{$keyword}}}"</em> @endif</span>
                                    @endif
                                </div>
                                @if (!empty($users))
                                @foreach ($users as $key => $freelancer)
                                @php
                                $user_image = !empty($freelancer->profile['avater']) ?
                                '/uploads/users/'.$freelancer->id.'/'.$freelancer->profile['avater']:
                                '';
                                $flag = !empty($freelancer->location->flag) ? Helper::getLocationFlag($freelancer->location->flag) :
                                '/images/img-01.png';
                                $feedbacks = \App\Review::select('feedback')->where('receiver_id', $freelancer->id)->count();
                                $avg_rating = App\Review::where('receiver_id', $freelancer->id)->sum('avg_rating');
                                $rating = $avg_rating != 0 ? round($avg_rating/\App\Review::count()) : 0;
                                $reviews = \App\Review::where('receiver_id', $freelancer->id)->get();
                                $stars = $reviews->sum('avg_rating') != 0 ? (($reviews->sum('avg_rating')/$feedbacks)/5)*100 : 0;
                                $average_rating_count = !empty($feedbacks) ? $reviews->sum('avg_rating')/$feedbacks : 0;
                                $verified_user = \App\User::select('user_verified')->where('id', $freelancer->id)->pluck('user_verified')->first();
                                $save_freelancer = !empty(auth()->user()->profile->saved_freelancer) ? unserialize(auth()->user()->profile->saved_freelancer) : array();
                                $badge = Helper::getUserBadge($freelancer->id);
                                if (!empty($enable_package) && $enable_package === 'true') {
                                $feature_class = (!empty($badge) && $freelancer->expiry_date >= $current_date) ? 'wt-featured' : 'wt-exp';
                                $badge_color = !empty($badge) ? $badge->color : '';
                                $badge_img = !empty($badge) ? $badge->image : '';
                                } else {
                                $feature_class = 'wt-exp';
                                $badge_color = '';
                                $badge_img = '';
                                }
                                @endphp

                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 forgridview">
                                    <div class="freelancerspage wt-userlistinghold {{ $feature_class }}">
                                        @if(!empty($enable_package) && $enable_package === 'true')
                                        @if ($freelancer->expiry_date >= $current_date && !empty($freelancer->badge_id))
                                        <span class="wt-featuredtag" style="border-top: 40px solid {{ $badge_color }};">
                                            @if (!empty($badge_img))
                                            <img src="{{{ asset(Helper::getBadgeImage($badge_img)) }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style">
                                            @else
                                            <i class="wt-expired fas fa-bold"></i>
                                            @endif
                                        </span>
                                        @endif
                                        @endif
                                        <div class="row find-talent-freelancers" onclick="location.href='{{{url('profile/'.$freelancer->slug)}}}';" style="cursor: pointer;" >
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="find-talent">
                                                    <div class="row samemargin">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <figure class="wt-userlistingimg">
                                                                <img src="{{{ asset(Helper::getImageWithSize('uploads/users/'.$freelancer->id, $freelancer->profile, 'listing')) }}}" alt="{{ trans('lang.img') }}">
                                                            </figure>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 samemargin removepadding">
                                                            <div class="find-talent-info">
                                                                <div class="wt-title">
                                                                    <a href="{{{ url('profile/'.$freelancer->slug) }}}">
                                                                        @if ($verified_user == 1)
                                                                        <i class="fa fa-check-circle"></i>
                                                                        @endif
                                                                        <!-- {{{ Helper::getUserName($freelancer->id) }}} -->
                                                                        {{{$freelancer->first_name}}}
                                                                    </a>
                                                                    <!-- @if (!empty($freelancer->profile->tagline))
                                                                            <h2><a href="{{{ url('profile/'.$freelancer->slug) }}}">{{{ $freelancer->profile->tagline }}}</a></h2>
                                                                        @endif -->
                                                                </div>
                                                                <div class="wt-talent-skill">
                                                                    @if (!empty($freelancer->skills))
                                                                    @foreach($freelancer->skills as $i => $skill)
                                                                    @if($i==0)
                                                                    <!-- <img style="width: 16px" src="/uploads/logos/{{{ $skill->logo }}}" alt=""> -->
                                                                    <a href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="wt-talent-location">
                                                                    @if (!empty($freelancer->location))
                                                                    <span class="wt-locationarea">
                                                                        <img src="{{{asset(Helper::getLocationFlag($freelancer->location->flag))}}}" alt="{{{ trans('lang.location') }}}">
                                                                        {{{ !empty($freelancer->location->title) ? $freelancer->location->title : '' }}}
                                                                    </span>
                                                                    <!-- <span>
                                                                    <i class="fas fa-map-marker-alt"></i> 
                                                                        {{{ !empty($freelancer->location->title) ? $freelancer->location->title : '' }}}
                                                                </span> -->
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row ">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 samemargin ratingstarfordesktop">
                                                            <span class="wt-starcontent">
                                                                {{{ round($average_rating_count,2) }}}
                                                            </span>
                                                            <span class="wt-stars">
                                                                <span style="width: {{ $stars }}%;">
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div> -->
                                                    <div class="row ">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 samemargin">
                                                            @if (!empty($freelancer->skills))
                                                            <div class="wt-tag wt-widgettag">
                                                                <?php $count = 0; ?>
                                                                @foreach($freelancer->skills as $skill)
                                                                    <?php if($count == 2) break; ?>
                                                                        <a href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                                    <?php $count++; ?>
                                                                @endforeach

                                                                @if($freelancer->skills->count() > 1)
                                                                    <a class="wt-showall" href="{{{url('profile/'.$freelancer->slug)}}}">Show All</a>
                                                                @endif
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if($freelancer->is_certified == 1)
                                                    <a href="{{{ url('profile/'.$freelancer->slug) }}}" class="certified-badge">
                                                        <img src="/images/certified/Certified_Icon.svg" />
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 samemargin">
                                                        <div class="wt-description">
                                                            @if (!empty($freelancer->profile->description))
                                                            <p>{{{ str_limit($freelancer->profile->description, 40) }}}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div>
                                                            @if (!empty($freelancer->profile['hourly_rate']))
                                                            <span class="wt-hourlyrate">
                                                                <span>
                                                                    {{ (!empty($symbol['symbol'])) ? $symbol['symbol'] : '$' }}{{{ $freelancer->profile['hourly_rate'] }}} {{ trans('lang.per_hour') }}
                                                                </span>
                                                            </span>
                                                            @else
                                                            <span class="wt-hourlyrate">
                                                                <span>
                                                                    $0 / hr
                                                                </span>
                                                            </span>
                                                            @endif
                                                            <span class="ratingstarformobile">
                                                                <span class="wt-starcontent">
                                                                @if($average_rating_count == 0)
                                                                    Yet to be rated!
                                                                @else
                                                                {{{ round($average_rating_count,2) }}}
                                                                @endif
                                                                </span>
                                                                <span class="wt-stars">
                                                                    <span style="width: {{ $stars }}%;">
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="wt-userlistinghold grid {{ $feature_class }}">
                                            <div class="wt-top">
                                                @if(!empty($enable_package) && $enable_package === 'true')
                                                    @if ($freelancer->expiry_date >= $current_date && !empty($freelancer->badge_id))
                                                        <span class="wt-featuredtag" style="border-top: 40px solid {{ $badge_color }};">
                                                            @if (!empty($badge_img))
                                                                <img src="{{{ asset(Helper::getBadgeImage($badge_img)) }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style">
                                                            @else
                                                                <i class="wt-expired fas fa-bold"></i>
                                                            @endif
                                                        </span>
                                                    @endif
                                                @endif
                                                <figure class="wt-userlistingimg">
                                                    <img src="{{{ asset(Helper::getImageWithSize('uploads/users/'.$freelancer->id, $freelancer->profile['avater'], 'listing')) }}}" alt="{{ trans('lang.img') }}">
                                                </figure>
                                                <div class="wt-userlistingcontent">
                                                    <div class="wt-contenthead">
                                                        comment start <div class="wt-title">
                                                            <a href="{{{ url('profile/'.$freelancer->slug) }}}">
                                                                @if ($verified_user == 1)
                                                                    <i class="fa fa-check-circle"></i>
                                                                @endif
                                                                {{{ Helper::getUserName($freelancer->id) }}}
                                                            </a>
                                                            @if (!empty($freelancer->profile->tagline))
                                                                <h2><a href="{{{ url('profile/'.$freelancer->slug) }}}">{{{ $freelancer->profile->tagline }}}</a></h2>
                                                            @endif
                                                        </div> comment end 
                                                        <div class="wt-title">
                                                            @if($freelancer->is_certified == 1)
                                                                <a href="{{{ url('profile/'.$freelancer->slug) }}}">
                                                                    @if ($verified_user == 1)
                                                                        <i class="fa fa-check-circle"></i>
                                                                    @endif
                                                                    {{{ Helper::getUserName($freelancer->id) }}} <img style="position: absolute; top: 5px; max-width: 45px; right: 5px;" src="/images/certified/Certified_Icon.png"/>
                                                                </a>
                                                            @else 
                                                                <a href="{{{ url('profile/'.$freelancer->slug) }}}">
                                                                    @if ($verified_user == 1)
                                                                        <i class="fa fa-check-circle"></i>
                                                                    @endif
                                                                    {{{ Helper::getUserName($freelancer->id) }}}
                                                                </a>
                                                            @endif

                                                            @if (!empty($freelancer->profile->tagline))
                                                                <h2><a href="{{{ url('profile/'.$freelancer->slug) }}}">{{{ $freelancer->profile->tagline }}}</a></h2>
                                                            @endif
                                                        </div>
                                                        <ul class="wt-userlisting-breadcrumb">
                                                            @if (!empty($freelancer->skills))
                                                                @foreach($freelancer->skills as $i =>  $skill)
                                                                    @if($i==0)
                                                                        <img style="width: 16px" src="/uploads/logos/{{{ $skill->logo }}}" alt="">
                                                                        <a style="color: #2B2B2B" href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                                    @endif
                                                                @endforeach
                                                                @if (!empty($freelancer->location))
                                                                    <div>
                                                                        <li><span><i class="fas fa-map-marker-alt"></i> {{{ !empty($freelancer->location->title) ? $freelancer->location->title : '' }}}</span></li>
                                                                    </div>
                                                                @endif
                                                            
                                                                comment start <li><span><i class="fas fa-th"></i>
                                                                    React Developer
                                                                    {{ (!empty($symbol['symbol'])) ? $symbol['symbol'] : '$' }}{{{ $freelancer->profile['hourly_rate'] }}} {{ trans('lang.per_hour') }}</span>
                                                                </li> comment end
                                                            @endif
                                                            @if (!empty($freelancer->skills))
                                                                <div class="wt-tag wt-widgettag">
                                                                comment start @foreach($freelancer->skills as $skill)
                                                                    <a href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                                    <img src="/uploads/logos/{{{ $skill->logo }}}" alt="">
                                                                @endforeach comment end
                                                                </div>
                                                            @endif
                                                            @if (in_array($freelancer->id, $save_freelancer))
                                                                comment start <li class="wt-btndisbaled">
                                                                    <a href="javascrip:void(0);" class="wt-clicksave wt-clicksave">
                                                                        <i class="fa fa-heart"></i>
                                                                        {{ trans('lang.saved') }}
                                                                    </a>
                                                                </li> comment end
                                                            @else
                                                            comment start <li v-cloak>
                                                                    <a href="javascrip:void(0);" class="wt-clicklike" id="freelancer-{{$freelancer->id}}" @click.prevent="add_wishlist('freelancer-{{$freelancer->id}}', {{$freelancer->id}}, 'saved_freelancer', '{{trans("lang.saved")}}')">
                                                                        <i class="fa fa-heart"></i>
                                                                        <span class="save_text">{{ trans('lang.click_to_save') }}</span>
                                                                    </a>
                                                                </li> comment end
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                        
                                                @if (!empty($freelancer->skills))
                                                    <div class="wt-tag wt-widgettag">
                                                        @foreach($freelancer->skills as $i => $skill)
                                                            @if ($i <= 3)
                                                                <a href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="wt-bottom">
                                                @if (!empty($freelancer->profile['hourly_rate']))
                                                    <span class="wt-hourlyrate">
                                                        {{ (!empty($symbol['symbol'])) ? $symbol['symbol'] : '$' }}{{{ $freelancer->profile['hourly_rate'] }}} {{ trans('lang.per_hour') }}
                                                    </span>
                                                @endif
                                                <div class="rating-area">
                                                    comment start <span class="wt-starcontent">
                                                        {{{ round($average_rating_count,2) }}}
                                                    </span> comment end
                                                    <span class="wt-stars"><span style="width: {{ $stars }}%;"></span></span> 
                                                </div>
                                            </div>       
                                        </div> -->
                                @endforeach
                                @if ( method_exists($users,'links') )
                                {{ $users->links('pagination.custom') }}
                                @endif
                                @else
                                @if (file_exists(resource_path('views/extend/errors/no-record.blade.php')))
                                @include('extend.errors.no-record')
                                @else
                                @include('errors.no-record')
                                @endif
                                @endif
                            </div>
                        </div>
                </div>
                
            </div>
        </div>
        <div class="dynamic-data">
            @if(!empty($dynamic_content))
                @php echo htmlspecialchars_decode(stripslashes($dynamic_content)); @endphp
            @endif
        </div>
        
    </div>
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#talentModalCenter">
    Launch demo modal
    </button> -->

    <!-- Modal -->
    <div class="modal fade" onclick="closefunction()" id="talentModalCenter" tabindex="-1" role="dialog" aria-labelledby="talentModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" onclick="closefunction()" id="closebutton" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> -->
            <div class="modal-body">
                <div class="talent-popup-t1">Find the right resource</div>
                <!-- <div class="talent-popup-t2">Click <button type="button" id="moveonhome" class="btn btn-primary">here</button> to speed up this process</div> -->
                <div class="talent-popup-t2">Having hard time finding the right resource for your project ? Want to speed up the process ?</div>
                <div class="talent-popup-buttons">
                    <button type="button" onclick="closefunction()" class="btn btn-secondary" id="cancelbutton" data-dismiss="modal">Cancel</button>
                    <button type="button" id="moveonhome" class="btn btn-primary">Show me how</button>
                </div>
                
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelbutton" data-dismiss="modal">Close</button>
                <button type="button" id="moveonhome" class="btn btn-primary">Need Assistance</button>
            </div> -->
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
      const categoryCheckboxes = document.querySelectorAll('input[name="category[]"]');
      const skillCheckboxes = document.querySelectorAll('input[name="skill[]"]');

      categoryCheckboxes.forEach(function(checkbox) {
          checkbox.addEventListener("change", function() {
              const selectedCategories = Array.from(categoryCheckboxes)
                  .filter(cb => cb.checked)
                  .map(cb => cb.value);

              // Make an AJAX request to fetch skills based on selected categories
              fetch('get-skills-homepage-slug?category_id=' + selectedCategories.join(','))
              .then(response => response.json())
              .then(data => {
                  // Hide all skills checkboxes
                  skillCheckboxes.forEach(function(skillCheckbox) {
                      skillCheckbox.parentNode.style.display = 'none';
                  });

                  // Display skills based on the fetched data
                  data.forEach(function(skill) {
                      const skillCheckbox = document.getElementById('skill-' + skill.slug);
                      if (skillCheckbox) {
                          skillCheckbox.parentNode.style.display = 'block';
                          // Check the skill checkbox if it was previously checked
                          skillCheckbox.checked = selectedSkills.includes(skill.slug);
                      }
                  });
              })
              .catch(error => {
                  console.error('Error:', error);
              });
          });
      });
  });
</script>
<script type="text/javascript">

    $(document).ready(function() {
        setTimeout(function() {
            $('#talentModalCenter').modal('show');
        }, 30000);
    });

    function closefunction() {
        setTimeout(function() {
                $('#talentModalCenter').modal('show');
            }, 30000); 
    }

</script>
<!-- <script type="text/javascript">
    window.onload = function() {
        // alert(base_url)
        document.getElementById("talentModalCenter").onclick = function talentfun() {
            console.log("talentModalCenter");
            setTimeout(function() {
                $('#talentModalCenter').modal('show');
            }, 1000);  
        }
    }
    
</script> -->
<script type="text/javascript">
    var base_url = window.location.origin;
    window.onload = function() {
        document.getElementById("moveonhome").onclick = function movfunc() {
            window.location.href=`${base_url}/#speed-up-process`;
        }
    }
</script>
<!-- <script>
    $(document).ready(function(){
        $("#talentModalCenter").modal('show');
    });
</script> -->
<!-- <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script>
    if (APP_DIRECTION == 'rtl') {
        var direction = true;
    } else {
        var direction = false;
    }

    jQuery("#wt-categoriesslider").owlCarousel({
        item: 6,
        rtl: direction,
        loop: true,
        nav: false,
        margin: 0,
        autoplay: false,
        center: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            481: {
                items: 2,
            },
            768: {
                items: 3,
            },
            1440: {
                items: 4,
            },
            1760: {
                items: 6,
            }
        }
    });
</script> -->

@endpush
@endsection