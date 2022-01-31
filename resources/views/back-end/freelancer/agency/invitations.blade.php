@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')

    <section class="wt-haslayout wt-dbsectionspace" id="profile_settings">
        <div class="wt-dbsectionspace wt-haslayout la-ps-freelancer">
            <div class="freelancer-profile" id="user_profile">
                <div class="preloader-section" v-if="loading" v-cloak>
                    <div class="preloader-holder">
                        <div class="loader"></div>
                    </div>
                </div>
                @if (Session::has('message'))
                    <div class="alert alert-success">
                        {{ Session::get('message') }}
                    </div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class='wt-tabscontenttitle'>
                    <h2>Your Invitations</h2>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                        <div class="wt-dashboardbox wt-dashboardtabsholder">
                            <div class="wt-location wt-tabsinfo agency-selection-form">
                                <div class='wt-settingscontent'>
                                    <div class='wt-formtheme wt-userform agency-form'>
                                        @if($getInvites === 0)
                                        <div>
                                            <br>
                                            <div class="alert alert-success" role="alert">
                                                No new invitations!
                                            </div>
                                        </div>
                                        @elseif($getInvites !== 0 && $requested_agency != null)
                                            @foreach($requested_agency as $details)
                                                <br>
                                                <div class="alert alert-warning" role="alert">
                                                    You have been invited to join -- <a target="_blank" href="{{ url('agency/'.$details['slug']) }}">{{ $details['agency_name'] }}</a> by {{ \App\Helper::getUserName($details['user_id']) }}
                                                </div>
                                                <div class="invitations-buttons">
                                                    <button onclick = "location.href='/agency/acceptInvitation/{{ $details['id'] }}'" class="e-button e-button-primary">Accept</button>
                                                    <button onclick="location.href='/agency/declineInvitation/{{ $details['id'] }}'" class="e-button e-button-primary my-3">Decline</a></button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
