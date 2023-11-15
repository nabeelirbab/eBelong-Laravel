@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
<div class="wt-haslayout wt-dbsectionspace">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 float-left" id="cources">
            <div class="preloader-section" v-if="loading" v-cloak>
                <div class="preloader-holder">
                    <div class="loader"></div>
                </div>
            </div>
            <div class="wt-haslayout wt-post-job-wrap">
                {!! Form::open(['url' => '', 'class' =>'wt-haslayout', 'id' => 'update_course_form','@submit.prevent'=>'updateCource("'.$cource->id.'")']) !!}
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{ trans('lang.update_course') }}</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.course_desc') }}</h2>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    <fieldset>
                                        <div class="form-group">
                                            {!! Form::text('title', e($cource->title), array('class' => 'form-control', 'placeholder' => trans('lang.course_title'))) !!}
                                        </div>
                                        <div class="form-group form-group-half wt-formwithlabel">
                                            <span class="wt-select">
                                                {!! Form::select('delivery_time', $delivery_time, e($cource->delivery_time_id), array('class' => '', 'placeholder' => trans('lang.select_delivery_time'))) !!}
                                            </span>
                                        </div>
                                        <div class="form-group form-group-half wt-formwithlabel job-cost-input">
                                            {!! Form::number('course_price', e($cource->price), array('class' => '', 'placeholder' => trans('lang.course_price'),'min'=>"1",'step' => 'any')) !!}
                                        </div>
                                        <div class="form-group form-group-half wt-formwithlabel job-cost-input">
                                            {!! Form::number('promotion_price',e($cource->promotion_price), array('class' => '','placeholder' => 'Promotion Price','min'=>"1",'step' => 'any')) !!}
                                        </div>
                                        <div class="form-group form-group-half wt-formwithlabel job-cost-input">
                                            {!! Form::date('course_date', e($cource->course_date), array('class' => '', 'placeholder' => 'Course Date')) !!}
                                        </div>
                                        <div class="form-group form-group-half wt-formwithlabel job-cost-input">
                                            {!! Form::time('course_time', e($cource->course_time), array('class' => '', 'placeholder' => 'Course Time')) !!}
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="wt-jobcategories wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.course_cats') }}</h2>
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    <div class="form-group">
                                        <span class="wt-select">
                                            {!! Form::select('categories[]', $categories, $cource->categories, array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_course_cats'))) !!}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="wt-languages-holder wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.course_response_time') }}</h2>
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    <div class="form-group">
                                        <span class="wt-select">
                                            {!! Form::select('response_time', $response_time, e($cource->response_time_id), array('class' => '', 'placeholder' => trans('lang.select_response_time'))) !!}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-half wt-formwithlabel">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.langs') }}</h2>
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    <div class="form-group">
                                        <span class="wt-select">
                                            {!! Form::select('languages[]', $languages, $cource->languages, array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_lang'))) !!}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-half wt-formwithlabel">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.english_level') }}</h2>
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    <div class="form-group">
                                        <span class="wt-select">
                                            {!! Form::select('english_level', $english_levels, e($cource->english_level), array('class' => '', 'placeholder' => trans('lang.select_english_level'))) !!}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="wt-jobdetails wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.service_desc') }}</h2>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    {!! Form::textarea('description', e($cource->description), ['class' => 'wt-tinymceeditor', 'id' => 'wt-tinymceeditor', 'placeholder' => trans('lang.service_desc_note')]) !!}
                                </div>
                            </div>
                            <div class="wt-joblocation wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.your_loc') }}</h2>
                                </div>
                                <div class="wt-formtheme wt-userform">
                                    <fieldset>
                                        <div class="form-group form-group-half">
                                            <span class="wt-select">
                                                {!! Form::select('locations', $locations, e($cource->location_id), array('class' => 'skill-dynamic-field', 'placeholder' => trans('lang.select_locations'))) !!}
                                            </span>
                                        </div>
                                        <div class="form-group form-group-half">
                                            {!! Form::text( 'address', e($cource->address), ['class' =>'form-control', 'placeholder' => trans('lang.your_address')] ) !!}
                                        </div>
                                        @if (!empty($cource->longitude) && !empty($cource->latitude))
                                            <div class="form-group wt-formmap">
                                                <div class="wt-locationmap">
                                                    <custom-map :latitude="{{$cource->longitude}}" :longitude="{{$cource->latitude}}"></custom-map>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group form-group-half">
                                            {!! Form::text( 'longitude', e($cource->longitude), ['class' =>'form-control', 'placeholder' => trans('lang.enter_logitude')]) !!}
                                        </div>
                                        <div class="form-group form-group-half">
                                            {!! Form::text( 'latitude', e($cource->latitude), ['class' =>'form-control', 'placeholder' => trans('lang.enter_latitude')]) !!}
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="wt-featuredholder wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.is_featured') }}</h2>
                                    <div class="wt-rightarea">
                                        <div class="wt-on-off float-right">
                                            <switch_button v-model="is_featured">{{{ trans('lang.is_featured') }}}</switch_button>
                                            <input type="hidden" :value="is_featured" name="is_featured">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wt-courses wt-tabsinfo">
                                <div class="wt-skills la-skills-holder wt-tabsinfo" id="wt-skills">
                                    <div class="wt-tabscontenttitle">
                                        <h2>{{ trans('lang.skills_req') }}</h2>
                                    </div>
                                    <div class="wt-formtheme wt-userform">
                                        {{-- add Course Skills --}}
                                        <cources_skills :ph_rate_skills="'{{ trans('lang.ph_rate_skills') }}'"></cources_skills>
                                    </div>
                                </div>
                            </div>
                            @if (!empty($freelancer))
                                <div class="wt-attachmentsholder">
                                    <div class="lara-attachment-files">
                                        <div class="wt-tabscontenttitle">
                                            <h2>{{ trans('lang.attachments') }}</h2>
                                            <div class="wt-rightarea">
                                                <div class="wt-on-off float-right">
                                                    <switch_button v-model="show_attachments">{{{ trans('lang.attachments_note') }}}</switch_button>
                                                    <input type="hidden" :value="show_attachments" name="show_attachments">
                                                </div>
                                            </div>
                                        </div>
                                        <image-attachments :temp_url="'{{url('cource/upload-temp-image')}}'" :type="'image'"></image-attachments>
                                        <div class="form-group input-preview">
                                            <ul class="wt-attachfile dropzone-previews">
                                                @if (!empty($attachments))
                                                    @php $count = 0; @endphp
                                                    @foreach ($attachments as $key => $attachment)
                                                    <li id="attachment-item-{{$key}}">
                                                        <span>{{{Helper::formateFileName($attachment)}}}</span>
                                                        <em>
                                                            @if (Storage::disk('local')->exists('uploads/courses/'.$freelancer->user_id.'/'.$attachment))
                                                                {{ trans('lang.file_size') }} {{{Helper::bytesToHuman(Storage::size('uploads/courses/'.$freelancer->user_id.'/'.$attachment))}}}
                                                            @endif
                                                            <a href="{{{route('getfile', ['type'=>'courses','attachment'=>$attachment,'id'=>$freelancer->user_id])}}}"><i class="lnr lnr-download"></i></a>
                                                            <a href="#" v-on:click.prevent="deleteAttachment('attachment-item-{{$key}}')"><i class="lnr lnr-cross"></i></a>
                                                        </em>
                                                        <input type="hidden" value="{{{$attachment}}}" class="" name="attachments[{{$key}}]">
                                                    </li>
                                                    @php $count++; @endphp
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="wt-updatall">
                        <i class="ti-announcement"></i>
                        <span>{{{ trans('lang.save_changes_note') }}}</span>
                        {!! Form::submit(trans('lang.post_course'), ['class' => 'wt-btn', 'id'=>'submit-course']) !!}
                    </div>
                {!! form::close(); !!}
            </div>
        </div>
    </div>
</div>
@endsection
