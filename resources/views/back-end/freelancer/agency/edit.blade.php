@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')

    <section class="wt-haslayout wt-dbsectionspace">
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
                            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class='wt-tabscontenttitle'>
                    <h2>Edit your Agency</h2>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9" id="agency">
                        <div class="wt-dashboardbox wt-dashboardtabsholder">
                            <div class="wt-location wt-tabsinfo agency-selection-form">
                                <div class='wt-settingscontent'>
                                    <form action="{{ route('agencyDataEdit') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class='wt-formtheme wt-userform agency-form'>
                                            <div class="row" style="padding-top: 20px">
                                                <div class="col-md-6">
                                                    <input type="hidden" name="agency_id"  value="{{$agency->id}}">
                                                    <div class="form-group">
                                                        <input type="text" name="agency_name" placeholder="Agency Name" class="form-control" value="{{$agency->agency_name}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" name="contact_no" placeholder="Agency Contact No" class="form-control" value="{{ $agency->contact_no }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="contact_email" placeholder="Agency Email" class="form-control"  value="{{ $agency->contact_email }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" name="founded_in" placeholder="Founded Year" class="form-control"  value="{{ $agency->founded_in }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group input-preview">
                                                        <input type="file" name="agency_logo" class="form-control">
                                            <ul class="wt-attachfile dropzone-previews">
                                                @if (!empty($agency->agency_logo))
                                                <li id="attachment-item-{{$agency->id}}">
                                                <span>{{$agency->agency_logo}}</span>
                                                <em>
                                                    @if (Storage::disk('local')->exists('uploads/courses/'.$agency->id.'/'.$agency->agency_logo))
                                                        {{ trans('lang.file_size') }} {{{Helper::bytesToHuman(Storage::size('uploads/agaency_logos/'.$agency->id.'/'.$agency->agency_logo))}}}
                                                    @endif
                                                    <a href="{{{route('getfile', ['type'=>'agency_logos','attachment'=>$agency->agency_logo,'id'=>$agency->id])}}}"><i class="lnr lnr-download"></i></a>
                                                    {{-- <a href="javascript:void(0)" v-on:click.prevent="deleteAttachment('attachment-item-{{$agency->id}}')"><i class="lnr lnr-cross"></i></a> --}}
                                                </em>
                                            </li>
                                                @endif
                                                </ul>
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
                                                        <textarea class="form-control" name="description" id=""  placeholder="Enter agency Description" cols="30" rows="20">{{ $agency->description }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" name="hourly_rates_min" placeholder="Hourly Min Rate" class="form-control"  value="{{ $agency->hourly_rates_min }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" name="hourly_rates_max" placeholder="Hourly Max Rate" class="form-control"  value="{{ $agency->hourly_rates_max }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group" placeholder="Agency size" >
                                                        <select class="col-md-6" name="agency_size" id="agency_size" >
                                                            <option value="1-10"<?php echo $agency->agency_size == '1-10' ? 'selected' : ''?>>Up to 10</option>
                                                            <option value="11-100"<?php echo $agency->agency_size == '11-100' ? 'selected' : ''?>>11-100</option>
                                                            <option value="101-1000"<?php echo $agency->agency_size == '101-1000' ? 'selected' : ''?>>101-1000</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php //print_r($skills); ?>
                                                <!-- <div class="col-md-12">
                                                    <div class="wt-skills la-skills-holder wt-tabsinfo">
                                                        <div class="wt-tabscontenttitle">
                                                            <h2>Agency Skills</h2>
                                                        </div>
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
                                                <div class="col-md-12">
                                                    <div class="row">
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
                                                </div>
                                            </div>
                                            <input class= "customized-submit-button" type="submit" value="Edit">
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
