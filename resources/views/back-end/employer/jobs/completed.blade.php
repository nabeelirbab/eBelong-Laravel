@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
<div class="wt-haslayout wt-dbsectionspace">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="wt-dashboardbox">
                <div class="wt-dashboardboxtitle">
                    <h2>{{ trans('lang.completed_jobs') }}</h2>
                </div>
                <div class="wt-dashboardboxcontent wt-jobdetailsholder la-projectc-completed">
                    <div class="wt-freelancerholder">
                        @if(!empty($completed_jobs) && $completed_jobs->count() > 0)
                            <div class="wt-managejobcontent wt-verticalscrollbar mCustomScrollbar _mCS_1">
                                @foreach ($completed_jobs as $job)
                                    @php
                                        $accepted_proposal = \App\Job::find($job->id)->proposals()->where('status', 'completed')->first();
                                        
                                        $profile = \App\Job::find($job->id)->proposals()->where('status', 'completed')->count() > 0 ? \App\Profile::where('user_id',$accepted_proposal->freelancer_id)->first() : array();

                                        $user_image = !empty($profile) ? $profile->avater : '';
                                        $verified_user = \App\User::select('user_verified')->where('id', $job->employer->id)->pluck('user_verified')->first();
                                        $project_type  = Helper::getProjectTypeList($job->project_type);
                                    @endphp
                                    <div class="wt-userlistinghold wt-featured wt-userlistingvtwo">
                                        @if (!empty($job->is_featured) && $job->is_featured === 'true')
                                            <span class="wt-featuredtag"><img src="{{{ asset('images/featured.png') }}}" alt="{{ trans('lang.is_featured') }}" data-tipso="Plus Member" class="template-content tipso_style"></span>
                                        @endif
                                        <div class="wt-userlistingcontent wt-userlistingcontentvtwo">
                                            <div class="wt-contenthead">
                                                <div class="wt-title">
                                                    <a href="{{{ url('profile/'.$job->employer->slug) }}}">
                                                        @if ($verified_user === 1)
                                                            <i class="fa fa-check-circle"></i>
                                                        @endif
                                                        &nbsp;{{{ Helper::getUserName($job->employer->id).' | JOB ID: '.$job->id }}}
                                                    </a>
                                                    @if (!empty($job->title))
                                                        <h4>{{{ $job->title }}}</h4>
                                                    @endif
                                                </div>
                                                <ul class="wt-saveitem-breadcrumb wt-userlisting-breadcrumb">
                                                    @if (!empty($job->price))
                                                        <li><span class="wt-dashboraddoller"><i>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}</i> {{{ $job->price }}}</span></li>
                                                    @endif
                                                    @if (!empty($job->location->title))
                                                        <li><span><img src="{{{asset(Helper::getLocationFlag($job->location->flag))}}}" alt="{{{ trans('lang.locations') }}}"> {{{ $job->location->title }}}</span></li>
                                                    @endif
                                                    @if (!empty($job->project_type))
                                                        <li><a href="javascript:void(0);" class="wt-clicksavefolder"><i class="far fa-folder"></i> {{{ trans('lang.type') }}} {{{ $project_type }}}</a></li>
                                                    @endif
                                                    @if (!empty($job->duration))
                                                        <li><span class="wt-dashboradclock"><i class="far fa-clock"></i> {{ trans('lang.duration') }} {{{ Helper::getJobDurationList($job->duration)}}}</span></li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="wt-rightarea">
                                                <div class="wt-btnarea">
                                                    <span> {{ trans('lang.project_completed') }}</span>
                                                    <a href="{{{ url('proposal/'.$job->slug.'/'.$job->status) }}}" class="wt-btn">{{ trans('lang.view_detail') }}</a>
                                                </div>
                                                <div class="wt-hireduserstatus">
                                                    <h4>{{ trans('lang.hired') }}</h4><span>{{{ Helper::getUserName($accepted_proposal->freelancer_id) }}}</span>
                                                    <ul class="wt-hireduserimgs">
                                                        <li><figure><img src="{{{ asset(Helper::getProjectImage($user_image, $accepted_proposal->freelancer_id)) }}}" alt="{{{ trans('lang.freelancer') }}}"></figure></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                @if ( method_exists($completed_jobs,'links') )
                    {{ $completed_jobs->links('pagination.custom') }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
