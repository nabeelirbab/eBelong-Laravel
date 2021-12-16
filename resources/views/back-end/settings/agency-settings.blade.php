@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    @php $user_id = !empty(Auth::user()) ? Auth::user()->id : '';  @endphp
    <div class="wt-haslayout wt-dbsectionspace">
        <div class="wt-haslayout wt-reset-pass" id="pass-reset">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                    @if (Session::has('message'))
                        <div class="flash_msg">
                            <flash_messages :message_class="'success'" :time='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
                        </div>
                    @elseif (Session::has('error'))
                        <div class="flash_msg">
                            <flash_messages :message_class="'danger'" :time='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
                        </div>
                    @endif
                    <div class="wt-dashboardbox wt-dashboardtabsholder wt-accountsettingholder">
                        @if (file_exists(resource_path('views/extend/back-end/settings/tabs.blade.php')))
                            @include('extend.back-end.settings.tabs')
                        @else
                            @include('back-end.settings.tabs')
                        @endif
                        @if($agency_info['is_owner'] != null)
                        <div class="wt-tabscontent tab-content">
                            @if($agency_info && isset($agency_info[0]['agency_name']))

                                <div class="wt-location wt-tabsinfo agency-selection-form">
                                    <div class="agency_information" >
                                        <div class='wt-tabscontenttitle'>
                                            <h2>{{ 'Information' }}</h2>
                                        </div>
                                        <div class='wt-settingscontent'>
                                            You are associated with the agency below.
                                            <br>
                                            <br>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img style="width:44px" src="http://127.0.0.1:8000/uploads/agency_logos/14/ebelong.jpeg" alt="">
                                                    </div>
                                                    <div class="col-md-3" style="margin-left: -65px;">
                                                        <a href="{{ '/agency/'.$agency_info[0]['slug'] }}" target="_blank">  <p>{{{ $agency_info[0]['agency_name']  }}}</p></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($agency_info['is_owner'] === 1)
                                    <div class="manage_members" style="padding-top: 20px;">
                                        <div class='wt-tabscontenttitle'>
                                            <h2>{{{ 'Manage Members' }}}</h2>
                                        </div>
                                        <form action="{{ route('inviteToAgency') }}" method="post">
                                            @csrf
                                            <input type="hidden" value="{{ $agency_info[0]['id'] }}" name="agency_id">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12" style="padding-top: 20px;">
                                                        <div class="wt-radioboxholder">
                                                            <div class="wt-title ">
                                                                <h4>{{{ 'Enter Freelancer Email' }}}</h4>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="email" name="invitation_email" placeholder="Freelancer Email" class="form-control" value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12" style="padding-top: 20px;">
                                                        <div class="wt-radioboxholder">
                                                            <div class="wt-title ">
                                                                <h4>{{{ 'Select Freelancer Role' }}}</h4>
                                                            </div>
                                                            <div class="form-group">
                                                                <select name="member_role" id="user_role">
                                                                    <option value="">Select User Role</option>
                                                                    <option value="manager">Business Manager</option>
                                                                    <option value="rep">Representative</option>
                                                                    <option value="member">Member</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            {{-- <div class="form-group">
                                                <div class="col-md-12" style="padding-top: 30px;">
                                                    <div class="wt-radioboxholder">
                                                        <div class="wt-title">
                                                            <h4>{{{ 'Select Agency Member type' }}}</h4>
                                                        </div>
                                                        @foreach ($member_type as $key => $type)
                                                        <span class="wt-radio">
                                                            <input id="wt-just-{{{$key}}}" type="radio" name="freelancer_type" value="{{{$key}}}">
                                                            <label for="wt-just-{{{$key}}}">{{{$type}}}</label>
                                                        </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="form-group form-group-half wt-btnarea" style="padding-top: 20px;">
                                                <input type="submit" value="Invite" class="wt-btn"style="margin: 10px;">
                                                <a href="/agency-members" class="wt-btn" style="margin: 10px;">View Members</a>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="agency_settings" style="padding-bottom: 10px">
                                        <div class='wt-tabscontenttitle'>
                                            <h2>{{{ 'Agency Settings' }}}</h2>
                                        </div>
                                        <div class="form-group form-group-half wt-btnarea">
                                            <input type="button" value="Settings" class="wt-btn" style="background: #248a57">
                                        </div>
                                    </div>
                                    @endif

                                    @if($agency_info['is_owner'] === 0)
                                        <div class="agency_settings" style="padding-bottom: 10px">
                                            <div class='wt-tabscontenttitle'>
                                                <h2>{{{ 'Agency Settings' }}}</h2>
                                            </div>
                                            <div class="form-group form-group-half wt-btnarea">
                                                <input type="button" value="Leave Agency" class="wt-btn" style="background: #e92929">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="wt-location wt-tabsinfo agency-selection-form">
                                    <div class='wt-tabscontenttitle'>
                                        <h2>{{{ trans('lang.agency_section') }}}</h2>
                                    </div>
                                    <div class='wt-settingscontent'>
                                        <div class='wt-formtheme wt-userform agency-form'>
                                            <div class="container box">
                                                <h3 align="center">Search Agency</h3><br />

                                                <div class="form-group">
                                                    <input type="text" name="agency_name" id="agency_name" class="form-control input-lg" placeholder="Search Agency" />
                                                    <div id="agencyList" class="form-group">
                                                    </div>
                                                </div>
                                                {{ csrf_field() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wt-location wt-tabsinfo agency-selection-form" style="display:none;"></div>
                            @endif
                        </div>
                        @else
                            <div>
                                <h2>You are not assiciated with any agency yet!</h2>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
