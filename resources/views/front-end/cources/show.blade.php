@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ?
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
@section('title'){{ $cource->title }} @stop
@section('description', "$cource->description")
@php $i =0;@endphp
@if($attachments)
@foreach ($attachments as $attachment)
@php $i++; @endphp
@if($i==1)
@section('og_image', asset(Helper::getImageWithSize('uploads/courses/'.$seller->id, $attachment, 'medium')))
@endif
@endforeach
@endif
@section('og_url', env('APP_URL').'/course/'.$cource->slug)
@section('og_title', $cource->title)
@section('og_desc', htmlspecialchars_decode(stripslashes($cource->description)))
@section('content')
{{-- <head>
    @foreach ($attachments as $attachment)
    <meta property="og:image" content="{{ asset(Helper::getImageWithSize('uploads/courses/'.$seller->id, $attachment, '')) }}"/>
    @endforeach
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="630"/>
	<meta property="og:title" content="{{ $cource->title }}"/>
	<meta property="og:type" content="article"/>
	<meta property="og:url" content="https://dev.ebelong.com/course/after-effects"/>
 </head> --}}
    @php $breadcrumbs = Breadcrumbs::generate('CourceDetail', $cource->slug); @endphp
    <div class="wt-haslayout wt-innerbannerholder">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                    <div class="wt-innerbannercontent">
                    <div class="wt-title"><h2>{{ trans('lang.Cource_detail') }}</h2></div>
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
    <div class="wt-haslayout wt-main-section" id="cources">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @elseif (Session::has('error'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <div id="wt-twocolumns" class="wt-twocolumns wt-haslayout">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left">
                        <div class="wt-usersingle wt-servicesingle-holder">
                            <div class="wt-servicesingle">
                                @if ($cource->is_featured == 'true')
                                    <span class="wt-featuredtagvtwo">{{ trans('lang.featured') }}</span>
                                @endif
                                {{--  <span class="wt-featuredtagvtwo">Featured</span>  --}}
                                <div class="wt-servicesingle-title">
                                    <div class="wt-title">
                                        @if (!empty($cource->title))
                                            <h2>{{{ $cource->title }}}</h2>
                                        @endif
                                    </div>
                                    <ul class="wt-userlisting-breadcrumb">
                                        <li>
                                            <span>
                                                <i class="fa fa-star"></i>
                                                {{{ $rating }}}/<i>5</i>&nbsp;({{{ !empty($reviews) ? $reviews->count() : ''}}} {{ trans('lang.feedbacks') }})
                                            </span>
                                        </li>
                                        <li>
                                            {{-- <span>
                                                @if ($total_orders > 0)
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                @endif
                                                {{{$total_orders}}} {{ trans('lang.in_queue') }}
                                            </span> --}}
                                        </li>
                                    </ul>
                                </div>
                                @if (!empty($attachments))
                                    @php $enable_slider = count($attachments) > 1 ? 'wt-servicesslider' : ''; @endphp
                                    <div class="wt-freelancers-info">
                                        <div id="{{$enable_slider}}" class="wt-servicesslider owl-carousel">
                                            @foreach ($attachments as $attachment)
                                                <figure class="item">
                                                    <img src="{{{asset(Helper::getImageWithSize('uploads/courses/'.$seller->id, $attachment, 'medium'))}}}" alt="img description" class="item">
                                                </figure>
                                            @endforeach
                                        </div>
                                        @if (count($attachments) > 1)
                                            <div id="wt-servicesgallery" class="wt-servicesgallery owl-carousel">
                                                @foreach ($attachments as $attachment)
                                                    @php $image = 'uploads/courses/'.$seller->id.'/'.$attachment; @endphp
                                                    <div class="item"><figure><img src="{{{asset($image)}}}" alt="img description"></figure></div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="wt-service-details">
                                    @if (!empty($cource->description))
                                        <div class="wt-description course-detail-description">
                                            @php echo htmlspecialchars_decode(stripslashes($cource->description)); @endphp
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="wt-clientfeedback">
                                @if (!empty($reviews) && $reviews->count() != 0)
                                <div class="wt-usertitle wt-titlewithselect">
                                    <h2>{{ trans('lang.reviews') }}</h2>
                                </div>
                                    @foreach ($reviews as $key => $review)
                                        @php
                                            $user = App\User::find($review->user_id);
                                            $stars  = $review->avg_rating != 0 ? $review->avg_rating/5*100 : 0;
                                        @endphp
                                        <div class="wt-userlistinghold wt-userlistingsingle">
                                                <figure class="wt-userlistingimg">
                                                    <img src="{{ asset(Helper::getProfileImage($review->user_id)) }}" alt="{{{ trans('Employer') }}}">
                                                </figure>
                                                <div class="wt-userlistingcontent">
                                                    <div class="wt-contenthead">
                                                        <div class="wt-title">
                                                            <a href="{{{ url('profile/'.$user->slug) }}}">@if ($user->user_verified == 1)<i class="fa fa-check-circle"></i>@endif {{{ Helper::getUserName($review->user_id) }}}</a>
                                                            <h3>{{{ $cource->title }}}</h3>
                                                        </div>
                                                        <ul class="wt-userlisting-breadcrumb">
                                                            @if (!empty($cource->location))
                                                                <li>
                                                                    <span>
                                                                        <img src="{{{asset(Helper::getLocationFlag($cource->location->flag))}}}" alt="{{{ trans('lang.flag_img') }}}"> {{{ $cource->location->title }}}
                                                                    </span>
                                                                </li>
                                                            @endif
                                                            <li><span><i class="far fa-calendar"></i> {{ Carbon\Carbon::parse($cource->created_at)->format('M Y') }} - {{ Carbon\Carbon::parse($cource->updated_at)->format('M Y') }}</span></li>
                                                            <li>
                                                                <span class="wt-stars"><span style="width: {{ $stars }}%;"></span></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="wt-description">
                                                    @if (!empty($review->feedback))
                                                        <p>“ {{{ $review->feedback }}} ”</p>
                                                    @endif
                                                </div>
                                            </div>
                                    @endforeach
                                {{-- @else
                                    <div class="wt-userprofile">
                                        @if (file_exists(resource_path('views/extend/errors/no-record.blade.php')))
                                            @include('extend.errors.no-record')
                                        @else
                                            @include('errors.no-record')
                                        @endif
                                    </div> --}}
                                @endif
                            </div>
                        </div>
                        @if(Auth::user())
                        @if($cource->course_files)
                        <a href="{{{ s3_base_url(). $cource->course_files }}}" class="wt-btn" target="_blank">View File</a>
                        @endif
                        @if($cource->additional_text)
                        <div class="wt-description course-detail-description">
                            @php echo htmlspecialchars_decode(stripslashes($cource->additional_text)); @endphp
                        </div>

                        @endif
                        @endif

                        @if(Auth::user() && $boughtcourse == true || $waiting_status == true)
                        @if($cource->course_files_bought)
                        <a href="{{{ s3_base_url().$cource->course_files_bought }}}" class="wt-btn">View File</a>
                        @endif
                        @if($cource->additional_text_bought)
                        <div class="wt-description course-detail-description">
                            @php echo htmlspecialchars_decode(stripslashes($cource->additional_text_bought)); @endphp
                        </div>

                        @endif
                        @endif

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 float-left">
                        @if (file_exists(resource_path('views/extend/front-end/cources/sidebar/index.blade.php')))
                            @include('extend.front-end.cources.sidebar.index')
                        @else
                            @include('front-end.cources.sidebar.index')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
        @push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkCYdMuRkyApHONAWqjzNYYvYX2INz-nM&libraries=places&callback=initMap" async defer></script>

<script>
    function initMap() {
        // Create a map object
        var laat = @json($cource->latitude);
        var lnng = @json($cource->longitude);
        console.log(laat);
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 2, // Set the initial zoom level
            center: { lat:laat, lng:lnng } // Set the initial center point
        });

        // Create a marker and set its position
        var marker = new google.maps.Marker({
            position: { lat:laat, lng:lnng },
            map: map
        });

        // Create an info window to display the address
        var infoWindow = new google.maps.InfoWindow({
            content: '{{ $cource->address }}'
        });

        // Attach the info window to the marker
        marker.addListener('click', function() {
            infoWindow.open(map, marker);
        });
    }
