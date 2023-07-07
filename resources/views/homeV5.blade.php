<html class="no-js" lang="" dir="ltr">
<head>
<meta charset="utf-8">
<meta https-equiv="X-UA-Compatible" content="IE=edge">

<title> eBelong : FREE Platform for talented freelancers</title>
<meta name="description" content="eBelong is a platform that connects freelancers with talent hunters. eBelong is a FREE platform to help professionals to get the remote jobs specially at this time where remote job is the norm.">
<meta name="keywords" content="freelancers, hire talent, get hired, ebelong">

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="apple-touch-icon" href="apple-touch-icon.png">
{{-- <link rel="icon" href="https://amentotech.com/projects/worketic/" type="image/x-icon"> --}}
<link rel="icon" href="{{{ asset(Helper::getSiteFavicon()) }}}" type="image/x-icon">
<link href="{{ asset('worketic/css/app.css') }}" rel="stylesheet">
{{-- <!--<link href="https://amentotech.com/projects/worketic/css/fontawesome/fontawesome-all.min.css" rel="stylesheet">
<link href="https://amentotech.com/projects/worketic/css/font-awesome.min.css" rel="stylesheet"> --> --}}
<link href="{{ asset('css/fontawesome/fontawesome-all.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<!-- <link href="https://amentotech.com/projects/worketic/css/transitions.css" rel="stylesheet"> -->
<link href="https://amentotech.com/projects/worketic/css/color.css" rel="stylesheet">

<link href="{{asset('css/linearicons.css') }}" rel="stylesheet">
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

{{-- <!-- <link href="https://amentotech.com/projects/worketic/css/linearicons.css" rel="stylesheet"> --> --}}	<link href="{{ asset('worketic/css/main.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


<style>
.wt-latestjobs > ul > li.deactivate{
display:none;
}


.wt-logo-header{
height:0px !important;
}

.wt-header .wt-navigation>ul>.menu-item-has-children:after,
.wt-header .wt-navigation > ul > li > a {
color: #ffffff;
}

.wt-navigation > ul > li.current-menu-item > a,
.wt-navigation ul li .sub-menu > li:hover > a,
.wt-navigation > ul > li:hover > a {
color: #fbde44;
}

.wt-header .wt-navigationarea .wt-navigation > ul > li > a:after {
background: #fbde44;
}

.wt-header .wt-navigationarea .wt-userlogedin .wt-username span,
.wt-header .wt-navigationarea .wt-userlogedin .wt-username h3 {
color: #ffffff
}
   #chat-container {
            width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            position: fixed;
            bottom: 95px;
            right: 40px;
            z-index: 99;
            background-color: #fff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* CSS styles for the chat messages */
        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .user-message {
            text-align: right;
            color: #0066cc;
            background-color: #eaf6ff;
            font-size: 20px;
        }

        .bot-message {
            text-align: left;
            color: #333333;
            background-color: #f5f5f5;
            font-size: 20px;
        }


        /* CSS styles for the answer buttons */
        .answer-button {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #e0e0e0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .answer-button:hover {
            background-color: #d0d0d0;
        }
.chat-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  font-size: 1.375rem;
  background-color: #9013F3;
  box-shadow: 0 5px 15px -3px rgba(0,0,0,.25);
  position: fixed;
  right: 1.5rem;
  bottom: 2.25rem;
  text-align: center;
  color: #fff;
  z-index: 1000;
  cursor: pointer;
}
.answer-dropdown{
	width: 100%;
}
@media only screen and (min-device-width : 320px) and (max-device-width : 480px) 
{
.wt-header .wt-navigation > ul > li > a {
color: #767676 !important ;
}

.wt-navigationarea .wt-logo {
margin: 5px 0 0;
height: 35.5px !important;
} 
 #chat-container {
    width: 90%;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    position: fixed;
    bottom: 95px;
    right: 40px;
    z-index: 99;
    background-color: #fff;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
}   
}
</style>
<script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!}
var readmore_trans = {!! json_encode(trans('lang.read_more')) !!}
var less_trans = {!! json_encode(trans('lang.less')) !!}
var Map_key = {!! json_encode(Helper::getGoogleMapApiKey()) !!}
var APP_DIRECTION = {!! json_encode(Helper::getTextDirection()) !!}
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-47887669-1"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'UA-47887669-1');
</script>
</head>

<body class="wt-login lang-en ltr ">
<div id="chat-container">
    <div id="messages-container"></div>
    <div id="answer-buttons-container" class="d-flex" style="justify-content: space-evenly"></div>
</div>

<div class="chat-btn hidden-xs" id="floating-button">
  <span class="lnr lnr-question-circle"></span>
</div>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div class="preloader-outer" style="display: block;">
<div class="preloader-holder">
<div class="loader"></div>
</div>
</div>
<div id="wt-wrapper" class="wt-wrapper wt-haslayout">
<div class="wt-contentwrapper">
@if (Schema::hasTable('pages') || Schema::hasTable('site_managements'))
@php
$settings = array();
$pages = App\Page::all();
$setting = \App\SiteManagement::getMetaValue('settings');
$logo = !empty($setting[0]['logo']) ? Helper::getHeaderLogo($setting[0]['logo']) : '/images/logo.png';
$inner_header = !empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' ? 'wt-headervtwo' : '';
$type = Helper::getAccessType();
$page_id='';
if (!empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' && Route::getCurrentRoute()->uri() != 'home') {
if (Request::segment(1) == 'page') {
$selected_page_data = APP\Page::getPageData(Request::segment(2));
$selected_page = !empty($selected_page_data) ? APP\Page::find($selected_page_data->id) : '';
$page_id = !empty($selected_page) ? $selected_page->id : '';
}
} 
else {
$page_id = APP\SiteManagement::getMetaValue('homepage');
}
$slider = Helper::getPageSlider($page_id);
@endphp
@endif
<header id="wt-header" class="wt-header wt-headereleven">
<div class="wt-navigationarea">
<div class="container">
<div class="row">
<div class="pl-0 col-xs-12 col-sm-12 col-md-12 col-lg-12">
<strong class="wt-logo wt-logo-header desktop-logo" >
	<a href="{{{ url('/') }}}"><!--<img src="{{{ asset($logo) }}}" alt="{{{ trans('Logo') }}}" style="height:30px;">-->
		<img src="{{ asset('uploads/settings/general/1615054786-ebelong-logo-header.png') }}" alt="{{{ trans('Logo') }}}"  style="width:184px;">
	</a>
