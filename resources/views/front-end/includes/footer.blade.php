
@if( Schema::hasTable('site_managements'))
    @php
        $footer = \App\SiteManagement::getMetaValue('footer_settings');
        $search_menu = \App\SiteManagement::getMetaValue('search_menu');
        $menu_title = DB::table('site_managements')->select('meta_value')->where('meta_key', 'menu_title')->get()->first();
    @endphp
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
						<div>
						<button onclick="location.href='/search-results?type=freelancer'" class="e-button e-button-primary">Hire Now</button>
						<button onclick="location.href='/search-results?type=job'" class="e-button e-button-primary my-3">Get Work</a></button>
						</div>
					</div>
				</div>
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
									<h3>Explore More</h3> </div>
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
						<div class="other-link"><a href="">Terms & Conditions</a></div>
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
@endif
    <!-- @if( Schema::hasTable('site_managements'))
    @php
        $footer = \App\SiteManagement::getMetaValue('footer_settings');
        $search_menu = \App\SiteManagement::getMetaValue('search_menu');
        $menu_title = DB::table('site_managements')->select('meta_value')->where('meta_key', 'menu_title')->get()->first();
    @endphp
    <footer id="wt-footer" class="wt-footer wt-haslayout">
        @if (!empty($footer))
            <div class="wt-footerholder wt-haslayout">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="wt-footerlogohold">
                                @if (!empty($footer['footer_logo']))
                                    <strong class="wt-logo"><a href="{{{ url('/') }}}"><img src="{{{ asset(\App\Helper::getFooterLogo($footer['footer_logo'])) }}}" alt="company logo here"></a></strong>
                                @endif
                                @if (!empty($footer['description']))
                                    <div class="wt-description">
                                        <p>Hire professionals for any job, anytime, anywhere</p>
                                    </div>
                                @endif
                                @php Helper::displaySocials(); @endphp
                            </div>
                        </div>
                        @if (!empty($footer['menu_title_1']) || !empty($footer['menu_pages_1']))
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="wt-footercol wt-widgetcompany">
                                    @if (!empty($footer['menu_title_1']))
                                        <div class="wt-fwidgettitle">
                                            <h3>{{{ $footer['menu_title_1'] }}}</h3>
                                        </div>
                                    @endif
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
                        @endif
                        @if (!empty($search_menu) || !empty($menu_title))
                            <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="wt-footercol wt-widgetcompany">
                                    @if (!empty($menu_title))
                                        <div class="wt-fwidgettitle">
                                            <h3>{{ $menu_title->meta_value }}</h3>
                                        </div>
                                    @endif
                                    <ul class="wt-fwidgetcontent">
                                        @foreach($search_menu as $key => $page)
                                            <li><a href="{!! url($page['url']) !!}">{{$page['title']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        <div class="wt-haslayout wt-footerbottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p class="wt-copyrights">
                            <span>Copyright © 2020 Ebelong, All Right Reserved Ebelong</p>
                        @if(!empty($footer['pages']))
                            <nav class="wt-addnav">
                                <ul>
                                    @foreach($footer['pages'] as $menu_page)
                                        @php $page = \App\Page::where('id', $menu_page)->first(); @endphp
                                        @if (!empty($page))
                                            <li><a href="{{{ url('page/'.$page->slug) }}}">{{{ $page->title }}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endif -->