</script>


 @endpush
    <script>
        /* SERVICE SLIDER */
        function customerFeedback(){
            var sync1 = jQuery('#wt-servicesslider');
            var sync2 = jQuery('#wt-servicesgallery');
            var slidesPerPage = 3;
            var syncedSecondary = true;
            sync1.owlCarousel({
                items : 1,
                loop: true,
                nav: false,
                dots: false,
                autoplay: false,
                slideSpeed : 2000,
                navClass: ['wt-prev', 'wt-next'],
                navContainerClass: 'wt-search-slider-nav',
                navText: ['<span class="lnr lnr-chevron-left"></span>', '<span class="lnr lnr-chevron-right"></span>'],
                responsiveRefreshRate : 200,
            }).on('changed.owl.carousel', syncPosition);

            sync2.on('initialized.owl.carousel', function () {
                sync2.find(".owl-item").eq(0).addClass("current");
            })

            .owlCarousel({
                // items : slidesPerPage,
                items:8,
                dots: false,
                nav: false,
                margin:10,
                smartSpeed: 200,
                slideSpeed : 500,
                slideBy: slidesPerPage,
                responsiveRefreshRate : 100,
            }).on('changed.owl.carousel', syncPosition2);

            function syncPosition(el) {
                var count = el.item.count-1;
                var current = Math.round(el.item.index - (el.item.count/2) - .5);
                if(current < 0) {
                    current = count;
                }
                if(current > count) {
                    current = 0;
                }
                sync2.find(".owl-item").removeClass("current").eq(current).addClass("current")
                var onscreen = sync2.find('.owl-item.active').length - 1;
                var start = sync2.find('.owl-item.active').first().index();
                var end = sync2.find('.owl-item.active').last().index();
                if (current > end) {
                    sync2.data('owl.carousel').to(current, 100, true);
                }
                if (current < start) {
                    sync2.data('owl.carousel').to(current - onscreen, 100, true);
                }
            }
            function syncPosition2(el) {
                if(syncedSecondary) {
                    var number = el.item.index;
                    sync1.data('owl.carousel').to(number, 100, true);
                }
            }
            sync2.on("click", ".owl-item", function(e){
                e.preventDefault();
                var number = jQuery(this).index();
                sync1.data('owl.carousel').to(number, 300, true);
            });
        }
        customerFeedback();
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
        })
    </script>
@endpush
