@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace wt-insightuser" id="dashboard">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
            @php session()->forget('message');  @endphp
        @endif
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="wt-insightsitemholder">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                @if($have_service > 0)
                                <i class="fa fa-check-circle wt-greentick"></i>
                                @endif
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('uploads/settings/icon',$latest_proposals_icon, 'briefcase') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>My Services</h3>
                                        <a href="{{{ route('ServiceListing', ['status'=>'posted']) }}}">{{ trans('lang.click_view') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                @if($have_courses > 0)
                                <i class="fa fa-check-circle wt-greentick"></i>
                                @endif
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('uploads/settings/icon',$latest_proposals_icon, 'book') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>My Courses</h3>
                                        <a href="{{{ route('CourseListing', ['status'=>'posted']) }}}">{{ trans('lang.click_view') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="wt-insightsitem wt-dashboardbox">
                                <figure class="wt-userlistingimg">
                                    {{ Helper::getImages('uploads/settings/icon',$latest_proposals_icon, 'user') }}
                                </figure>
                                <div class="wt-insightdetails">
                                    <div class="wt-title">
                                        <h3>My Profile</h3>
                                        <a href="{{{ url(route('showUserProfile', ['slug' => Auth::user()->slug])) }}}">
                       {{ trans('lang.click_view') }}</a>
                                    </div>
                                </div>
                                 @if (Auth::user())
                                    <div class="wt-widgetcontent wt-skillscontent mt-3">
                                      <div class="wt-skillholder" data-percent="{{{ $percentage }}}%">
                                        <span>Profile Completion<em>{{{ $percentage }}}%</em></span>
                                        <div class="wt-skillbarholder"><div class="wt-skillbar" style="width: {{ $percentage }}% !important;"></div></div>
                                      </div>
                                    </div>
                                 @endif
                            </div>
                        </div>
                        @if (!empty($enable_package) && $enable_package === 'true')
                            @if (!empty($package))
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                    <div class="wt-insightsitem wt-dashboardbox user_current_package">
                                        <countdown
                                        date="{{$expiry_date}}"
                                        :image_url="'{{{ Helper::getDashExpiryImages('uploads/settings/icon',$latest_package_expiry_icon, 'img-21.png') }}}'"
                                        :title="'{{ trans('lang.check_pkg_expiry') }}'"
                                        :package_url="'{{url('dashboard/packages/freelancer')}}'"
                                        :trail="'{{$trail}}'"
                                        :current_package="'{{$package->title}}'"
                                        >
                                        </countdown>
                                    </div>
                                </div>  
                            @endif          
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 float-left">
                <div class="wt-dashboardbox wt-ongoingproject la-ongoing-projects">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2>{{ trans('lang.ongoing_project') }}</h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-hiredfreelance">
                            <table class="wt-tablecategories wt-freelancer-table">
                                <thead>
                                    <tr>
                                        <th>{{trans('lang.project_title')}}</th>
                                        <th>{{trans('lang.employer_name')}}</th>
                                        <th>{{trans('lang.project_cost')}}</th>
                                        <th>{{trans('lang.actions')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if ($access_type == 'jobs' || $access_type== 'both')
                                    @if (!empty($ongoing_projects) && $ongoing_projects->count() > 0)
                                        @foreach ($ongoing_projects as $projects)
                                            @php
                                                $project = \App\Proposal::find($projects->id);
                                                $user = \App\User::find($project->job->user_id);
                                                $user_name = Helper::getUsername($project->job->user_id);
                                            @endphp
                                            <tr>
                                                <td data-th="Project title"><span class="bt-content"><a target="_blank" href="{{{ url('freelancer/job/'.$project->job->slug) }}}">{{{ str_limit($project->job->title, 40) }}}</a></span></td>
                                                <td data-th="Hired freelancer">
                                                    <span class="bt-content"><a href="{{{url('profile/'.$user->slug)}}}">@if ($user->user_verified)<i class="fa fa-check-circle"></i>&nbsp;@endif{{{$user_name}}}</a>
                                                    </span>
                                                </td>
                                                <td data-th="Project cost"><span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{$projects->amount}}</span></td>
                                                <td data-th="Actions">
                                                    <span class="bt-content"><div class="wt-btnarea"><a href="{{{ url('freelancer/job/'.$project->job->slug) }}}" class="wt-btn">{{ trans('lang.view_detail') }}</a></div></span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                                @if (($access_type == 'services' || $access_type == 'both') && (Schema::hasTable('services') && Schema::hasTable('service_user')))
                                    @if (Helper::getFreelancerServices('hired', Auth::user()->id)->count() > 0)
                                        @foreach (Helper::getFreelancerServices('hired', Auth::user()->id)->take(3) as $ongoing_service_key => $service )
                                            @php 
                                                $employer = \App\User::find($service->pivot_user);
                                                $user_name = Helper::getUsername($service->pivot_user);
                                            @endphp
                                            <tr>
                                                <td data-th="Project title">
                                                    <span class="bt-content">
                                                        <a target="_blank" href="{{{ url('freelancer/service/'.$service->pivot_id.'/hired') }}}">
                                                            {{{ str_limit($service->title, 40) }}}
                                                        </a>
                                                    </span>
                                                </td>
                                                <td data-th="Hired freelancer">
                                                    <span class="bt-content">
                                                        <a href="{{{url('profile/'.$employer->slug)}}}">
                                                            @if ($employer->user_verified)
                                                                <i class="fa fa-check-circle"></i>&nbsp;
                                                            @endif
                                                            {{{$user_name}}}
                                                        </a>
                                                    </span>
                                                </td>
                                                <td data-th="Project cost">
                                                    <span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{$service->price}}</span>
                                                </td>
                                                <td data-th="Actions">
                                                    <span class="bt-content">
                                                        <div class="wt-btnarea">
                                                            <a href="{{{ url('freelancer/service/'.$service->pivot_id.'/hired') }}}" class="wt-btn">
                                                                {{ trans('lang.view_detail') }}
                                                            </a>
                                                        </div>
                                                    </span>
                                                </td>
                                            </tr>    
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 float-left">
                <div class="wt-dashboardbox  wt-ongoingproject la-ongoing-projects">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2>{{ trans('lang.past_earnings') }}</h2>
                    </div>
                    @php
                        $pastearing_check = '';
                        if (Schema::hasTable('services') && Schema::hasTable('service_user')) {
                            $pastearing_check = Helper::getFreelancerServices('completed', Auth::user()->id, 'completed')->count() > 0;
                        }
                    @endphp
                    @if ((!empty($completed_projects_history) && $completed_projects_history->count() > 0) || $pastearing_check)
                        @php
                            $commision = \App\SiteManagement::getMetaValue('commision');
                            $admin_commission = !empty($commision[0]['commision']) ? $commision[0]['commision'] : 0;
                        @endphp
                        <div class="wt-dashboardboxcontent wt-hiredfreelance">
                            <table class="wt-tablecategories">
                                <thead>
                                    <tr>
                                        <th>{{trans('lang.project_title')}}</th>
                                        <th>{{trans('lang.date')}}</th>
                                        <th>{{trans('lang.earnings')}}</th>
                                    </tr>
                                </thead>
                                @if ($access_type == 'jobs' || $access_type== 'both')
                                    @if (!empty($completed_projects_history) && $completed_projects_history->count() > 0)
                                        <tbody>
                                            @foreach ($completed_projects_history as $projects)
                                                @php
                                                    $project = \App\Proposal::find($projects->id);
                                                    $user_name = Helper::getUsername($project->job->user_id);
                                                    $amount = !empty($project->amount) ? $project->amount - ($project->amount / 100) * $admin_commission : 0;
                                                @endphp
                                                <tr class="wt-earning-contents">
                                                    <td class="wt-earnig-single" data-th="Project Title"><span class="bt-content">{{{ $project->job->title }}}</span></td>
                                                    <td data-th="Date"><span class="bt-content">{{$project->updated_at}}</span></td>
                                                    <td data-th="Earnings"><span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{$amount}}}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif
                                @endif
                                @if ($access_type == 'services' || $access_type == 'both')
                                    @if (Helper::getFreelancerServices('completed', Auth::user()->id)->count() > 0)
                                        <tbody>
                                            @foreach (Helper::getFreelancerServices('completed', Auth::user()->id) as $service)
                                                @php
                                                    $freelancer = Helper::getServiceSeller($service->id);
                                                    $user_name = !empty($freelancer) ? Helper::getUsername($freelancer->seller_id) : '';
                                                    $amount = !empty($service->price) ? $service->price - ($service->price / 100) * $admin_commission : 0;
                                                @endphp
                                                <tr class="wt-earning-contents">
                                                    <td class="wt-earnig-single" data-th="Project Title"><span class="bt-content">{{{ $service->title }}}</span></td>
                                                    <td data-th="Date"><span class="bt-content">{{$service->updated_at}}</span></td>
                                                    <td data-th="Earnings"><span class="bt-content">{{ !empty($symbol['symbol']) ? $symbol['symbol'] : '$' }}{{{$amount}}}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif
                                @endif
                            </table>
                        </div>
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
    </section>
@endsection
