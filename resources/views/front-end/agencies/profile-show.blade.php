@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ?
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
{{--@section('title'){{ $agency_name }} | {{ $tagline }} @stop--}}
{{--@section('description', "$desc")--}}
@section('content')
    <div class="wt-haslayout wt-innerbannerholder wt-innerbannerholdervtwo" style="">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                </div>
            </div>
        </div>
    </div>
    <div class="wt-main-section wt-paddingtopnull wt-haslayout la-profile-holder" id="user_profile">
        <div class="preloader-section" v-if="loading" v-cloak>
            <div class="preloader-holder">
                <div class="loader"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 float-left">
                    <div class="wt-userprofileholder">
                        @if (!empty($badge) && !empty($enable_package) && $enable_package === 'true')
                            <span class="wt-featuredtag" style="border-top: 40px solid {{ $badge_color }};">
                                <img src="{{{ 'asset(Helper::getBadgeImage($badge_img))' }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style">
                            </span>
                        @endif
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 float-left">
                            <div class="row">
                                <div class="wt-userprofile">
                                    <!-- please add if condition for agency logo  -->
                                    @if (empty($agency['agency_logo']))
                                        <figure><img src="{{{ 'https://ebelongmaster-1517a.kxcdn.com/uploads/settings/general/imgae-not-availabe.png' }}}" alt="{{{ trans('lang.user_avatar') }}}"></figure>
                                    <!-- \--- -->
                                    @else
                                    <figure><img src="{{{asset('/uploads/agency_logos/'.$agency['id'].'/'.$agency['agency_logo'] )}}}" alt="{{{ trans('lang.user_avatar') }}}"></figure>

                                    @endif
                                    <div class="wt-title">
                                        @if (!empty($agency['is_verified']))
                                            <h3>@if ($agency['is_verified'] === 1)<i class="fa fa-check-circle"></i> @endif {{{ $agency['agency_name'] }}}</h3>
                                        @endif
                                        <span>
                                            <div> Agency Created by <h4>{{  Helper::getUserName($agency['user_id'])}}</h4></div>
                                            {{-- <div class="wt-proposalfeedback"><span class="wt-starcontent"> {{{ 5 }}}/<i>5</i>&nbsp;<em>({{{ 100 }}} {{ trans('lang.feedbacks') }})</em></span></div> --}}
                                            @if (!empty($agency['created_at']))
                                                {{{ 'Agency since: ' }}}&nbsp;{{{ $agency['created_at'] }}}
                                            @endif
                                            <br>
                                            <a href="{{url('profile/'.$agency['slug'])}}">{{ '@' }}{{{ $agency['slug'] }}}</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-9 float-left">
                            <div class="row">
                                <div class="wt-proposalhead wt-userdetails">
                                    <!-- please add agency name condition -->
                                    <h2> {{  $agency['agency_name']}}</h2>
                                    <!-- ----- -->
                                    <ul class="wt-userlisting-breadcrumb wt-userlisting-breadcrumbvtwo">
                                        @if (!empty($agency['hourly_rates_min'] && $agency['hourly_rates_max']))
                                            <li><span><i class="far fa-money-bill-alt"></i> {{ '$' }}{{{ $agency['hourly_rates_min'] .' - '. $agency['hourly_rates_max'] }}} {{{ trans('lang.per_hour') }}}</span></li>
                                        @endif
                                        @if (!empty($agency['agency_name']))
                                            <li>
                                                <span>
{{--                                                    <img src="{{{asset(Helper::getLocationFlag($agency->location->flag))}}}" alt="{{{ trans('lang.flag_img') }}}"> {{{ $agency->location->title }}}--}}
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                    @if (!empty($agency['description']))
                                        <div class="wt-description">
                                            <p>{{{ $agency['description'] }}}</p>
                                        </div>
                                    @endif

                                </div>
                                <div id="wt-statistics" class="wt-statistics wt-profilecounter">
                                    <div class="wt-statisticcontent wt-countercolor2">
                                        <h3 data-from="0" data-to="{{{ $agency['total_hours'] }}}" data-speed="8000" data-refresh-interval="100">{{{ $agency['total_hours'] }}}</h3>
                                        <h4>{{ 'Total Hours' }}</h4>
                                    </div>
                                    <div class="wt-statisticcontent wt-countercolor4">
                                        <h3 data-from="0" data-to="{{{ $agency['total_jobs'] }}}" data-speed="800" data-refresh-interval="02">{{{$agency['total_jobs'] }}}</h3>
                                        <h4>{{ 'Total Jobs' }}</h4>
                                    </div>
                                    <div class="wt-statisticcontent wt-countercolor3">
                                        <h3 data-from="0" data-to="{{ $agency['total_earnings'] }}" data-speed="8000" data-refresh-interval="100">{{ $agency['total_earnings'] }}</h3>
                                        <h4>{{ trans('lang.total_earnings') }}</h4>
                                    </div>
                                    <div class="wt-statisticcontent wt-countercolor1">
                                        <h3 data-from="0" data-to="{{ $agency['agency_size'] }}" data-speed="8000" data-refresh-interval="100">{{ $agency['agency_size'] }}</h3>
                                        <h4>{{ 'Agency Size' }}</h4>
                                    </div>
                                     <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 float-left"> -->
                                    <aside id="wt-sidebar" class="wt-sidebar">
                                        <div id="wt-ourskill" class="wt-widget" style="text-align: left;">
                                            <div class="wt-widgettitle">
                                                <h2>{{ 'Agency Skills' }}</h2>
                                            </div>
                                            @if (!empty($skills) && $skills->count() > 0)
                                                <div class="wt-widgetcontent wt-skillscontent" style="text-align: left;">
                                                    @foreach ($skills as $skill)
                                                        <div class="wt-skillholder" data-percent="{{{ $skill->pivot->skill_rating }}}%">
                                                            <span>{{{ $skill->title }}} <em>{{{ $skill->pivot->skill_rating }}}%</em></span>
                                                            <div class="wt-skillbarholder"><div class="wt-skillbar"></div></div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p>{{ trans('lang.no_skills') }}</p>
                                            @endif
                                        </div>
                                    </aside>
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('js/readmore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/countTo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/appear.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script>
        /* FREELANCERS SLIDER */
        var _wt_freelancerslider = jQuery('.wt-freelancerslider')
        _wt_freelancerslider.owlCarousel({
            items: 1,
            loop:true,
            nav:true,
            margin: 0,
            autoplay:false,
            navClass: ['wt-prev', 'wt-next'],
            navContainerClass: 'wt-search-slider-nav',
            navText: ['<span class="lnr lnr-chevron-left"></span>', '<span class="lnr lnr-chevron-right"></span>'],
        });

        $('#wt-ourskill').appear(function () {
            jQuery('.wt-skillholder').each(function () {
                jQuery(this).find('.wt-skillbar').animate({
                    width: jQuery(this).attr('data-percent')
                }, 2500);
            });
        });
        var popupMeta = {
            width: 400,
            height: 400
        }
        $(document).on('click', '.social-share', function(event){
            event.preventDefault();

            var vPosition = Math.floor(($(window).width() - popupMeta.width) / 2),
                hPosition = Math.floor(($(window).height() - popupMeta.height) / 2);

            var url = $(this).attr('href');
            var popup = window.open(url, 'Social Share',
                'width='+popupMeta.width+',height='+popupMeta.height+
                ',left='+vPosition+',top='+hPosition+
                ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

            if (popup) {
                popup.focus();
                return false;
            }
        });
    </script>
@endpush

