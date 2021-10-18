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
                    <h2>Create your Agency</h2>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                        <div class="wt-dashboardbox wt-dashboardtabsholder">
                            <div class="wt-location wt-tabsinfo agency-selection-form">
                                <div class='wt-settingscontent'>
                                    <form action="{{ route('agencyDataPost') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class='wt-formtheme wt-userform agency-form'>
                                            <div class="row" style="padding-top: 20px">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="agency_name" placeholder="Agency Name" class="form-control" value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="contact_no" placeholder="Agency Contact No" class="form-control" value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="contact_email" placeholder="Agency Email" class="form-control"  value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="founded_in" placeholder="Founded Year" class="form-control"  value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="file" name="agency_logo" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="wt-profilephoto wt-tabsinfo">
{{--                                                    @if (file_exists(resource_path('views/extend/back-end/agency/logo_photo.blade.php')))--}}
{{--                                                        @include('extend.back-end.agency.logo_photo')--}}
{{--                                                    @else--}}
{{--                                                        @include('back-end.agency.logo_photo')--}}
{{--                                                    @endif--}}
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="description" id="" placeholder="Enter agency Description" cols="30" rows="20"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="hourly_rates_min" placeholder="Hourly Min Rate" class="form-control"  value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="hourly_rates_max" placeholder="Hourly Max Rate" class="form-control"  value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group" placeholder="Agency size" >
                                                        <select class="col-md-6" name="agency_size" id="agency_size">
                                                            <option value="10-50">10-50 Employees</option>
                                                            <option value="51-100">51-100 Employees</option>
                                                            <option value="101-200">101-200 Employees</option>
                                                        </select>
                                                    </div>
                                                </div>
<!--                                                --><?php //print_r($skills); ?>
                                                <div class="wt-skills la-skills-holder wt-tabsinfo">
                                                    <div class="wt-tabscontenttitle">
                                                        <h2></h2>
                                                    </div>
                                                    <user_skills :ph_rate_skills="'{{ trans('lang.ph_rate_skills') }}'"></user_skills>                                                </div>
                                                <div class="col-md-4">
                                                    <div class="wt-statisticcontent wt-countercolor3" style="padding-top: 10px;padding-left: 10px;"><h3 data-from="0" data-to="665" data-speed="8000" data-refresh-interval="100">$0</h3> <h4>Total Earned</h4></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="wt-statisticcontent wt-countercolor1" style="padding-top: 10px;padding-left: 10px;"><h3 data-from="0" data-to="665" data-speed="8000" data-refresh-interval="100">0</h3> <h4>Total Hours</h4></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="wt-statisticcontent wt-countercolor4" style="padding-top: 10px;padding-left: 10px;"><h3 data-from="0" data-to="665" data-speed="8000" data-refresh-interval="100">0</h3> <h4>Total Jobs</h4></div>
                                                </div>
                                            </div>
                                            <input type="submit" value="Save">
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
