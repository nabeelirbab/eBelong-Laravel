<html class="no-js" lang="" dir="ltr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		
		<title> eBelong : FREE Platform for talented freelancers</title>
		<meta name="description" content="eBelong is a platform that connects freelancers with talent hunters. eBelong is a FREE platform to help professionals to get the remote jobs specially at this time where remote job is the norm.">
		<meta name="keywords" content="freelancers, hire talent, get hired, ebelong">
		
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="apple-touch-icon" href="apple-touch-icon.png">
		{{-- <link rel="icon" href="http://amentotech.com/projects/worketic/" type="image/x-icon"> --}}
		<link rel="icon" href="{{{ asset(Helper::getSiteFavicon()) }}}" type="image/x-icon">
		<link href="{{ asset('worketic/css/app.css') }}" rel="stylesheet">
		{{-- <!--<link href="http://amentotech.com/projects/worketic/css/fontawesome/fontawesome-all.min.css" rel="stylesheet">
		<link href="http://amentotech.com/projects/worketic/css/font-awesome.min.css" rel="stylesheet"> --> --}}
		<link href="{{ asset('css/fontawesome/fontawesome-all.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/home.css') }}" rel="stylesheet">
		<!-- <link href="http://amentotech.com/projects/worketic/css/transitions.css" rel="stylesheet"> -->
		<link href="http://amentotech.com/projects/worketic/css/color.css" rel="stylesheet">

		<link href="{{asset('css/linearicons.css') }}" rel="stylesheet">
		<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

		{{-- <!-- <link href="http://amentotech.com/projects/worketic/css/linearicons.css" rel="stylesheet"> --> --}}	<link href="{{ asset('worketic/css/main.css') }}" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		
		<style>
			.wt-latestjobs > ul > li.deactivate{
				display:none;
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
		</style>
		<script type="text/javascript">
			var APP_URL = {!! json_encode(url('/')) !!}
			var readmore_trans = {!! json_encode(trans('lang.read_more')) !!}
			var less_trans = {!! json_encode(trans('lang.less')) !!}
			var Map_key = {!! json_encode(Helper::getGoogleMapApiKey()) !!}
			var APP_DIRECTION = {!! json_encode(Helper::getTextDirection()) !!}
		</script>
	</head>

	<body class="wt-login lang-en ltr ">
		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
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
										<a href="{{{ url('/') }}}"><!--<img src="{{{ asset($logo) }}}" alt="{{{ trans('Logo') }}}" style="height:30px;">--></a>
										<img src="{{ asset('uploads/settings/general/ebelong-logo-header.png') }}" alt="{{{ trans('Logo') }}}"  style="width:184px;">
									</strong>
									<strong class="wt-logo wt-logo-header mobile-logo" >
										<a href="{{{ url('/') }}}"><!--<img src="{{{ asset($logo) }}}" alt="{{{ trans('Logo') }}}" style="height:30px;">--></a>
										<img src="{{ asset('uploads/settings/general/ebelong-mobile-logo.png') }}" alt="{{{ trans('Logo') }}}">
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
														<?php if($user_role == 'guest'): ?>
														<li style="order: 2;">
															<a href="{{url('search-results?type=freelancer')}}">
																{{{ trans('lang.view_freelancers') }}}
															</a>
														</li>
														<li style="order: 4;">
															<a href="{{url('search-results?type=job')}}">
																{{{ trans('lang.browse_jobs') }}}
															</a>
														</li>
														<li style="order: 5;">
															<a href="{{url('search-results?type=service')}}">
																{{{ trans('lang.browse_services') }}}
															</a>
														</li>
														<?php elseif($user_role == 'admin'): ?>
														<li style="order: 2;">
															<a href="{{url('search-results?type=freelancer')}}">
																{{{ trans('lang.view_freelancers') }}}
															</a>
														</li>
														<li style="order: 4;">
															<a href="{{url('search-results?type=job')}}">
																{{{ trans('lang.browse_jobs') }}}
															</a>
														</li>
														<li style="order: 5;">
															<a href="{{url('search-results?type=service')}}">
																{{{ trans('lang.browse_services') }}}
															</a>
														</li>
														<?php elseif($user_role == 'employer'): ?>
														<li style="order: 2;">
															<a href="{{url('search-results?type=freelancer')}}">
																{{{ trans('lang.view_freelancers') }}}
															</a>
														</li>
														<li style="order: 5;">
															<a href="{{url('search-results?type=service')}}">
																{{{ trans('lang.browse_services') }}}
															</a>
														</li>		
														<?php elseif($user_role == 'freelancer'): ?>
														<li style="order: 4;">
															<a href="{{url('search-results?type=job')}}">
																{{{ trans('lang.browse_jobs') }}}
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
											<a href="{{{ route('register') }}}" class="wt-btn">{{{ trans('lang.join_now') }}}</a>
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
													<span>{{{ !empty(Auth::user()->profile->tagline) ? str_limit(Auth::user()->profile->tagline, 26, '') : Helper::getAuthRoleName() }}}</span>
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
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6">
								<div class="section-main-wrapper10">
									<div class="wt-banner">
										<div data-vue='{}' data-component="BannerContent" id="e-banner-content"></div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6">
								<img class="home-banner-img1" src="{{ asset('uploads/settings/general/FreelancerNew.png') }}" alt="banner here"> 
							</div>
						</div>
					</div>
				</div>
				<div class="custom-mobile">
					<div class="custome-home-banner">
						<div class="container">
							<div class="row">
								<div class="col-sm-12">
									<img class="home-banner-img1" src="{{ asset('uploads/settings/general/FreelancerNew.png') }}" alt="banner here"> 
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
											<div data-vue='{}' data-component="BannerContent" id="e-banner-content"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <img class="home-banner-img" src="{{ asset('uploads/settings/general/home_banner.png') }}" alt="banner here">  -->
				
				<div data-component="Slider" data-vue='<?php echo json_encode($freelancers);?>' id="e-freelancer"></div>
				<div data-component="BannerJob" data-vue='{}'  id="e-banner-job" ></div>
				<div data-component="PostSkill" data-vue='<?php echo json_encode(array('categories'=> $categories,'skills'=>$all_skills)) ?>' id="e-postskill"></div>
				@auth
					<div data-component="PostJob" data-vue='<?php echo json_encode($user);?>'  id="e-postjob"></div>
				@endauth
				@guest
					<div data-component="PostJob" data-vue='{}'  id="e-postjob"></div>
				@endguest
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
				<footer id="wt-footer" class="wt-footerholder wt-footertwo wt-haslayout">
				<!-- <div class="wt-footer-bg" style="background-image:url()"></div -->
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
								<button onclick="location.href='/search-results?type=freelancer'" class="e-button e-button-primary">Hire Now</button>
								<button onclick="location.href='/search-results?type=job'" class="e-button e-button-primary my-3">Get Work</a></button>
							</div>
					
							@php
								$footer = \App\SiteManagement::getMetaValue('footer_settings');
								$search_menu = \App\SiteManagement::getMetaValue('search_menu');
								$menu_title = DB::table('site_managements')->select('meta_value')->where('meta_key', 'menu_title')->get()->first();
							@endphp
							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="row">
									<div class="col-sm-12 col-md-4 col-lg-4">
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
									<div class="col-sm-12 col-md-4 col-lg-4">
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
									<div class="col-sm-12 col-md-4 col-lg-4">
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
									<p class="wt-copyrights">Copyright © 2021 eBelong, All Right Reserved eBelong</p>
									<nav class="wt-addnav">
										<ul>
										<!--<li><a href="http://amentotech.com/projects/worketic/page/about-us">About Us</a></li>
											<li><a href="http://amentotech.com/projects/worketic/page/privacy-policy">Privacy Policy</a></li> -->
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
		
		</script>
		
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
		<div id="fb-root"></div>
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
		</script>


		<!-- Your Chat Plugin code -->
		<div class="fb-customerchat"
		attribution=install_email
		page_id="143435542479695"
		theme_color="#7646FF">
		</div>
		</div>
	</body>
</html>
