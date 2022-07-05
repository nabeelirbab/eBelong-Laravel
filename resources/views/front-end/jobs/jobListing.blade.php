@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ? 
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@section('title'){{ $job_list_meta_title }} @stop
@section('description', $job_list_meta_desc)
@section('content')
@php
    $show_job_banner = 'true'
@endphp
    @if ($show_job_banner == 'true')
        @php $breadcrumbs = Breadcrumbs::generate('searchResults'); @endphp
        <div class="wt-haslayout wt-innerbannerholder" style="background-image:url({{{ asset(Helper::getBannerImage($job_inner_banner, 'uploads/settings/general')) }}})">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-6 push-lg-3">
                        <div class="wt-innerbannercontent">
                            <div class="wt-title" id = "jobs">
                                <h1>Jobs</h1>
                                <div class="search-form jobListingPage">
                                    <search-form
                                      :placeholder="'{{ trans('lang.looking_for') }}'"
                                      :freelancer_placeholder="'{{ trans('lang.search_filter_list.freelancer') }}'"
                                      :employer_placeholder="'{{ trans('lang.search_filter_list.employers') }}'"
                                      :job_placeholder="'{{ trans('lang.search_filter_list.jobs') }}'"
                                      :service_placeholder="'{{ trans('lang.search_filter_list.services') }}'"
                                      :no_record_message="'{{ trans('lang.no_record') }}'"
                                      >
                                      </search-form>
                              </div>
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
    </div>
    @endif
    <div  >
    <div class="wt-haslayout wt-main-section jobListing">
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
                            @if (file_exists(resource_path('views/extend/front-end/jobs/filters.blade.php'))) 
                                @include('extend.front-end.jobs.filters')
                            @else 
                                @include('front-end.jobs.filters')
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-8 float-left jobforhidingpadingleft">
                            <!-- ==================== List View========================= -->
                            <div class="wt-userlistingholder wt-haslayout" id="list-layout">
                                @if (!empty($keyword))
                                    <div class="wt-userlistingtitle">
                                        <span>{{ trans('lang.01') }}  results for <em>"{{{$keyword}}}"</em></span>
                                    </div>
                                @endif
                                @if (!empty($jobs && $jobs->count() > 0))
                                    @foreach ($jobs as $job)
                                        @if (\Schema::hasColumn('jobs', 'expiry_date') && !empty($job->expiry_date))
                                            @php $expiry = Carbon\Carbon::parse($job->expiry_date); @endphp
                                            {{-- @if (Carbon\Carbon::now()->lessThan($expiry)) --}}
                                                @php
                                                    $job = \App\Job::find($job->id);
                                                    //$description = strip_tags(stripslashes($job->description));
                                                    $description = strip_tags(stripslashes($job->description));
                                                    $featured_class = $job->is_featured == 'true' ? 'wt-featured' : '';
                                                    $user = Auth::user() ? \App\User::find(Auth::user()->id) : '';
                                                    $project_type  = Helper::getProjectTypeList($job->project_type);
                                                    $save_jobs = !empty($user->profile->saved_jobs) ? unserialize($user->profile->saved_jobs) : array();
                                                    $job_saved = array_search($job->id,$save_jobs);
                                                @endphp
                                                <div class="wt-userlistinghold wt-userlistingholdvtwo {{$featured_class}}">
                                                    @if ($job->is_featured == 'true')
                                                    @endif
                                                    <div class="wt-userlistingcontent">
                                                        <div class="wt-contenthead">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-7">
                                                                            <div class="wt-title">
                                                                                <div class="wt-title-name-location">
                                                                                    @if (!empty($job->location->title))
                                                                                        <!-- <span class="wt-locationarea"><img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.location') }}}"> {{{ $job->location->title }}}</span> -->
                                                                                        <span class="wt-locationarea"><img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.location') }}}"></span>
                                                                                    @endif
                                                                                    @if (!empty($job->employer->slug))
                                                                                        <span class="wt-employername"><a href="{{ url('profile/'.$job->employer->slug) }}"><i class="fa fa-check-circle"></i> {{{ Helper::getUserName($job->employer->id) }}}</a></span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-5">
                                                                            @if (!empty($job->project_level))
                                                                            @if ($job->project_type == "hourly")
                                                                                <span class="wt-viewjobhour"><i class="fa fa-dollar-sign wt-viewjobdollar"></i>{{{$job->price}}}/hr</span>
                                                                                @else 
                                                                                <span class="wt-viewjobhour"><i class="fa fa-dollar-sign wt-viewjobdollar"></i>{{{$job->price}}}</span>
                                                                                @endif
                                                                            @endif
                                                                           
                                                                                <span class="wt-viewjobheart"id="remove-{{$job->id}}" style="{{ $job_saved ? '' : 'display: none;' }}">
                                                                                    <a href="javascript:void(0);"  class="wt-clicklike wt-clicksave"
                                                                                 onclick="remove_from_wishlist('remove-{{$job->id}}', {{ $job->id }}, 'saved_jobs', 'Save','add-{{$job->id}}')" >
                                                                                    <i class="fa fa-heart"></i> {{trans("lang.saved")}}</a></span>
                                                                            
                                                                                <span class="wt-viewjobheart"id="add-{{$job->id}}" style="{{ $job_saved ? 'display: none;' : '' }}">
                                                                                    <a href="javascript:void(0);" class="wt-clicklike" onclick="add_to_wishlist('job-{{$job->id}}', {{$job->id}}, 'saved_jobs', '{{trans('lang.saved')}}','remove-{{$job->id}}');" >
                                                                                        <i class="fa fa-heart"></i>
                                                                                    </a>
                                                                                </span>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-lg-11 col-md-11 col-sm-12">
                                                                            <div class="wt-job-post-title">
                                                                                <h2><a href="{{ url('job/'.$job->slug) }}">{{{$job->title}}}</a></h2>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-lg-11 col-md-11 col-sm-12">
                                                                            <div class="wt-description">
                                                                                <p>{{ str_limit($description, 200) }}</p>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-1 col-md-1 col-sm-12">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    
                                                                    <div class="wt-tag wt-widgettag">
                                                                        <!-- @foreach ($job->skills as $skill )
                                                                            <a href="{{{url('jobs/'.$skill->slug)}}}">{{$skill->title}}</a>
                                                                        @endforeach -->
                                                                        <?php $count = 0; ?>
                                                                        @foreach($job->skills as $skill)
                                                                            <?php if($count == 4) break; ?>
                                                                                <a href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                                            <?php $count++; ?>
                                                                        @endforeach

                                                                        @if($job->skills->count() > 2)
                                                                            <a class="wt-showall" href="{{ url('job/'.$job->slug) }}">Show All</a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                                            <a href="{{url('job/'.$job->slug)}}" class="findjobbutton e-button e-button-primary">{{{ trans('lang.view_job') }}}</a>
                                                                        </div>
                                                                        <!-- <div class="col-lg-1 col-md-1 col-sm-12">

                                                                        </div> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @else 
                                            @php
                                            
                                                $job = \App\Job::find($job->id);
                                                $description = strip_tags(stripslashes($job->description));
                                                $featured_class = $job->is_featured == 'true' ? 'wt-featured' : '';
                                                $user = Auth::user() ? \App\User::find(Auth::user()->id) : '';
                                                $project_type  = Helper::getProjectTypeList($job->project_type);

                                            @endphp
                                            <div class="wt-userlistinghold wt-userlistingholdvtwo {{$featured_class}}">
                                                @if ($job->is_featured == 'true')
                                                @endif
                                                <div class="wt-userlistingcontent">
                                                    <div class="wt-contenthead">
                                                        <div class="wt-title">
                                                            <a href="{{ url('profile/'.$job->employer->slug) }}"><i class="fa fa-check-circle"></i> {{{ Helper::getUserName($job->employer->id) }}}</a>
                                                            <h2><a href="{{ url('job/'.$job->slug) }}">{{{$job->title}}}</a></h2>
                                                        </div>
                                                        <div class="wt-description">
                                                          
                                                            <p>{{ str_limit($description, 200) }}</p>
                                                        </div>
                                                        <div class="wt-tag wt-widgettag">
                                                            @foreach ($job->skills as $skill )
                                                                <a href="{{{url('jobs/'.$skill->slug)}}}">{{$skill->title}}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="wt-viewjobholder">
                                                        <ul>
                                                            @if (!empty($job->project_level))
                                                                <li><span><i class="fa fa-dollar-sign wt-viewjobdollar"></i>{{{ $job->price }}}</span></li>
                                                            @endif
                                                            @if (!empty($job->location->title))
                                                                <li><span><img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.location') }}}"> {{{ $job->location->title }}}</span></li>
                                                            @endif
                                                            <li><span><i class="far fa-folder wt-viewjobfolder"></i>{{{ trans('lang.type') }}} {{{$project_type}}}</span></li>
                                                            <li><span><i class="far fa-clock wt-viewjobclock"></i>{{{ Helper::getJobDurationList($job->duration)}}}</span></li>
                                                            <li><span><i class="fa fa-tag wt-viewjobtag"></i>{{{ trans('lang.job_id') }}} {{{$job->code}}}</span></li>
                                                            <span class="wt-viewjobheart"id="remove-{{$job->id}}" style="{{ $job_saved ? '' : 'display: none;' }}">
                                                                <a href="javascript:void(0);"  class="wt-clicklike wt-clicksave"
                                                             onclick="remove_from_wishlist('remove-{{$job->id}}', {{ $job->id }}, 'saved_jobs', 'Save','add-{{$job->id}}')" >
                                                                <i class="fa fa-heart"></i> {{trans("lang.saved")}}</a></span>
                                                        
                                                            <span class="wt-viewjobheart"id="add-{{$job->id}}" style="{{ $job_saved ? 'display: none;' : '' }}">
                                                                <a href="javascript:void(0);" class="wt-clicklike" onclick="add_to_wishlist('job-{{$job->id}}', {{$job->id}}, 'saved_jobs', '{{trans('lang.saved')}}','remove-{{$job->id}}');" >
                                                                    <i class="fa fa-heart"></i>
                                                                </a>
                                                            </span>
                                                            <li class="wt-btnarea"><a href="{{url('job/'.$job->slug)}}" class="wt-btn">{{{ trans('lang.view_job') }}}</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if ( method_exists($jobs,'links') )
                                        {{ $jobs->links('pagination.custom') }}
                                    @endif
                                @else
                                    @if (file_exists(resource_path('views/extend/errors/no-record.blade.php'))) 
                                        @include('extend.errors.no-record')
                                    @else 
                                        @include('errors.no-record')
                                    @endif
                                @endif
                            </div>
                            <!-- ==================== List View End ========================= -->
                            <!-- ==================== Grid View ========================= -->
                            <div class="wt-userlistingholder wt-haslayout jobs_list_view" id="grid-layout">
                                
                                @if (!empty($keyword))
                                    <div class="wt-userlistingtitle">
                                        <span>{{ trans('lang.01') }}results for <em>"{{{$keyword}}}"</em></span>
                                    </div>
                                @endif
                                <div class="row">
                                @if (!empty($jobs) )
                                    @foreach ($jobs as $job)
                                        @if (\Schema::hasColumn('jobs', 'expiry_date') && !empty($job->expiry_date))
                                            @php $expiry = Carbon\Carbon::parse($job->expiry_date); @endphp
                                            {{-- @if (Carbon\Carbon::now()->lessThan($expiry)) --}}
                                                @php
                                                    $job = \App\Job::find($job->id);
                                                    //$description = strip_tags(stripslashes($job->description));
                                                    $description = strip_tags(stripslashes($job->description));
                                                    $featured_class = $job->is_featured == 'true' ? 'wt-featured' : '';
                                                    $user = Auth::user() ? \App\User::find(Auth::user()->id) : '';
                                                    $project_type  = Helper::getProjectTypeList($job->project_type);
                                                @endphp
                                                
                                                <div class="col-lg-6 col-md-6 col-sm-6 jobs_list_view_margin jobforhidingpadingleft">
                                                    <div class="wt-userlistinghold wt-userlistingholdvtwo {{$featured_class}}">
                                                        @if ($job->is_featured == 'true')
                                                        @endif
                                                        <div class="wt-userlistingcontent">
                                                            <div class="wt-contenthead">
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="row">
                                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-7">
                                                                                <div class="wt-title">
                                                                                    <div class="wt-title-name-location">
                                                                                        @if (!empty($job->location->title))
                                                                                            <!-- <span class="wt-locationarea"><img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.location') }}}"> {{{ $job->location->title }}}</span> -->
                                                                                            <span class="wt-locationarea"><img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.location') }}}"></span>
                                                                                        @endif
                                                                                        @if (!empty($job->employer->slug))
                                                                                            <span class="wt-employername"><a href="{{ url('profile/'.$job->employer->slug) }}"><i class="fa fa-check-circle"></i> {{{ Helper::getUserName($job->employer->id) }}}</a></span>
                                                                                        @endif
                                                                                    </div>                                                                                
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-5">
                                                                                @if (!empty($job->project_level))
                                                                                @if ($job->project_type == "hourly")
                                                                                    <span class="wt-viewjobhour"><i class="fa fa-dollar-sign wt-viewjobdollar"></i>{{{$job->price}}}/hr</span>
                                                                                    @else 
                                                                                    <span class="wt-viewjobhour"><i class="fa fa-dollar-sign wt-viewjobdollar"></i>{{{$job->price}}}</span>
                                                                                    @endif
                                                                                @endif
                                                                                {{-- @if (!empty($user->profile->saved_jobs) && in_array($job->id, unserialize($user->profile->saved_jobs)))
                                                                                    <span class="wt-viewjobheart"><a href="javascript:void(0);" class="wt-clicklike wt-clicksave"><i class="fa fa-heart"></i> {{trans("lang.saved")}}</a></span>
                                                                                @else
                                                                                    <span class="wt-viewjobheart">
                                                                                        <a href="javascrip:void(0);" class="wt-clicklike" id="job-{{$job->id}}" @click.prevent="add_wishlist('job-{{$job->id}}', {{$job->id}}, 'saved_jobs', '{{trans("lang.saved")}}')" v-cloak>
                                                                                            <i class="fa fa-heart"></i>
                                                                                        </a>
                                                                                    </span>
                                                                                @endif --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="row">
                                                                            <div class="col-lg-11 col-md-11 col-sm-12">
                                                                                <div class="wt-job-post-title">
                                                                                    <h2><a href="{{ url('job/'.$job->slug) }}">{{{$job->title}}}</a></h2>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="row">
                                                                            <div class="col-lg-11 col-md-11 col-sm-12">
                                                                                <div class="wt-description">
                                                                                    <p>{{ str_limit($description, 80) }}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-1 col-md-1 col-sm-12">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <!-- <div class="wt-tag wt-widgettag">
                                                                            <a href="http://127.0.0.1:8000/search-results?type=job&amp;skills%5B%5D=animation">Animation</a> 
                                                                            <img src="/uploads/logos/" alt=""> 
                                                                            <a href="http://127.0.0.1:8000/search-results?type=job&amp;skills%5B%5D=adobe-premier-pro">Adobe Premier Pro</a>
                                                                            <img src="/uploads/logos/" alt=""> 
                                                                            <a href="http://127.0.0.1:8000/search-results?type=job&amp;skills%5B%5D=adobe-photoshop">Adobe Photoshop</a> 
                                                                            <img src="/uploads/logos/" alt=""> 
                                                                            <a href="http://127.0.0.1:8000/search-results?type=job&amp;skills%5B%5D=adobe-illustrator">Adobe Illustrator</a> 
                                                                            <img src="/uploads/logos/" alt="">
                                                                        </div> -->
                                                                        <div class="wt-tag wt-widgettag">
                                                                            <!-- @foreach ($job->skills as $skill )
                                                                                <a href="{{{url('jobs/'.$skill->slug)}}}">{{$skill->title}}</a>
                                                                            @endforeach -->
                                                                            <?php $count = 0; ?>
                                                                            @foreach($job->skills as $skill)
                                                                                <?php if($count == 2) break; ?>
                                                                                    <a href="{{{url('jobs/'.$skill->slug)}}}">{{{ $skill->title }}}</a>
                                                                                <?php $count++; ?>
                                                                            @endforeach

                                                                            @if($job->skills->count() > 1)
                                                                                <a class="wt-showall" href="{{ url('job/'.$job->slug) }}">Show All</a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                    <a href="{{url('job/'.$job->slug)}}" class="findjobbutton e-button e-button-primary my-3">{{{ trans('lang.view_job') }}}</a>
                                                                                </div>
                                                                            </div>
                                                                        
                                                                    </div>
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
                                        @else 
                                            @php
                                            
                                                $job = \App\Job::find($job->id);
                                                $description = strip_tags(stripslashes($job->description));
                                                $featured_class = $job->is_featured == 'true' ? 'wt-featured' : '';
                                                $user = Auth::user() ? \App\User::find(Auth::user()->id) : '';
                                                $project_type  = Helper::getProjectTypeList($job->project_type);

                                            @endphp
                                            <div class="wt-userlistinghold wt-userlistingholdvtwo {{$featured_class}}">
                                                @if ($job->is_featured == 'true')
                                                @endif
                                                <div class="wt-userlistingcontent">
                                                    <div class="wt-contenthead">
                                                        <div class="wt-title">
                                                            <a href="{{ url('profile/'.$job->employer->slug) }}"><i class="fa fa-check-circle"></i> {{{ Helper::getUserName($job->employer->id) }}}</a>
                                                            <h2><a href="{{ url('job/'.$job->slug) }}">{{{$job->title}}}</a></h2>
                                                        </div>
                                                        <div class="wt-description">
                                                          
                                                            <p>{{ str_limit($description, 200) }}</p>
                                                        </div>
                                                        <div class="wt-tag wt-widgettag">
                                                            @foreach ($job->skills as $skill )
                                                                <a href="{{{url('jobs/'.$skill->slug)}}}">{{$skill->title}}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="wt-viewjobholder">
                                                        <ul>
                                                            @if (!empty($job->project_level))
                                                                <li><span><i class="fa fa-dollar-sign wt-viewjobdollar"></i>{{{ $job->price }}}</span></li>
                                                            @endif
                                                            @if (!empty($job->location->title))
                                                                <li><span><img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.location') }}}"> {{{ $job->location->title }}}</span></li>
                                                            @endif
                                                            <li><span><i class="far fa-folder wt-viewjobfolder"></i>{{{ trans('lang.type') }}} {{{$project_type}}}</span></li>
                                                            <li><span><i class="far fa-clock wt-viewjobclock"></i>{{{ Helper::getJobDurationList($job->duration)}}}</span></li>
                                                            <li><span><i class="fa fa-tag wt-viewjobtag"></i>{{{ trans('lang.job_id') }}} {{{$job->code}}}</span></li>
                                                            @if (!empty($user->profile->saved_jobs) && in_array($job->id, unserialize($user->profile->saved_jobs)))
                                                                <li style=pointer-events:none;><a href="javascript:void(0);" class="wt-clicklike wt-clicksave"><i class="fa fa-heart"></i> {{trans("lang.saved")}}</a></li>
                                                            @else
                                                                <li>
                                                                    <a href="javascrip:void(0);" class="wt-clicklike" id="job-{{$job->id}}" @click.prevent="add_wishlist('job-{{$job->id}}', {{$job->id}}, 'saved_jobs', '{{trans("lang.saved")}}')" v-cloak>
                                                                        <i class="fa fa-heart"></i>
                                                                        <span class="save_text">{{ trans('lang.click_to_save') }}</span>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            <li class="wt-btnarea"><a href="{{url('job/'.$job->slug)}}" class="wt-btn">{{{ trans('lang.view_job') }}}</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if ( method_exists($jobs,'links') )
                                        {{ $jobs->links('pagination.custom') }}
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
                            <!-- ==================== Grid View End ========================= -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
      function add_to_wishlist( element_id, id, column, saved_text, hidable_element_id){
            $.ajax({
               type:'POST',
               url:"{{ url('/user/add-wishlist') }}",
               data:{
               _token : "{{ csrf_token() }}",
               id: id,
               column: column,
               },
               success:function(response) {
              console.log(response)
              if(response.authentication==true){
              if (column == "saved_jobs") {
                jQuery("#" + hidable_element_id).show();
                jQuery("#" + element_id).hide();
              }
              iziToast.success({
                message: response.message,
                position: "center",
                timeout: 3000,
                progressBar: true,
                backgroundColor: 'green',
                })
            }
            else{
                iziToast.show({
                message: response.message,
                position: "topRight",
                timeout: 3000,
                progressBar: false,
                color: 'red',
                })
            }
        }
            
               
            });
        }
        function remove_from_wishlist( element_id, id, column, saved_text, hidable_element_id){
            console.log("in remove")
            $.ajax({
               type:'POST',
               url:"{{ url('/user/remove-wishlist') }}",
               data:{
               _token : "{{ csrf_token() }}",
               id: id,
               column: column,
               },
               success:function(response) {
                console.log(response)
                if(response.authentication==true){
              if (column == "saved_jobs") {
                jQuery("#" + hidable_element_id).show();
                  jQuery("#" + element_id).hide();
              }
              iziToast.success({
                message: response.message,
                position: "center",
                timeout: 3000,
                progressBar: true,
                backgroundColor: 'green',
                })
            }
            else{
                iziToast.show({
                message: response.message,
                position: "topRight",
                timeout: 3000,
                progressBar: false,
                color: 'red',
                })
            }
            } });
        }
            </script>
    @endsection
    
    