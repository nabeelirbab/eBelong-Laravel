@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')

    <div class="wt-haslayout wt-dbsectionspace">
        <div class="wt-dbsectionspace wt-haslayout la-ps-freelancer">
            <div class="freelancer-profile" >
                <div class="preloader-section" v-if="loading" v-cloak>
                    <div class="preloader-holder">
                        <div class="loader"></div>
                    </div>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9" id="agency">
                        <div class="wt-dashboardbox wt-dashboardtabsholder">
                            <div class="wt-location wt-tabsinfo agency-selection-form">
                                <div class='wt-settingscontent'>
                                    {{-- {!! Form::open(['url' => '', 'id' => 'post_agency_form', '@submit.prevent'=>'submitAgency']) !!} --}}
                                    <form action="{{ route('agencyDataPost') }}" method="POST" enctype="multipart/form-data" id="post_agency_form">
                                        @csrf
                                        <div class='wt-formtheme wt-userform agency-form'>
                                            <div class="row" style="padding-top: 20px">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="agency_name" placeholder="Agency Name" class="form-control" value="{{old('agency_name')}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" onKeyPress="if(this.value.length==12) return false;" name="contact_no" placeholder="Agency Contact No" class="form-control" value="{{old('contact_no')}}" required value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" name="contact_email" placeholder="Agency Email" class="form-control"  value="{{old('contact_email')}}" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" onKeyPress="if(this.value.length==4) return false;" name="founded_in" placeholder="Founded Year" class="form-control" value="{{old('founded_in') }}" required value="" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-size: 16px;line-height: 20px;color: black;"> Agency Logo </label>
                                                        <input type="file" name="agency_logo" class="form-control" v-model="agency_logo">
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
                                                        <textarea onKeyPress="var words = this.value;
                                                        console.log('im changes');
                                                            var count = 0;
                                                            const wordLen = 200;
                                                            var split = words.split(' ');
                                                            for (var i = 0; i < split.length; i++) {
                                                                if (split[i] != '') {
                                                                    count += 1;
                                                                }
                                                            }
                                                                if(count > wordLen){
                                                                return false;
                                                                }
                                                            
                                                     "spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="false"
                                                          class="form-control" name="description" id="description" @keyup ="countWords" pattern="^(?:\w+\W+){0,5}(?:\w+)$" placeholder="Enter agency Description" cols="30" rows="20" >{{ old('description') }}</textarea>
                                                        <span id="show">0/200</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" name="hourly_rates_min" placeholder="Hourly Min Rate" class="form-control"  value="{{old('hourly_rates_min')}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" name="hourly_rates_max" placeholder="Hourly Max Rate" class="form-control"  value="{{old('hourly_rates_max')}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group" placeholder="Agency size" >
                                                        <select class="col-md-6" name="agency_size" id="agency_size">
                                                            <option value="" disabled selected>Company Size</option>
                                                            <option value="1-10"{{ old('agency_size') == "1-10" ? 'selected' : '' }}>Up to 10</option>
                                                            <option value="11-100"{{ old('agency_size') == "11-100" ? 'selected' : '' }}>11-100</option>
                                                            <option value="101-1000"{{ old('agency_size') == "101-1000" ? 'selected' : '' }}>101 - 1000</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- <div class="wt-skills la-skills-holder wt-tabsinfo">
                                                    <div class="wt-tabscontenttitle">
                                                        <h2>{{{ 'Agency Skills' }}}</h2>
                                                    </div>
                                                    <agency_skills :ph_rate_skills="'{{ trans('lang.ph_rate_skills') }}'"></agency_skills>                                               
                                                </div> -->
                                                <div class="wt-courses wt-tabsinfo">
                                                    <div class="wt-skills la-skills-holder wt-tabsinfo" id="wt-skills">
                                                        <div class="wt-tabscontenttitle">
                                                            <h2>{{ trans('lang.skills_req') }}</h2>
                                                        </div>
                                                        <div class="wt-formtheme wt-userform">
                                                            {{-- add Course Skills --}}
                                                            
                                                            <agency_skills :ph_rate_skills="'{{ trans('lang.ph_rate_skills') }}'"></agency_skills>
                                                        </div>
                                                    </div>
                                                </div>
                                            
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
                                            {!! Form::submit('Save', ['class' => 'customized-submit-button', 'id'=>'submit-agency']) !!}
                                        </div>

                                        {{-- {!! form::close(); !!} --}}
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
