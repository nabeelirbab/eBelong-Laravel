@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace freelancer-profile" id="user_profile">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-right">
                @if (Session::has('message'))
                    <div class="flash_msg">
                        <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
                    </div>
                @endif
				<div class="container">
					<div class="wt-dashboardbox">
						<div class="wt-dashboardboxtitle wt-titlewithsearch">
							<h2>Profile Update(Freelancer)</h2> 
							
						</div>
						<div class="wt-dashboardboxcontent wt-categoriescontentholder">
							@if ($errors->any())
								<ul class="wt-jobalerts">
									@foreach ($errors->all() as $error)
										<div class="flash_msg">
											<flash_messages :message_class="'danger'" :time ='10' :message="'{{{ $error }}}'" v-cloak></flash_messages>
										</div>
									@endforeach
								</ul>
							@endif
							<div class="wt-personalskillshold tab-pane active fade show" id="wt-skills">
								{!! Form::open(['url' => '', 'class' =>'wt-userform', 'id' => 'freelancer_profile', '@submit.prevent'=>'submitAdminFreelancerProfile']) !!}
									<div class="wt-yourdetails wt-tabsinfo">
										<div class="wt-tabscontenttitle">
											<h2>{{{ trans('lang.your_details') }}}</h2>
										</div>
										<div class="wt-settingscontent">
												<div class="form-group form-group-half">
													<span class="wt-select">
														{!! Form::select( 'status', [1 => 'Active', 0 => 'Deactivate'], e($status), ['placeholder' => 'Select Status'] ) !!}
													</span>
												</div>
												<div class="form-group form-group-half">
													<span class="wt-select">
														{!! Form::select( 'gender', ['male' => 'Male', 'female' => 'Female'], e($gender), ['placeholder' => trans('lang.ph_select_gender')] ) !!}
													</span>
												</div>
												<div class="form-group form-group-half">
													{!! Form::text( 'first_name', e($profile->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name')] ) !!}
												</div>
												<div class="form-group form-group-half">
													{!! Form::text( 'last_name', e($profile->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_last_name')] ) !!}
												</div>
												<div class="form-group form-group-half">
													{!! Form::number( 'hourly_rate', e($hourly_rate), ['class' =>'form-control', 'placeholder' => trans('lang.ph_service_hoyrly_rate')] ) !!}
												</div>
												<div class="form-group">
													{!! Form::text( 'tagline', e($tagline), ['class' =>'form-control', 'placeholder' => trans('lang.ph_add_tagline')] ) !!}
												</div>
												<div class="form-group">
													{!! Form::textarea( 'description', e($description), ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc')] ) !!}
												</div>

												<div class="form-group">
													<span class="wt-select">
														@php
															$categoryArr = array();
															foreach($categories as $cs){
																$categoryArr[$cs->id] = $cs->title;
															}
														@endphp
														{!! Form::select( 'category_id',$categoryArr,e($selectedcategories), ['class' =>'form-control', 'placeholder' => trans('lang.ph_cat_lbl')] ) !!}
													</span>
												</div>
										</div>
									</div>
									<div class="wt-profilephoto wt-tabsinfo">
										<div class="wt-location wt-tabsinfo">
											<div class="wt-tabscontenttitle">
												<h2>{{{ trans('lang.profile_photo') }}}</h2>
											</div>
											<div class="wt-settingscontent">
												@if (!empty($avater))
													@php  
														$image = '/uploads/users/'.$profile->id.'/'.$avater; 
													@endphp
													<div class="wt-formtheme wt-userform">
														<div v-if="this.uploaded_image">
															<upload-image 
																:id="'avater_id'" 
																:img_ref="'avater_ref'" 
																:url="'{{url('admin/upload-temp-image')}}'"
																:name="'hidden_avater_image'"
																>
															</upload-image>
														</div>
														<div class="wt-uploadingbox" v-else>
															<figure><img src="{{{asset($image)}}}" onerror="this.src='{{ asset('/uploads/settings/general/dummyuserimg.png') }}';" alt="{{{ trans('lang.profile_photo') }}}"></figure>
															<div class="wt-uploadingbar">
																<div class="dz-filename">{{{$avater}}}</div>
																<em>{{{ trans('lang.file_size') }}}<a href="javascript:void(0);" class="lnr lnr-cross" v-on:click.prevent="removeImage('hidden_avater')"></a></em>
															</div>
														</div>
														<input type="hidden" name="hidden_avater_image" id="hidden_avater" value="{{{$avater}}}"> 
													</div>
												@else
													<div class="wt-formtheme wt-userform">
														<upload-image 
															:id="'avater_id'" 
															:img_ref="'avater_ref'" 
															:url="'{{url('admin/upload-temp-image')}}'"
															:name="'hidden_avater_image'"
															>
														</upload-image>
														<input type="hidden" name="hidden_avater_image" id="hidden_avater"> 
													</div>
												@endif
											</div>
										</div>
									</div>
								
									@if (!empty($options) && $options['banner_option'] === 'true')
										<div class="wt-location wt-tabsinfo">
											<div class="wt-tabscontenttitle">
												<h2>{{{ trans('lang.banner_photo') }}}</h2>
											</div>
											<div class="wt-settingscontent">
												@if (!empty($banner))
													@php $image = '/uploads/users/'.$profile->id.'/'.$banner; @endphp
													<div class="wt-formtheme wt-userform">
														<div v-if="this.uploaded_banner">
															<upload-image 
																:id="'banner_id'" 
																:img_ref="'banner_ref'" 
																:url="'{{url('freelancer/upload-temp-image')}}'"
																:name="'hidden_banner_image'"
																>
															</upload-image>
														</div>
														<div class="wt-uploadingbox" v-else>
															<figure><img src="{{{asset($image)}}}" alt="{{{ trans('lang.profile_photo') }}}"></figure>
															<div class="wt-uploadingbar">
																<div class="dz-filename">{{{$banner}}}</div>
																<em>{{{ trans('lang.file_size') }}}<a href="javascript:void(0);" class="lnr lnr-cross" v-on:click.prevent="removeBanner('hidden_banner')"></a></em>
															</div>
														</div>
														<input type="hidden" name="hidden_banner_image" id="hidden_banner" value="{{{$banner}}}"> 
													</div>
												@else
													<div class="wt-formtheme wt-userform">
														<upload-image 
															:id="'banner_id'" 
															:img_ref="'banner_ref'" 
															:url="'{{url('freelancer/upload-temp-image')}}'"
															:name="'hidden_banner_image'"
															>
														</upload-image>
														<input type="hidden" name="hidden_banner_image" id="hidden_banner"> 
													</div>
												@endif
											</div>
										</div>
									@endif
									<div class="wt-location wt-tabsinfo">
										<div class="wt-tabscontenttitle">
											<h2>{{trans('lang.your_loc')}}</h2>
										</div>
										<div class="wt-formtheme">
											<fieldset>
												<div class="form-group form-group-half">
													<span class="wt-select">
														{!! Form::select('location', $locations, $profile->location_id ,array('class' => '', 'placeholder' => trans('lang.select_location'))) !!}
													</span>
												</div>
												<div class="form-group form-group-half">
													{!! Form::text( 'address', e($address), ['class' =>'form-control', 'placeholder' => trans('lang.your_address')] ) !!}
												</div>
												@if (!empty($longitude) && !empty($latitude))
													<div class="form-group wt-formmap">
														<div class="wt-locationmap">
															<custom-map :latitude="{{$latitude}}" :longitude="{{$longitude}}"></custom-map>
														</div>
													</div>
												@endif
												<div class="form-group form-group-half">
													{!! Form::text( 'longitude', e($longitude), ['class' =>'form-control', 'placeholder' => trans('lang.enter_logitude')] ) !!}
												</div>
												<div class="form-group form-group-half">
													{!! Form::text( 'latitude', e($latitude), ['class' =>'form-control', 'placeholder' => trans('lang.enter_latitude')] ) !!}
												</div>
											</fieldset>
										</div>
									</div>
									<div class="wt-videos-holder wt-tabsinfo la-footer-setting">
										<div class="wt-tabscontenttitle">
											<h2>{{{ trans('lang.videos') }}}</h2>
										</div>
										<div class="wt-skillsform">
											<fieldset class="social-icons-content">
												@if (!empty($videos))
													@php $counter = 0 @endphp
													@foreach ($videos as $video_key => $mem_value)
														<div class="wrap-social-icons wt-haslayout">
															<div class="form-group">
																<div class="form-group-holder">
																	{!! Form::text('video['.$counter.'][url]', e($mem_value['url']),
																	['class' => 'form-control']) !!}
																</div>
																<div class="form-group wt-rightarea">
																	@if ($video_key == 0 )
																		<span class="wt-addinfobtn" @click="addVideo"><i class="fa fa-plus"></i></span> 
																	@else
																		<span class="wt-addinfobtn wt-deleteinfo delete-social" data-check="{{{$counter}}}">
																			<i class="fa fa-trash"></i>
																		</span>
																	@endif
																</div>
															</div>
														</div>
														@php $counter++; @endphp
													@endforeach
												@else
													<div class="wrap-social-icons wt-haslayout">
														<div class="form-group">
															<div class="form-group-holder">
																{!! Form::text('video[0][url]', null, ['class' => 'form-control',
																	'placeholder' => trans('lang.video_url')])
																!!}
															</div>
															<div class="form-group wt-rightarea">
																<span class="wt-addinfobtn" @click="addVideo"><i class="fa fa-plus"></i></span>
															</div>
														</div>
														
													</div>
												@endif
													<div v-for="(video, index) in videos" v-cloak>
														<div class="wrap-social-icons wt-haslayout">
															<div class="form-group">
																<div class="form-group-holder">
																	<input v-bind:name="'video['+[video.count]+'][url]'" type="text" class="form-control"
																	v-model="video.url" placeholder="{{trans('lang.video_url')}}">
																</div>
																<div class="form-group wt-rightarea">
																	<span class="wt-addinfobtn wt-deleteinfo" @click="removeVideo(index)"><i class="fa fa-trash"></i></span>
																</div>
															</div>
														</div>
													</div>
											</fieldset>
										</div>
									</div>
									<div class="wt-updatall">
										<i class="ti-announcement"></i>
										<span>{{{ trans('lang.save_changes_note') }}}</span>
										<input type="hidden" name="user_id" value="{{ $profile->id }}" />
										{!! Form::submit(trans('lang.btn_save_update'), ['class' => 'wt-btn', 'id'=>'submit-profile']) !!}
									</div>
								{!! form::close(); !!}
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>

@endsection
@push('script')
	<script type="text/javascript">
	$('#change_status').click(function()
	{
		console.log('YEs');
	})
</script>

@endpush

