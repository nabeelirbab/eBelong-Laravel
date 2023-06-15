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
                {!! Form::open(['url' => '', 'class' =>'wt-haslayout', 'id' => 'post_cource_form',  '@submit.prevent'=>'submitCource']) !!}
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{ trans('lang.post_course') }}</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.course_desc') }}</h2>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    <fieldset>
                                        <div class="form-group">
                                            <input type="text" name="title" id="title" class="form-control" placeholder="{{ trans('lang.course_title') }}" v-model="title">
                                        </div>
                                        <div class="form-group form-group-half wt-formwithlabel">
                                            <span class="wt-select">
                                                {!! Form::select('delivery_time', $delivery_time, null, array('class' => '', 'placeholder' => trans('lang.select_delivery_time'), 'v-model'=>'delivery_time')) !!}
                                            </span>
                                        </div>
                                        <div class="form-group form-group-half wt-formwithlabel job-cost-input">
                                            {!! Form::number('course_price', null, array('class' => '', 'placeholder' => trans('lang.course_price'), 'v-model'=>'price','min'=>"1",'step' => 'any')) !!}
                                        </div>

                                        <div class="form-group form-group-half wt-formwithlabel">
                                            <span class="wt-select">
                                               <select class="form-control" name="user_type">
                                                   <option value="">Select Type</option>
                                                   <option>Remote</option>
                                                   <option>In-Person</option>
                                               </select>
                                            </span>
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
                                            {!! Form::select('categories[]', $categories, null, array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_course_cats'))) !!}
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
                                            {!! Form::select('response_time', $response_time, null, array('class' => '', 'placeholder' => trans('lang.select_response_time'), 'v-model'=>'response_time')) !!}
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
                                            {!! Form::select('languages[]', $languages, null, array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_lang'))) !!}
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
                                            {!! Form::select('english_level', $english_levels, null, array('class' => '', 'placeholder' => trans('lang.select_english_level'), 'v-model'=>'english_level')) !!}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="wt-jobdetails wt-tabsinfo">
                                <div class="wt-tabscontenttitle d-flex justify-content-between">
                                    <h2>{{ trans('lang.job_dtl') }}</h2>
                                    <buttom class="btn btn-sm btn-success" onclick="generateCompletion()" id="mainButton">Complete with ChatGPT</buttom>
                                    <button class="btn btn-primary" style="display: none" id="loader" type="button" disabled>
                                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                      Loading...
                                    </button>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    {!! Form::textarea('description', null, ['class' => 'wt-tinymceeditor', 'id' => 'wt-tinymceeditor', 'placeholder' => trans('lang.service_desc_note')]) !!}
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
                                                {!! Form::select('locations', $locations, null, array('class' => 'skill-dynamic-field', 'placeholder' => trans('lang.select_locations'))) !!}
                                            </span>
                                        </div>
                                        <div class="form-group form-group-half">
                                            {!! Form::text( 'address', null, ['class' =>'form-control', 'id' => 'address', 'placeholder' => trans('lang.your_address')] ) !!}
                                        </div>
                                        @if (!empty($longitude) && !empty($latitude))
                                            <div class="form-group wt-formmap">
                                                <div class="wt-locationmap">
                                                    <custom-map :latitude="{{$latitude}}" :longitude="{{$longitude}}"></custom-map>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group wt-formmap" id="googleMap" style="display: none;">
                                                <div class="wt-locationmap">
                                                    <div id="map" style="width: 100%; height: 400px;"></div>
                                                </div>
                                            </div>
                                        <div class="form-group form-group-half">
                                            <input type="hidden" id="lat" name="longitude">
                                            <!-- {!! Form::hidden( 'longitude', null, ['class' =>'form-control', 'id' => 'lat', 'placeholder' => trans('lang.enter_logitude')]) !!} -->
                                        </div>
                                        <div class="form-group form-group-half">
                                            <input type="hidden" id="lng" name="latitude">
                                            <!-- {!! Form::hidden( 'latitude', null, ['class' =>'form-control', 'id' => 'lng', 'placeholder' => trans('lang.enter_latitude')]) !!} -->
                                        </div>
                                        <!-- <div class="wt-jobskills wt-jobskills-holder wt-tabsinfo">
                                            
                                            
                                        </div> -->
                                        
                                    </fieldset>
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

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wt-updatall">
                        <i class="ti-announcement"></i>
                        <span>{{{ trans('lang.save_changes_note') }}}</span>
                        {!! Form::submit(trans('lang.post_course'), ['class' => 'wt-btn', 'id'=>'submit-service']) !!}
                    </div>
                {!! form::close(); !!}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkCYdMuRkyApHONAWqjzNYYvYX2INz-nM&libraries=places&callback=initialize" async defer></script>

    <script>
function initialize() {
   // initializeAutocomplete_home();
   initAutocomplete();
}
var map;
        function initAutocomplete() {
       var addressInput = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(addressInput);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();

            if (!place.geometry) {
                // Handle the case when the selected place has no geometry.
                return;
            }

            // Retrieve the latitude and longitude values
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();

            // Assign the lat and lng values to input fields
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
            document.getElementById('googleMap').style.display = 'block';

            // Create a map centered at the selected location
            var mapContainer = document.getElementById('map');
            map = new google.maps.Map(mapContainer, {
                center: { lat: lat, lng: lng },
                zoom: 15
            });

            // Add a marker at the selected location
            var marker = new google.maps.Marker({
                position: { lat: lat, lng: lng },
                map: map
            });
        });
        }
    </script>
     <script type="text/javascript">
        function generateCompletion(){
            $('#mainButton').hide();
            document.getElementById('loader').style.display = 'block';
            tinymce.init({
                  selector: '#wt-tinymceeditor',
                  // Add other configuration options as needed
                });
              var title = $('#title').val();
             $.ajax({
                url: '{{url("generate-completion")}}?cmd=write description for '+title+' course',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    document.getElementById('loader').style.display = 'none';
                    $('#mainButton').show();
                    tinymce.get('wt-tinymceeditor').setContent(response);
                    // document.getElementById('wt-tinymceeditor').value = response;
                    console.log(response);
                },
                error: function(error) {
                    // Handle the error
                    console.error(error);
                }
            });
        }
       
    </script>
 @endpush