@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ? 
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
@section('title'){{'Course Listing' }} @stop
@section('description', $service_list_meta_desc)
@section('content')
@php
    $show_service_banner = 'true'
@endphp
    @if ($show_service_banner == 'true')
        @php $breadcrumbs = Breadcrumbs::generate('searchResults'); @endphp
        <div class="wt-haslayout wt-innerbannerholder" style="background-image:url({{{ asset(Helper::getBannerImage($service_inner_banner, 'uploads/settings/general')) }}})">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                        <div class="wt-innerbannercontent">
                            <div class="wt-title">
                                <h2>Courses</h2>
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
    <div class="wt-haslayout wt-main-section" id="services">
    <div class="search-form">
              <search-form
                :placeholder="'{{ trans('lang.looking_for') }}'"
                :freelancer_placeholder="'{{ trans('lang.search_filter_list.freelancer') }}'"
                :employer_placeholder="'{{ trans('lang.search_filter_list.employers') }}'"
                :job_placeholder="'{{ trans('lang.search_filter_list.jobs') }}'"
                :service_placeholder="'{{ trans('lang.search_filter_list.services') }}'"
                :instructor_placeholder="'{{ trans('lang.search_filter_list.courses') }}'"
                :no_record_message="'{{ trans('lang.no_record') }}'"
                >
                </search-form>
        </div>
        @if (Session::has('payment_message'))
            @php $response = Session::get('payment_message') @endphp
            <div class="flash_msg">
                <flash_messages :message_class="'{{{$response['code']}}}'" :time ='5' :message="'{{{ $response['message'] }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <div class="wt-haslayout">
            <div class="container">
                <div class="row">
                    <div id="wt-twocolumns" class="wt-twocolumns wt-haslayout">
						<div class="filter_icon btn btn-success"><i class="fa fa-filter"></i>Filter</div> 
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-4 filter-page float-left">
                            @if (file_exists(resource_path('views/extend/front-end/cources/filters.blade.php'))) 
                                @include('extend.front-end.cources.filters')
                            @else 
                                @include('front-end.cources.filters')
                            @endif
                        </div>
                        <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left">
                            <div class="row">
                                <div class="wt-freelancers-holder la-freelancers-grid">
                                    @if (!empty($keyword))
                                        <div class="wt-userlistingtitle">
                                            <span>{{ trans('lang.01') }} {{$services->count()}} of {{$services_total_records}} results for <em>"{{{$keyword}}}"</em></span>
                                        </div>
                                    @endif
                                    @if (!empty($services) && $services->count() > 0)
                                        @foreach ($services as $service)
                                            @php 
                                                $service_reviews = $service->seller->count() > 0 ? Helper::getCourceReviews($service->seller[0]->id, $service->id) : ''; 
                                                $service_rating=0;
                                                if(!empty($service_reviews)) {
                                                    $service_rating = $service_reviews->sum('avg_rating') != 0 ? round($service_reviews->sum('avg_rating') / $service_reviews->count()) : 0;
                                                }
                                                $attachments = Helper::getUnserializeData($service->attachments);
                                                $no_attachments = empty($attachments) ? 'la-service-info' : '';
                                                $enable_slider = !empty($attachments) ? 'wt-servicesslider' : '';
                                                $total_orders = Helper::getCourceCount($service->id,'bought');
                                            @endphp
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 float-left">
                                                <div class="wt-freelancers-info {{$no_attachments}}">
                                                    @if ($service->seller->count() > 0)
                                                        @if (!empty($attachments))
                                                            @php $enable_slider = count($attachments) > 1 ? 'wt-freelancerslider owl-carousel' : ''; @endphp
                                                            <div class="wt-freelancers {{{$enable_slider}}}">
                                                                @foreach ($attachments as $attachment)
                                                                    <figure class="item">
                                                                        <a href="{{{ url('course/'.$service->slug) }}}"><img src="{{{asset(Helper::getImageWithSize('uploads/courses/'.$service->seller[0]->id, $attachment, 'medium'))}}}" alt="img descriptions" class="item"></a>
                                                                    </figure>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="wt-freelancers">
                                                                <figure class="item">
                                                                    <a href="{{{ url('course/'.$service->slug) }}}"><img src="{{ asset('uploads/settings/general/imgae-not-availabe.png') }}" alt="img description" class="item"></a>
                                                                </figure>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="wt-freelancers">
                                                            <figure class="item">
                                                                <a href="javascript:void(0)"><img src="{{ asset('uploads/settings/general/imgae-not-availabe.png') }}" alt="img description" class="item"></a>
                                                            </figure>
                                                        </div>
                                                    @endif
                                                    @if ($service->is_featured == 'true')
                                                        <span class="wt-featuredtagvtwo">{{ trans('lang.featured') }}</span>
                                                    @endif
                                                    <div class="wt-freelancers-details">
                                                        @if ($service->seller->count() > 0)
                                                            <figure class="wt-freelancers-img">
                                                                <img src="{{ asset(Helper::getProfileImage($service->seller[0]->id)) }}" alt="img description">
                                                            </figure>
                                                        @else
                                                            <figure class="wt-freelancers-img">
                                                                <img src="{{ asset('uploads/settings/general/user.jpg') }}" alt="user-img">
                                                            </figure>
                                                        @endif
                                                        <div class="wt-freelancers-content">
                                                            <div class="dc-title">
                                                                @if ($service->seller->count() > 0)
                                                                    <a href="{{{ url('profile/'.$service->seller[0]->slug) }}}"><i class="fa fa-check-circle"></i> {{{Helper::getUserName($service->seller[0]->id)}}}</a>
                                                                @endif
                                                                <a href="{{{url('course/'.$service->slug)}}}"><h3>{{{$service->title}}}</h3></a>
                                                                <span><strong>{{ (!empty($symbol['symbol'])) ? $symbol['symbol'] : '$' }}{{{$service->price}}}</strong> </span>
                                                            </div>
                                                        </div>
                                                        <div class="wt-freelancers-rating">
                                                            <ul>
                                                                <li><span><i class="fa fa-star"></i>{{{ $service_rating }}}/<i>5</i> ({{{!empty($service_reviews) ? $service_reviews->count() : ''}}})</span></li>
                                                                <li>
                                                                    @if ($total_orders > 0)
                                                                        <i class="fa fa-spinner fa-spin"></i>
                                                                    @endif
                                                                    {{{$total_orders}}} {{ trans('lang.in_queue') }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ( method_exists($services,'links') )
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 float-left">
                                                {{ $services->links('pagination.custom') }}
                                            </div>
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
            </div>
        </div>
    </div>
    @endsection
@push('scripts')
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
  
    <script>
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
    </script>
@endpush
