@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ? 
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
@section('title'){{'Blog Listing' }} @stop
@section('content')
@php
    $show_blog_banner = 'true'
@endphp
    @if ($show_blog_banner == 'true')
        @php $breadcrumbs = Breadcrumbs::generate('searchResults'); @endphp
        <div class="wt-haslayout wt-innerbannerholder">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                        <div class="wt-innerbannercontent">
                            <div class="wt-title">
                                <h2>Blogs</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="wt-haslayout wt-main-section" id="blog">
    <div class="search-form">
              <search-form
                :placeholder="'{{ trans('lang.looking_for') }}'"
                :freelancer_placeholder="'{{ trans('lang.search_filter_list.freelancer') }}'"
                :employer_placeholder="'{{ trans('lang.search_filter_list.employers') }}'"
                :job_placeholder="'{{ trans('lang.search_filter_list.jobs') }}'"
                :service_placeholder="'{{ trans('lang.search_filter_list.services') }}'"
                :instructor_placeholder="'{{ trans('lang.search_filter_list.courses') }}'"
                :blog_placeholder="'{{ trans('lang.search_filter_list.blogs') }}'"
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
                            @if (file_exists(resource_path('views/extend/front-end/blogs/filters.blade.php'))) 
                                @include('extend.front-end.blogs.filters')
                            @else 
                                @include('front-end.blogs.filters')
                            @endif
                        </div>
                        <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left">
                            <div class="row">
                                <div class="wt-freelancers-holder la-freelancers-grid">
                                    @if (!empty($keyword))
                                        <div class="wt-userlistingtitle">
                                            <span>{{ trans('lang.01') }} {{$blogs->count()}} of {{$blogs_total_records}} results for <em>"{{{$keyword}}}"</em></span>
                                        </div>
                                    @endif
                                    @if (!empty($blogs) && $blogs->count() > 0)
                                        @foreach ($blogs as $blog)
                                            @php 
                                                
                                                $attachments = Helper::getUnserializeData($blog->attachments);
                                                $no_attachments = empty($attachments) ? 'la-service-info' : '';
                                                $enable_slider = !empty($attachments) ? 'wt-blogsslider' : '';
                                                
                                            @endphp
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 float-left">
                                                <div class="wt-freelancers-info {{$no_attachments}}">
                                                    @if (!empty($blog->editor_id))
                                                        @if (!empty($attachments))
                                                            @php $enable_slider = count($attachments) > 1 ? 'wt-freelancerslider owl-carousel' : ''; @endphp
                                                            <div class="wt-freelancers {{{$enable_slider}}}">
                                                                @foreach ($attachments as $attachment)
                                                                    <figure class="item">
                                                                        <a href="{{{ url('blog/'.$blog['slug']) }}}">
                                                                            <img src="{{{asset(Helper::getImageWithSize('uploads/blogs/'.$blog->id, $attachment, 'medium'))}}}" alt="img descriptions" class="item">
                                                                            <div class="blog-date"><h6> add blog date </h6></div>
                                                                            <div class="blog-category"><h6> add catagory </h6></div>
                                                                        </a>
                                                                    </figure>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="wt-freelancers">
                                                                <figure class="item">
                                                                    <a href="{{{ url('blog/'.$blog->slug) }}}"><img src="{{ asset('uploads/settings/general/imgae-not-availabe.png') }}" alt="img description" class="item"></a>
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
                                                   
                                                    <div class="wt-freelancers-details">
                                                        <!-- @if (empty($blog->editor_id))
                                                            <figure class="wt-freelancers-img">
                                                                <img src="{{ asset(Helper::getProfileImage($blog->editor_id)) }}" alt="img description">
                                                            </figure>
                                                        @else
                                                            <figure class="wt-freelancers-img">
                                                                <img src="{{ asset('uploads/settings/general/user.jpg') }}" alt="user-img">
                                                            </figure>
                                                        @endif -->
                                                        <div class="wt-freelancers-content">
                                                            <div class="dc-title">
                                                                @if ($blog->editor_id)
                                                                    {{-- <a href="{{{ url('profile/'.$blog->seller[0]->slug) }}}"><i class="fa fa-check-circle"></i> {{{Helper::getUserName($blog->seller[0]->id)}}}</a> --}}
                                                                @endif
                                                                <a href="{{{url('blog/'.$blog->slug)}}}"><h3>{{{$blog->title}}}</h3></a>
                                                                {{-- <span><strong>{{ (!empty($symbol['symbol'])) ? $symbol['symbol'] : '$' }}{{{$blog->price}}}</strong> </span> --}}
                                                            </div>
                                                            <div class="dc-discription">
                                                                <h6>Add description here</h6>
                                                            </div>
                                                        </div>
                                                        <div class="wt-freelancers-rating">
                                                            <button onclick="location.href='{{{url('blog/'.$blog->slug)}}}'" class="e-button e-button-primary blogs-read-more">READ MORE</button>
                                                            <!-- <ul>
                                                                <li><span><i class="fa fa-star"></i>Read More</span></li>
                                                                
                                                            </ul> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ( method_exists($blogs,'links') )
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 float-left">
                                                {{ $blogs->links('pagination.custom') }}
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
