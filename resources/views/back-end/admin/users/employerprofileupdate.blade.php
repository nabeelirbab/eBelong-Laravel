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
							<h2>Profile Update(Employer)</h2>
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
							<div class="wt-personalskillshold lare-employer-profile tab-pane active fade show" id="wt-profile">
								{!! Form::open(['url' => url('admin/store-employer-profile-settings'), 'class' =>'wt-userform', 'id' => 'employer_data', '@submit.prevent' => 'submitAdminEmployerProfile']) !!}
									<div class="wt-yourdetails wt-tabsinfo">
										<!-- For personal detail section -->
										<div class="wt-tabscontenttitle">
											<h2>{{{ trans('lang.your_details') }}}</h2>
										</div>
										<div class="lara-detail-form">
											<fieldset>
												<div class="form-group form-group-half">
													{!! Form::text( 'first_name', e($profile->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name')] ) !!}
												</div>
												<div class="form-group form-group-half">
													{!! Form::text( 'last_name', e($profile->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_last_name')] ) !!}
												</div>
												<div class="form-group">
													{!! Form::text( 'tagline', e($tagline), ['class' =>'form-control', 'placeholder' => trans('lang.ph_add_tagline')] ) !!}
												</div>
												<div class="form-group">
													{!! Form::textarea( 'description', e($description), ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc')] ) !!}
												</div>
											</fieldset>
										</div>
										<!-- End personal detail section -->
									</div>
									<div class="wt-profilephoto wt-tabsinfo">
										<!-- For profile photo section -->
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
															<figure><img src="{{{asset($image)}}}"  onerror="this.src='{{ asset('/uploads/settings/general/dummyuserimg.png') }}';" alt="{{{ trans('lang.profile_photo') }}}"></figure>
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
										<!-- End profile photo section -->	
									</div>
									<div class="wt-bannerphoto wt-tabsinfo">
										<!-- For Profile banner section -->	
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
																	:url="'{{url('admin/upload-temp-image')}}'"
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
																:url="'{{url('admin/upload-temp-image')}}'"
																:name="'hidden_banner_image'"
																>
															</upload-image>
															<input type="hidden" name="hidden_banner_image" id="hidden_banner"> 
														</div>
													@endif
												</div>
											</div>

										<!-- End Profile banner section -->	
									</div>
									@if($show_emplyr_inn_sec === 'true')
										<div class="wt-skills">
											<!-- For employee detail section -->
											<div class="wt-tabcompanyinfo wt-tabsinfo">
												<div class="wt-tabscontenttitle">
													<h2>{{{ trans('lang.company_details') }}}</h2>
												</div>
												<div class="wt-accordiondetails">
													<div class="wt-radioboxholder">
														<div class="wt-title">
															<h4>{{{ trans('lang.no_of_employees') }}}</h4>
														</div>
														@foreach ($employees as $key => $employee)
															<span class="wt-radio">
																	<input id="wt-just-{{{$key}}}" type="radio" name="employees" value="{{{$employee['value']}}}" 
																	{{($employee['value'] == $no_of_employees) ? 'checked' : ''}} >
																	<label for="wt-just-{{{$key}}}">{{{$employee['title']}}}</label>
															</span> 
														@endforeach
													</div>
													@if ($departments->count() > 0)
														<div class="wt-radioboxholder">
															<div class="wt-title">
																<h4>{{{ trans('lang.your_department') }}}</h4>
															</div>
															@foreach ($departments as $key => $department)
																<span class="wt-radio">
																	<input id="wt-department-{{{$department->id}}}" type="radio" name="department" value="{{{$department->id}}}" 
																	{{($department->id == $department_id) ? 'checked' : ''}}>
																	<label for="wt-department-{{{$department->id}}}">{{{$department->title}}}</label>
																</span>                                                        
															@endforeach
														</div>
													@endif  
												</div>
											</div>
											<!-- End employee detail section -->
										</div>
									@endif
									<div class="wt-location wt-tabsinfo">
										<!-- For employee location section -->
										<div class="wt-tabscontenttitle">
											<h2>{{ trans('lang.your_loc') }}</h2>
										</div>
										<div class="wt-formtheme">
											<fieldset>
												<div class="form-group form-group-half">
													<span class="wt-select">
														{!! Form::select('location', $locations, $profile->location_id ,array('class' => '', 'placeholder' => trans('lang.ph_select_location'))) !!}
													</span>
												</div>
												<div class="form-group form-group-half">
													{!! Form::text( 'address', e($address), ['class' =>'form-control', 'placeholder' => trans('lang.ph_your_address')] ) !!}
												</div>
												@if (!empty($longitude) && !empty($latitude))
													<div class="form-group wt-formmap">
														<div class="wt-locationmap">
															<custom-map :latitude="{{$latitude}}" :longitude="{{$longitude}}"></custom-map>
														</div>
													</div>
												@endif
												<div class="form-group form-group-half">
													{!! Form::text( 'longitude', e($longitude), ['class' =>'form-control', 'placeholder' => trans('lang.ph_enter_logitude')]) !!}
												</div>
												<div class="form-group form-group-half">
													{!! Form::text( 'latitude', e($latitude), ['class' =>'form-control', 'placeholder' => trans('lang.ph_enter_latitude')]) !!}
												</div>
											</fieldset>
										</div>
										<!-- End employee location section -->
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