</strong>
<strong class="wt-logo wt-logo-header mobile-logo" >
	<a href="{{{ url('/') }}}"><!--<img src="{{{ asset($logo) }}}" alt="{{{ trans('Logo') }}}" style="height:30px;">-->
		<img src="{{ asset('uploads/settings/general/ebelong-mobile-logo.png') }}" alt="{{{ trans('Logo') }}}">
	</a>
</strong>
<div class="wt-rightarea">
	<nav id="wt-nav" class="wt-nav navbar-expand-lg">
		<button type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
			<i class="lnr lnr-menu"></i>
		</button>
		<div id="navbarNav" class="collapse navbar-collapse wt-navigation">
			<ul class="navbar-nav">
				<?php $user_role = Helper::getSessionUserRole(); ?>
				<?php if($user_role): ?>
					<?php if($user_role == 'guest'||$user_role == 'editor'): ?>
					<li style="order: 1;">
						<a href="{{url('/hire-remote-developers')}}">
							Hire Developers
						</a>
					</li>
					<li style="order: 1;">
						<a href="{{url('/courses')}}">
							{{{ trans('lang.courses') }}}
						</a>
					</li>
					<li style="order: 2;">
						<a href="{{url('hire')}}">
							{{{ trans('lang.Talent') }}}
						</a>
					</li>
					<li style="order: 4;">
						<a href="{{url('/jobs')}}">
							{{{ trans('lang.jobs') }}}
						</a>
					</li>
					<li style="order: 5;">
						<a href="{{url('/services')}}">
							{{{ trans('lang.services') }}}
						</a>
					</li>
					<li style="order: 6;">
						<a href="{{url('/blogs')}}">
							{{{ trans('lang.Blogs') }}}
						</a>
					</li>
					<li style="order: 6;" class="join-now-menu">
						<a href="{{{ route('register') }}}" class="">
							{{{ trans('lang.join_now') }}}
						</a>
					</li>
					<?php elseif($user_role == 'admin'): ?>
					<li style="order: 1;">
						<a href="{{url('/courses')}}">
							{{{ trans('lang.courses') }}}
						</a>
					</li>
					<li style="order: 2;">
						<a href="{{url('hire')}}">
							{{{ trans('lang.Talent') }}}
						</a>
					</li>
					<li style="order: 4;">
						<a href="{{url('/jobs')}}">
							{{{ trans('lang.jobs') }}}
						</a>
					</li>
					<li style="order: 5;">
						<a href="{{url('services')}}">
							{{{ trans('lang.services') }}}
						</a>
					</li>
					<li style="order: 6;">
						<a href="{{url('/blogs')}}">
							{{{ trans('lang.Blogs') }}}
						</a>
					</li>
					<?php elseif($user_role == 'employer'): ?>
					<li style="order: 2;">
						<a href="{{url('hire')}}">
							{{{ trans('lang.Talent') }}}
						</a>
					</li>
					<li style="order: 5;">
						<a href="{{url('/services')}}">
							{{{ trans('lang.services') }}}
						</a>
					</li>		
					<?php elseif($user_role == 'freelancer'): ?>
					<li style="order: 1;">
						<a href="{{url('/courses')}}">
							{{{ trans('lang.courses') }}}
						</a>
					</li>
					<li style="order: 4;">
						<a href="{{url('/jobs')}}">
							{{{ trans('lang.jobs') }}}
						</a>
					</li>
								
					<?php endif;  ?>
				<?php endif;  ?>
			</ul>
		</div>
	</nav>
	

	{{--<div class="wt-loginarea">
		<div class="wt-loginoption wt-loginoptionvtwo">
			<a href="javascript:void(0);" id="wt-loginbtn" class="wt-btn">Sign In</a>
			<div class="wt-loginformhold">
				<div class="wt-loginheader">
					<span>Sign In</span> 
					<a href="javascript:;">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<form method="POST" action="{{ route('login') }}" class="wt-formtheme wt-loginform do-login-form">
					@csrf
					<fieldset>
						<div class="form-group">
							<input id="email" type="email" name="email" placeholder="Email" required="required" autofocus="autofocus" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
								@if ($errors->has('email'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
								@endif
						</div>
						<div class="form-group">
							<input id="password" type="password" name="password" placeholder="Password" required="required" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">
								@if ($errors->has('password'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
								@endif
						</div>
						<div class="wt-logininfo">
							<button href="javascript:;" type="submit" class="wt-btn do-login-button">{{{ trans('lang.login') }}}</button>
							<span class="wt-checkbox">
								<input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> <label for="remember">{{{ trans('lang.remember') }}}</label>
							</span>
						</div>
					</fieldset>
					<div class="wt-loginfooterinfo">
						@if (Route::has('password.request'))
						<a href="{{ route('password.request') }}" class="wt-forgot-password">{{{ trans('lang.forget_pass') }}}</a>
						@endif 
						<a href="{{{ route('register') }}}">{{{ trans('lang.create_account') }}}</a></div>
				</form>
			</div>
		</div> 
		<a href="{{{ route('register') }}}" class="wt-btn">{{{ trans('lang.join_now') }}}</a>
	</div> --}}
	@guest
	<div class="wt-loginarea">
		<div class="wt-loginoption">
			<a href="javascript:void(0);" id="wt-loginbtn" class="wt-loginbtn">{{{trans('lang.login') }}}</a>
			<div class="wt-loginformhold" @if ($errors->has('email') || $errors->has('password')) style="display: block;" @endif>
				<div class="wt-loginheader">
					<span>{{{ trans('lang.login') }}}</span>
					<a href="javascript:;"><i class="fa fa-times"></i></a>
				</div>
				<form method="POST" action="{{ route('login') }}" class="wt-formtheme wt-loginform do-login-form" >
					@csrf
					<fieldset>
						<div class="form-group">
							<input id="email" type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" required autofocus>
								@if ($errors->has('email'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
								@endif
						</div>
						<div class="form-group">
							<input id="password" type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" required>
								@if ($errors->has('password'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
								@endif
						</div>
						<div class="wt-logininfo">
							<button type="submit" class="wt-btn do-login-button">{{{ trans('lang.login') }}}</button>
							<span class="wt-checkbox">
								<input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
								<label for="remember">{{{ trans('lang.remember') }}}</label>
							</span>
						</div>

						<div class="wt-logininfo linkedIn-btn">
							<div style="display: flex;">
								<img class="linkedIn-btn-icon" src="{{ asset('uploads/social-media-icons/linkedin-logo.png') }}" alt="linkedin icon"> 
								<a href="/auth/linkedin/redirect">Sign Up With LinkedIn</a> 
							</div>
						</div>

					</fieldset>
					
					<div class="wt-loginfooterinfo">
						@if (Route::has('password.request'))
						<a href="{{ route('password.request') }}" class="wt-forgot-password">{{{ trans('lang.forget_pass') }}}</a>
						@endif
						<a href="{{{ route('register') }}}">{{{ trans('lang.create_account') }}}</a>
					</div>
				</form>
			</div>
		</div>
		<a href="{{{ route('register') }}}" class="wt-btn join-now-nav">{{{ trans('lang.join_now') }}}</a>
		<!-- <div id='candidate_count'>
			<candidate_count></candidate_count>
		</div> -->
		<div data-component="CandidateCountt" data-vue='{}'  id="candidate_count"></div>
	</div> 
	@endguest
	@auth
		@php
			$user = !empty(Auth::user()) ? Auth::user() : '';
			$role = !empty($user) ? $user->getRoleNames()->first() : array();
			$profile = \App\User::find(Auth::user()->id)->profile;
			$user_image = !empty($profile) ? $profile->avater : '';
			$employer_job = \App\Job::select('status')->where('user_id', Auth::user()->id)->first();
			$profile_image = !empty($user_image) ? '/uploads/users/'.$user->id.'/'.$user_image : 'images/user-login.png';
			$payment_settings = \App\SiteManagement::getMetaValue('commision');
			$payment_module = !empty($payment_settings) && !empty($payment_settings[0]['enable_packages']) ? $payment_settings[0]['enable_packages'] : 'true';
			$employer_payment_module = !empty($payment_settings) && !empty($payment_settings[0]['employer_package']) ? $payment_settings[0]['employer_package'] : 'true';
		@endphp
		<div class="wt-userlogedin">
			<figure class="wt-userimg">
				{{-- <img src="{{{ asset($profile_image) }}}" alt="{{{ trans('lang.user_avatar') }}}"> --}}
				<img src="{{{ asset(Helper::getImage('uploads/users/' . Auth::user()->id, $profile->avater, '' , 'user.jpg')) }}}" alt="{{{ trans('lang.user_avatar') }}}">
			</figure>
			<div class="wt-username">
				<h3>{{{ Helper::getUserName(Auth::user()->id) }}}</h3>
				<span>{{{ !empty(Auth::user()->profile->tagline) ? str_limit(Auth::user()->profile->tagline, 30, '') : Helper::getAuthRoleName() }}}</span>
			</div>
			@if (file_exists(resource_path('views/extend/back-end/includes/profile-menu.blade.php'))) 
				@include('extend.back-end.includes.profile-menu')
			@else 
				@include('back-end.includes.profile-menu')
			@endif
		</div>
	@endauth
	@if (!empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' && Route::getCurrentRoute()->uri() != 'home')
		<div class="wt-respsonsive-search"><a href="javascript:void(0);" class="wt-searchbtn"><i class="fa fa-search"></i></a></div>
	@endif
</div>
</div>
</div>
</div>
</div>
</header>

<div class="custom-desktop custome-home-banner">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
<!-- Wrapper for slides -->
<div class="carousel-inner">
<div class="carousel-item active">
<div class="container banner1">
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6">
		<div class="section-main-wrapper10">
			<div class="wt-banner">
				<div data-vue='<?php echo json_encode(array('categories'=> $categories,'skills'=>$all_skills)) ?>' data-component="BannerContent" id="e-banner-content"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6">
		<img class="home-banner-img2" src="{{ asset('uploads/settings/general/FreelancerNew-1.png') }}" alt="banner here"> 
	</div>
</div>
</div>
</div>

<div class="carousel-item">
<div class="container banner2">
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6">
		<div class="section-main-wrapper10">
			<div class="wt-banner">
			<div data-vue='<?php echo json_encode(array('categories'=> $categories,'skills'=>$all_skills)) ?>' data-component="BannerContent1" id="e-banner-content"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6">
		<img class="home-banner-img1" src="{{ asset('uploads/settings/general/FreelancerNew-2.png') }}" alt="banner here"> 
	</div>
</div>
</div>
</div>

</div> 

<!-- Left and right controls -->
<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
<span class="carousel-control-prev-icon" aria-hidden="true"></span>
<span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
<span class="carousel-control-next-icon" aria-hidden="true"></span>
<span class="sr-only">Next</span>
</a>
</div>
</div>
<div class="custom-mobile">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
<!-- Indicators -->
<ol class="carousel-indicators">
<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>

</ol>

<!-- Wrapper for slides -->
<div class="carousel-inner">
<div class="carousel-item active">
<div class="custome-home-banner">
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<img class="home-banner-img2" src="{{ asset('uploads/settings/general/FreelancerNew-1.png') }}" alt="banner here"> 
		</div>
	</div>
</div>
</div>
<div class="custome-home-banner-below">
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="section-main-wrapper10">
				<div class="wt-banner">
					<div data-vue='<?php echo json_encode(array('categories'=> $categories,'skills'=>$all_skills)) ?>' data-component="BannerContent" id="e-banner-content"></div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>

<div class="carousel-item">
<div class="custome-home-banner">
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<img class="home-banner-img1" src="{{ asset('uploads/settings/general/FreelancerNew-2.png') }}" alt="banner here"> 
		</div>
	</div>
</div>
</div>
<div class="custome-home-banner-below">
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="section-main-wrapper10">
				<div class="wt-banner">
					<div data-vue='<?php echo json_encode(array('categories'=> $categories,'skills'=>$all_skills)) ?>' data-component="BannerContent1" id="e-banner-content"></div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div> 
</div>
</div>
<!-- <img class="home-banner-img" src="{{ asset('uploads/settings/general/home_banner.png') }}" alt="banner here">  -->
<?php 
// echo json_encode($freelancers);
// Log::info(json_encode($freelancers));
?>
<!-- <?php echo json_encode($freelancers);?> -->
<div data-component="FeaturedSkill" data-vue='<?php echo json_encode(array('categories'=> $categories,'skills'=>$all_skills)) ?>' id="e-freelancer-featured-skill"></div>
<div data-component="Slider" data-vue='<?php echo json_encode($freelancers);?>' id="e-freelancer"></div>
<div data-component="WhyeBelong" data-vue='{}' id="e-whyebleong"></div>
<div data-component="Courses" data-vue='<?php echo json_encode($services);?>' id="e-services"></div>
<div data-component="BannerJob" data-vue='{}'  id="e-banner-job" ></div>
<div data-component="PostSkill" data-vue='<?php echo json_encode(array('categories'=> $categories,'skills'=>$all_skills)) ?>' id="e-postskill"></div>

<!-- <div class="instagram-widget2">
<div class="container">
<div class="row">
<div class="col-sm-12">
<iframe src="https://snapwidget.com/embed/949623" class="snapwidget-widget" allowtransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden;  width:800px; height:160px"></iframe>
</div>
</div>
</div>

</div> -->


@auth
<div data-component="PostJob" data-vue='<?php echo json_encode($user);?>'  id="e-postjob"></div>
@endauth
@guest
<div data-component="PostJob" data-vue='{}'  id="e-postjob"></div>
@endguest
<div class="instagram-widget">
<div data-mc-src="0d13b9ae-91ec-4ad7-9cf1-0fef35eb2bbe#instagram"></div>
<script 
src="https://cdn2.woxo.tech/a.js#60ed75977550f200151dbbe8" 
async data-usrc>
</script>
</div>
<link href="{{ asset('worketic/css/prettyPhoto-min.css') }}" rel="stylesheet">
<style>
.wt-header .wt-navigation>ul>.menu-item-has-children:after,
.wt-header .wt-navigation > ul > li > a {
color: #ffffff;
}

.wt-navigation > ul > li.current-menu-item > a,
.wt-navigation ul li .sub-menu > li:hover > a,
.wt-navigation > ul > li:hover > a {
color: #fbde44;
}
.wt-header .wt-navigationarea .wt-navigation > ul > li > a:after {
background: #fbde44;
}

.wt-header .wt-navigationarea .wt-userlogedin .wt-username span,
.wt-header .wt-navigationarea .wt-userlogedin .wt-username h3 {
color: #ffffff
}

.testing-div {
position: absolute;
}


</style>
<div data-component="WhatsappIconComponent" data-vue='{}'  id="e-postjob"></div>
<footer id="wt-footer" class="wt-footerholder wt-footertwo wt-haslayout">
<div class="container">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-12">
<div class="wt-footerlogohold"> 
<div class="wt-logo">
	<a href="{{{ url('/') }}}">
		<img src="{{ asset('uploads/settings/general/ebelong-logo-footer.png') }}" alt="company logo here" style="width:150px;">
	</a>
</div>
<div class="wt-description">
	<p>Freelancing talent partner</p>
</div>
</div>
<button onclick="location.href='/hire'" class="e-button e-button-primary">Hire Now</button>
<button onclick="location.href='/jobs'" class="e-button e-button-primary my-3">Get Work</button>
</div>

@php
$footer = \App\SiteManagement::getMetaValue('footer_settings');
$search_menu = \App\SiteManagement::getMetaValue('search_menu');
$menu_title = DB::table('site_managements')->select('meta_value')->where('meta_key', 'menu_title')->get()->first();
@endphp
<div class="col-lg-6 col-md-6 col-sm-12">
<div class="row">
<div class="col-6 col-sm-6 col-md-4 col-lg-4">
	<div class="wt-footercol">
		<div class="wt-fwidgettitle">
			<h3>Company</h3>
		</div>
		@if(!empty($footer['menu_pages_1']))
			<ul class="wt-fwidgetcontent">
				@foreach($footer['menu_pages_1'] as $menu_1_page)
					@php  $page = \App\Page::where('id', $menu_1_page)->first(); @endphp
					@if (!empty($page))
						<li><a href="{{{ url('page/'.$page->slug) }}}">{{{ $page->title }}}</a></li>
					@endif
				@endforeach
			</ul>
		@endif
	</div>
</div>
<div class="col-6 col-sm-6 col-md-4 col-lg-4">
	<div class="wt-footercol wt-widgetexplore">
		<div class="wt-fwidgettitle">
			<h3>Explore More</h3> 
		</div>
		<ul class="wt-fwidgetcontent">
			@foreach($search_menu as $key => $page)
				<li><a href="{!! url($page['url']) !!}">{{$page['title']}}</a></li>
			@endforeach
		</ul>
	</div>
</div>
<div class="col-6 col-sm-6 col-md-4 col-lg-4">
	<div class="wt-footercol wt-widgetexplore">
		
		<ul class="wt-fwidgetcontent mob-app-link">
			<li>
				<a href="https://play.google.com/store/apps/details?id=com.ebelong" target="_blank" rel="noopener noreferrer">
					<img src="{{ asset('images/android.png') }}" alt="Play Store Link" style="width: 75%;">
				</a>
			</li>
			<li>
				<a href="https://apps.apple.com/pk/app/ebelong-app/id1578731419" target="_blank" rel="noopener noreferrer">
					<img src="{{ asset('images/ios.png') }}" alt="App Store Link" style="width: 75%;">
				</a>
			</li>
		</ul>
	</div>
</div>
<div style="display : none" class="col-sm-12 col-md-4 col-lg-4">
	<div class="wt-footercol">
		<div class="wt-fwidgettitle">
			<h3>Help</h3>
		</div>
		<!-- =================== Please remove its a dummy data for design =========================== -->
		<ul class="wt-fwidgetcontent">
			<li><a href="">FAQs</a></li>
			<li><a href="">Contact Us</a></li>
		</ul>
		<!-- ============== uncomment the lines and Change according to the requirment================== -->
		<!-- @if(!empty($footer['menu_pages_1']))
			<ul class="wt-fwidgetcontent">
				@foreach($footer['menu_pages_1'] as $menu_1_page)
					@php  $page = \App\Page::where('id', $menu_1_page)->first(); @endphp
					@if (!empty($page))
						<li><a href="{{{ url('page/'.$page->slug) }}}">{{{ $page->title }}}</a></li>
					@endif
				@endforeach
			</ul>
		@endif -->
	</div>
</div>
</div>
<!-- <div class="row">
<div class="col-lg-12 col-md-12 col-sm-12">
	<div class="mob-app-link">
		<a href="https://play.google.com/store/apps/details?id=com.ebelong" target="_blank" rel="noopener noreferrer"><img src="https://d1a3f4spazzrp4.cloudfront.net/uber-com/1.3.8/d1a3f4spazzrp4.cloudfront.net/illustrations/app-store-google-4d63c31a3e.svg" alt="Play Store Link" style="/* width:100px; */height: 35px;"></a>
		<a href="https://apps.apple.com/pk/app/ebelong-app/id1578731419" target="_blank" rel="noopener noreferrer"><img src="https://d1a3f4spazzrp4.cloudfront.net/uber-com/1.3.8/d1a3f4spazzrp4.cloudfront.net/illustrations/app-store-apple-f1f919205b.svg" alt="App Store Link" style="/* width:42px; */height: 35px;"></a>
	</div>
</div>
</div> -->
</div>
</div>
<div class="row wt-footercol2">
<div class="col-lg-6 col-md-6 col-sm-12">
<div class="other-links">
<div class="other-link"><a href="/page/terms-and-condition">Terms & Conditions</a></div>
<div class="other-link"><a href="/page/privacy-policy">Privacy Policy</a></div>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12">
@php Helper::displaySocials(); @endphp
</div>
</div>
</div>
<div class="wt-haslayout wt-footerbottom">
<div class="container">
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<p class="wt-copyrights">Copyright © <?php echo date("Y"); ?> eBelong, All Right Reserved eBelong</p>
<nav class="wt-addnav">
	<ul>
	<!--<li><a href="https://amentotech.com/projects/worketic/page/about-us">About Us</a></li>
		<li><a href="https://amentotech.com/projects/worketic/page/privacy-policy">Privacy Policy</a></li> -->
	</ul>
</nav>
</div>
</div>
</div>
</div>
</footer>
</div>
</div>
<script src="{{ asset('worketic/js/jquery-3.3.1.min.js') }}"></script>

<script src="{{ asset('worketic/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('worketic/js/vendor/jquery-library.js') }}"></script>	

<script>
var home = document.createElement('script');
home.src="{{ asset('js/home.js') }}";
document.body.appendChild(home);
home.onreadystatechange = home.onload = function(){
jQuery(".preloader-outer").fadeOut();
}
</script>
<script>
        const questions = {
            freelancer: [

                {
                    text: "Are you looking for jobs?",
                    options: [
                        { value: "yes", label: "Yes" },
                        { value: "no", label: "No" }
                    ]
                },
               {
			      text: "What skills you have",
			      dropdown: true, // Indicate that this question uses a dropdown
			      options: [
				    { value: "3d-design", label: "3D design" },
				    { value: "accounting", label: "Accounting" },
				    { value: "accounting-bookkeeping", label: "Accounting & Bookkeeping" },
				    { value: "admin", label: "Admin" },
				    { value: "administrative-assistance", label: "Administrative Assistance" },
				    { value: "adobe-illustrator", label: "Adobe Illustrator" },
				    { value: "adobe-indesign", label: "Adobe Indesign" },
				    { value: "adobe-photoshop", label: "Adobe Photoshop" },
				    { value: "adobe-premier-pro", label: "Adobe Premier Pro" },
				    { value: "amazon-virtual-assistant", label: "Amazon Virtual Assistant" },
				    { value: "amazon-virtual-assistant-ava", label: "Amazon Virtual Assistant (AVA)" },
				    { value: "amazon-web-services-aws", label: "Amazon Web Services (AWS)" },
				    { value: "android-development", label: "Android development" },
				    { value: "angularjs-development", label: "AngularJS development" },
				    { value: "animation", label: "Animation" },
				    { value: "apache", label: "Apache" },
				    { value: "artificial-intelligence", label: "Artificial Intelligence" },
				    { value: "asp-development", label: "ASP Development" },
				    { value: "autocad", label: "AutoCAD" },
				    { value: "automation-testing", label: "Automation Testing" },
				    { value: "business-stationery-design", label: "Business Stationery Design" },
				    { value: "cloud-computing", label: "Cloud Computing" },
				    { value: "coding", label: "Coding" },
				    { value: "computer-vision", label: "Computer Vision" },
				    { value: "consulting", label: "Consulting" },
				    { value: "content-writing", label: "Content Writing" },
				    { value: "copywriter", label: "Copywriter" },
				    { value: "creative-writer", label: "Creative Writer" },
				    { value: "css", label: "CSS" },
				    { value: "data-entry", label: "Data Entry" },
				    { value: "data-mining", label: "Data Mining" },
				    { value: "data-science", label: "Data Science" },
				    { value: "data-science-analysis", label: "Data Science & Analysis" },
				    { value: "data-visualization", label: "Data Visualization" },
				    { value: "deep-learning", label: "Deep Learning" },
				    { value: "desktop-applications", label: "Desktop Applications" },
				    { value: "digital-marketing", label: "Digital Marketing" },
				    { value: "digital-marketing-1", label: "Digital Marketing 1" },
				    { value: "diptrace", label: "Diptrace" },
				    { value: "django-framework", label: "Django Framework" },
				    { value: "dlib", label: "Dlib" },
				    { value: "docker", label: "Docker" },
				    { value: "e-commerce", label: "E-Commerce" },
				    { value: "electrical-engineer", label: "Electrical Engineer" },
				    { value: "english-proofreading", label: "English Proofreading" },
				    { value: "expressjs", label: "Express.Js" },
				    { value: "fast-ai", label: "Fast AI" },
				    { value: "fast-api", label: "Fast API" },
				    { value: "festo-fluidsim", label: "Festo Fluidsim" },
				    { value: "flask", label: "Flask" },
				    { value: "flyer-design", label: "Flyer Design" },
				    { value: "graphic-designing", label: "Graphic Designing" },
				    { value: "growth-hacking", label: "Growth Hacking" },
				    { value: "growth-marketing", label: "Growth Marketing" },
				    { value: "html-5", label: "HTML 5" },
				    { value: "ios-development", label: "iOS development" },
				    { value: "java-development", label: "Java development" },
				    { value: "java-script", label: "Java Script" },
				    { value: "jenkins", label: "Jenkins" },
				    { value: "lead-generation", label: "Lead Generation" },
				    { value: "linux", label: "Linux" },
				    { value: "machine-learning", label: "Machine Learning" },
				    { value: "magento-1", label: "Magento" },
				    { value: "matlab", label: "MATLAB" },
				    { value: "matlot-lib", label: "Matlot lib" },
				    { value: "mern-stack", label: "Mern Stack" },
				    { value: "microsoft", label: "Microsoft" },
				    { value: "microsoft-azure", label: "Microsoft Azure" },
				    { value: "microsoft-visual-studio-c", label: "Microsoft Visual Studio (C++)" },
				    { value: "mobile-app-development", label: "Mobile App Development" },
				    { value: "mongo-db", label: "Mongo DB" },
				    { value: "my-sql", label: "My SQL" },
				    { value: "nginx", label: "NGINX" },
				    { value: "node-js", label: "Node Js" },
				    { value: "numpi", label: "NumPi" },
				    { value: "open-cv", label: "Open CV" },
				    { value: "pandas", label: "Pandas" },
				    { value: "pcb-design", label: "PCB Design" },
				    { value: "php", label: "PHP" },
				    { value: "php-laravel-framework", label: "PHP Laravel Framework" },
				    { value: "poster-design", label: "Poster Design" },
				    { value: "project-management", label: "Project Management" },
				    { value: "proof-reading", label: "Proof Reading" },
				    { value: "proteus", label: "Proteus" },
				    { value: "python-1", label: "Python" },
				    { value: "qa", label: "QA" },
				    { value: "react-native", label: "React Native" },
				    { value: "reactjs", label: "React.Js" },
				    { value: "sales-force", label: "Sales Force" },
				    { value: "seo", label: "SEO" },
				    { value: "shopify-development", label: "Shopify Development" },
				    { value: "simulink", label: "Simulink" },
				    { value: "social-media-marketing", label: "Social Media Marketing" },
				    { value: "spreadsheets", label: "Spreadsheets" },
				    { value: "test", label: "TEST" },
				    { value: "tkinter", label: "Tkinter" },
				    { value: "translating", label: "Translating" },
				    { value: "unit-testing", label: "Unit Testing" },
				    { value: "unix", label: "Unix" },
				    { value: "user-experience-design", label: "User Experience Design" },
				    { value: "video-editing", label: "Video Editing" },
				    { value: "virtual-assistant", label: "Virtual Assistant" },
				    { value: "voice-talent", label: "Voice talent" },
				    { value: "web-applications", label: "Web Applications" },
				    { value: "website-design", label: "Website Design" },
				    { value: "wikipedia-contributor", label: "Wikipedia Contributor" },
				    { value: "wordpress-development", label: "WordPress Development" },
				    { value: "wordpress-plugin-development", label: "Wordpress Plugin Development" },
				    { value: "wordpress-theme-development", label: "Wordpress Theme Development" },
				    { value: "zendesk", label: "Zendesk" }
				    // Add more options as needed
				]

			    },
            ],
            employer: [
                {
                    text: "Are you an employer?",
                    options: [
                        { value: "yes", label: "Yes" },
                        { value: "no", label: "No" }
                    ]
                },
                {
                    text: "Are you looking for freelancers?",
                    options: [
                        { value: "yes", label: "Yes" },
                        { value: "no", label: "No" }
                    ]
                },
                 {
			      text: "What are the key skills you are looking in your candidate",
			      dropdown: true, // Indicate that this question uses a dropdown
			      options: [
				    { value: "3d-design", label: "3D design" },
				    { value: "accounting", label: "Accounting" },
				    { value: "accounting-bookkeeping", label: "Accounting & Bookkeeping" },
				    { value: "admin", label: "Admin" },
				    { value: "administrative-assistance", label: "Administrative Assistance" },
				    { value: "adobe-illustrator", label: "Adobe Illustrator" },
				    { value: "adobe-indesign", label: "Adobe Indesign" },
				    { value: "adobe-photoshop", label: "Adobe Photoshop" },
				    { value: "adobe-premier-pro", label: "Adobe Premier Pro" },
				    { value: "amazon-virtual-assistant", label: "Amazon Virtual Assistant" },
				    { value: "amazon-virtual-assistant-ava", label: "Amazon Virtual Assistant (AVA)" },
				    { value: "amazon-web-services-aws", label: "Amazon Web Services (AWS)" },
				    { value: "android-development", label: "Android development" },
				    { value: "angularjs-development", label: "AngularJS development" },
				    { value: "animation", label: "Animation" },
				    { value: "apache", label: "Apache" },
				    { value: "artificial-intelligence", label: "Artificial Intelligence" },
				    { value: "asp-development", label: "ASP Development" },
				    { value: "autocad", label: "AutoCAD" },
				    { value: "automation-testing", label: "Automation Testing" },
				    { value: "business-stationery-design", label: "Business Stationery Design" },
				    { value: "cloud-computing", label: "Cloud Computing" },
				    { value: "coding", label: "Coding" },
				    { value: "computer-vision", label: "Computer Vision" },
				    { value: "consulting", label: "Consulting" },
				    { value: "content-writing", label: "Content Writing" },
				    { value: "copywriter", label: "Copywriter" },
				    { value: "creative-writer", label: "Creative Writer" },
				    { value: "css", label: "CSS" },
				    { value: "data-entry", label: "Data Entry" },
				    { value: "data-mining", label: "Data Mining" },
				    { value: "data-science", label: "Data Science" },
				    { value: "data-science-analysis", label: "Data Science & Analysis" },
				    { value: "data-visualization", label: "Data Visualization" },
				    { value: "deep-learning", label: "Deep Learning" },
				    { value: "desktop-applications", label: "Desktop Applications" },
				    { value: "digital-marketing", label: "Digital Marketing" },
				    { value: "digital-marketing-1", label: "Digital Marketing 1" },
				    { value: "diptrace", label: "Diptrace" },
				    { value: "django-framework", label: "Django Framework" },
				    { value: "dlib", label: "Dlib" },
				    { value: "docker", label: "Docker" },
				    { value: "e-commerce", label: "E-Commerce" },
				    { value: "electrical-engineer", label: "Electrical Engineer" },
				    { value: "english-proofreading", label: "English Proofreading" },
				    { value: "expressjs", label: "Express.Js" },
				    { value: "fast-ai", label: "Fast AI" },
				    { value: "fast-api", label: "Fast API" },
				    { value: "festo-fluidsim", label: "Festo Fluidsim" },
				    { value: "flask", label: "Flask" },
				    { value: "flyer-design", label: "Flyer Design" },
				    { value: "graphic-designing", label: "Graphic Designing" },
				    { value: "growth-hacking", label: "Growth Hacking" },
				    { value: "growth-marketing", label: "Growth Marketing" },
				    { value: "html-5", label: "HTML 5" },
				    { value: "ios-development", label: "iOS development" },
				    { value: "java-development", label: "Java development" },
				    { value: "java-script", label: "Java Script" },
				    { value: "jenkins", label: "Jenkins" },
				    { value: "lead-generation", label: "Lead Generation" },
				    { value: "linux", label: "Linux" },
				    { value: "machine-learning", label: "Machine Learning" },
				    { value: "magento-1", label: "Magento" },
				    { value: "matlab", label: "MATLAB" },
				    { value: "matlot-lib", label: "Matlot lib" },
				    { value: "mern-stack", label: "Mern Stack" },
				    { value: "microsoft", label: "Microsoft" },
				    { value: "microsoft-azure", label: "Microsoft Azure" },
				    { value: "microsoft-visual-studio-c", label: "Microsoft Visual Studio (C++)" },
				    { value: "mobile-app-development", label: "Mobile App Development" },
				    { value: "mongo-db", label: "Mongo DB" },
				    { value: "my-sql", label: "My SQL" },
				    { value: "nginx", label: "NGINX" },
				    { value: "node-js", label: "Node Js" },
				    { value: "numpi", label: "NumPi" },
				    { value: "open-cv", label: "Open CV" },
				    { value: "pandas", label: "Pandas" },
				    { value: "pcb-design", label: "PCB Design" },
				    { value: "php", label: "PHP" },
				    { value: "php-laravel-framework", label: "PHP Laravel Framework" },
				    { value: "poster-design", label: "Poster Design" },
				    { value: "project-management", label: "Project Management" },
				    { value: "proof-reading", label: "Proof Reading" },
				    { value: "proteus", label: "Proteus" },
				    { value: "python-1", label: "Python" },
				    { value: "qa", label: "QA" },
				    { value: "react-native", label: "React Native" },
				    { value: "reactjs", label: "React.Js" },
				    { value: "sales-force", label: "Sales Force" },
				    { value: "seo", label: "SEO" },
				    { value: "shopify-development", label: "Shopify Development" },
				    { value: "simulink", label: "Simulink" },
				    { value: "social-media-marketing", label: "Social Media Marketing" },
				    { value: "spreadsheets", label: "Spreadsheets" },
				    { value: "test", label: "TEST" },
				    { value: "tkinter", label: "Tkinter" },
				    { value: "translating", label: "Translating" },
				    { value: "unit-testing", label: "Unit Testing" },
				    { value: "unix", label: "Unix" },
				    { value: "user-experience-design", label: "User Experience Design" },
				    { value: "video-editing", label: "Video Editing" },
				    { value: "virtual-assistant", label: "Virtual Assistant" },
				    { value: "voice-talent", label: "Voice talent" },
				    { value: "web-applications", label: "Web Applications" },
				    { value: "website-design", label: "Website Design" },
				    { value: "wikipedia-contributor", label: "Wikipedia Contributor" },
				    { value: "wordpress-development", label: "WordPress Development" },
				    { value: "wordpress-plugin-development", label: "Wordpress Plugin Development" },
				    { value: "wordpress-theme-development", label: "Wordpress Theme Development" },
				    { value: "zendesk", label: "Zendesk" }
				    // Add more options as needed
				]

			    },
            ]
        };

        let currentQuestionIndex = 0;
        const messagesContainer = document.getElementById('messages-container');
        const answerButtonsContainer = document.getElementById('answer-buttons-container');
        const chatContainer = document.getElementById('chat-container');
        let userAnswers = {};

        const startupOptions = [
            { value: "freelancer", label: "I'm a Freelancer" },
            { value: "employer", label: "I'm hiring" }
        ];
		let isChatActive = false; 
		     const chatButton = document.getElementById('floating-button');

		// Hide messagesContainer initially
		chatContainer.style.display = 'none';

		chatButton.addEventListener('click', () => {
		    if (!isChatActive) {
		        // Show chatContainer and display options
		        chatContainer.style.display = 'block';
		        displayOptions(startupOptions);
		        isChatActive = true;
		    } else {
		        // Hide chatContainer and hide options
		        chatContainer.style.display = 'none';
		        hideOptions();
		        isChatActive = false;
		    }
		});

		
        // chatContainer.appendChild(chatButton);

        function displayOptions(options) {
            const message = document.createElement('div');
            message.classList.add('message', 'bot-message');
            message.textContent = "You are";
            messagesContainer.appendChild(message);

            answerButtonsContainer.innerHTML = '';

            options.forEach(option => {
                const button = document.createElement('button');
                button.classList.add('btn','btn-success');
                button.textContent = option.label;
                button.value = option.value;
                button.addEventListener('click', () => handleOptionSelect(option.value));
                answerButtonsContainer.appendChild(button);
            });
        }

        function handleOptionSelect(option) {
            userAnswers["role"] = option;
            currentQuestionIndex = 0;
            messagesContainer.innerHTML = '';
            answerButtonsContainer.innerHTML = '';

            const selectedRole = userAnswers["role"];
            const selectedQuestions = questions[selectedRole];

            displayQuestion(selectedQuestions[currentQuestionIndex]);
        }

function displayQuestion(question) {
  const message = document.createElement('div');
  message.classList.add('message', 'bot-message');
  message.textContent = question.text;
  messagesContainer.appendChild(message);

  answerButtonsContainer.innerHTML = '';

  const userAnswer = userAnswers[question.text];

  if (question.dropdown) {
    const dropdown = document.createElement('select');
    dropdown.classList.add('answer-dropdown');
    dropdown.addEventListener('change', (event) => handleAnswer(question, event.target.value));

    question.options.forEach(option => {
      const optionElement = document.createElement('option');
      optionElement.value = option.value;
      optionElement.textContent = option.label;
      dropdown.appendChild(optionElement);
    });

    if (userAnswer) {
      dropdown.value = userAnswer;
    }

    answerButtonsContainer.appendChild(dropdown);
  } else {
    question.options.forEach(option => {
      const button = document.createElement('button');
      button.classList.add('answer-button');
      button.textContent = option.label;
      button.value = option.value;
      button.addEventListener('click', () => handleAnswer(question, option.value));

      if (userAnswer === option.value) {
        button.classList.add('selected');
      }

      answerButtonsContainer.appendChild(button);
    });
  }
}

function handleAnswer(question, answer) {
  const currentRole = userAnswers["role"];
  const currentQuestions = questions[currentRole];

  userAnswers[question.text] = answer;

  const answerMessage = document.createElement('div');
  answerMessage.classList.add('message', 'user-message');
  if(answer == 'no'){

  	// chatContainer.style.display = 'none';
    hideOptions();
    displayOptions(startupOptions);
    // isChatActive = false;
    return false
  }
  answerMessage.textContent = `${answer}`;
  messagesContainer.appendChild(answerMessage);

  currentQuestionIndex++;

  if (currentQuestionIndex < currentQuestions.length) {
    displayQuestion(currentQuestions[currentQuestionIndex]);
  } else {
    callAPI();
  }
}
function hideOptions() {
		    // Clear the previous messages and answers
		    messagesContainer.innerHTML = '';
		    answerButtonsContainer.innerHTML = '';

		    // Reset the user answers and currentQuestionIndex
		    userAnswers = {};
		    currentQuestionIndex = 0;
		}
function callAPI() {
        	// alert('ddd');
			if(userAnswers['role'] == "freelancer"){
			   var skills = userAnswers['What skills you have'];
			    window.location.href = '{{ URL::to("/search-results") }}' + '?type=job&' + encodeURIComponent('skills[]') + '=' + skills;
			}else{
				var skills = userAnswers['What are the key skills you are looking in your candidate'];
				
			    window.location.href = '{{ URL::to("/search-results") }}' + '?type=freelancer&' + encodeURIComponent('skills[]') + '=' + skills;
			}



            // Replace the API endpoint with your actual API endpoint
            // fetch('{{ url("chatbot")}}', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json'
            //     },
            //     body: JSON.stringify(userAnswers)
            // })
            //     .then(response => response.json())
            //     .then(data => {
            //     	console.log(data);
            //         // Process the API response
            //         const message = document.createElement('div');
            //         // message.classList.add('message', 'bot-message');
            //         // message.textContent = data.message;
            //         // messagesContainer.appendChild(message);
            //     })
            //     .catch(error => {
            //         console.error('Error:', error);
            //     });
        }
    </script>
<script type="text/javascript">
window.addEventListener('load', function () {
// alert("It's loaded!")
var base_url = window.location.origin;
// alert(base_url)
var currentURL = $(location).attr('href');
if(currentURL === `${base_url}/#speed-up-process`) {

setTimeout(function() {
$('html,body').animate({
scrollTop: $("#scroll-id").offset().top - 100},
'slow');
}, 100);
}
})

// $(document).ready(function() {
// 	var base_url = window.location.origin;
// 	// alert(base_url)
// 	var currentURL = $(location).attr('href');
// 	if(currentURL === `${base_url}/#scroll-id`) {
// 		setTimeout(function() {
// 			$('html,body').animate({
// 			scrollTop: $("#scroll-id").offset().top},
// 			'slow');
// 		}, 2000);
// 	  }
// });

</script>
<!-- <script src="{{ asset('js/home.js') }}"></script> -->
<!-- <script src="{{ asset('js/app.js') }}"></script> -->
<script>
jQuery('#wt-loginbtn, .wt-loginheader a').on('click', function (event) {
event.preventDefault();
jQuery('.wt-loginarea .wt-loginformhold').slideToggle();
});
</script>


<script>
footer_element = $('main').hasClass('wt-innerbgcolor');
if(footer_element) {
$('.wt-footertwo').addClass('wt-innerbgcolor')
}
</script>
<script src="{{ asset('worketic/js/jquery.dd.min.js') }}"></script>

<script>
footer_element = $('main').hasClass('wt-innerbgcolor');
if(footer_element) {
$('.wt-footertwo').addClass('wt-innerbgcolor')
}
</script>
<script>
if(jQuery(".preloader-outer").length){

}
</script>

<script>

$(document).ready(function(){
$('button.navbar-toggler').click(function() {
$('#navbarNav').toggle();

});

$('button.catnavbarNav').click(function() {
$('#catnavbarNav').toggle();
$('#navbarNav').css('display','none');
});

});
</script>
<script>
$(window).scroll(function(){
if ($(this).scrollTop() > 400) {
$('#wt-header').addClass('newHeaderClass');
} else {
$('#wt-header').removeClass('newHeaderClass');
}
});
</script>



<!-- Load Facebook SDK for JavaScript -->
{{-- <div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
FB.init({
xfbml            : true,
version          : 'v7.0'
});
};

(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script> --}}


<!-- Your Chat Plugin code -->
{{-- <div class="fb-customerchat"
attribution=install_email
page_id="143435542479695"
theme_color="#7646FF">
</div> --}}
<!-- </div> -->
</body>
</html>
