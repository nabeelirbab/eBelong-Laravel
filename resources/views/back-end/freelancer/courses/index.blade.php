@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
	<div class="wt-haslayout wt-dbsectionspace la-manage-jobs-holder">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-right" id="cources">
				<div class="preloader-section" v-if="loading" v-cloak>
					<div class="preloader-holder">
						<div class="loader"></div>
					</div>
				</div>
				<div class="wt-dashboardbox wt-dashboardservcies">
					<div class="wt-dashboardboxtitle wt-titlewithsearch">
						<h2>{{ trans('lang.cource_listing') }}</h2>
					</div>
					<div class="wt-dashboardboxcontent wt-categoriescontentholder">
						@if ($cources->count() > 0)
							<table class="wt-tablecategories wt-tableservice">
								<thead>
									<tr>
										<th>{{ trans('lang.course_title') }}</th>
										<th>{{ trans('lang.course_status') }}</th>
										<th>Students Enrolled</th>
										<th>Students On Wait</th>
										<th>{{ trans('lang.action') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($cources as $cource)
										@php 
											$attachment = Helper::getUnserializeData($cource['attachments']); 
											$total_orders = Helper::getcourceCount($cource['id'],'bought');
											$total_waiting_students = Helper::getcourceCount($cource['id'],'waiting');
										@endphp
										<tr class="del-{{{ $cource['status'] }}}">
											<td data-th="Service Title">
												<span class="bt-content">
													<div class="wt-service-tabel">
														@if (!empty($attachment))
															<figure class="service-feature-image"><img src="{{{asset( Helper::getImageWithSize('uploads/courses/'.Auth::user()->id, $attachment[0], 'small' ))}}}" alt="{{{$cource['title']}}}"></figure>
														@endif
														<div class="wt-freelancers-content">
															<div class="dc-title">
																@if ($cource['is_featured'] == 'true')
																	<span class="wt-featuredtagvtwo">Featured</span>
																@endif
																<h3>{{{$cource['title']}}}</h3>
																@if(isset($cource->promotion_price) && $cource->promotion_price > 0)
																<span><strong><del>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}{{ $cource->price }}</del> {{ !empty($symbol) ? $symbol['symbol'] : '$' }}{{ $cource->promotion_price }}</strong></span>
																
																@else
																<span><strong>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}{{{$cource['price']}}}</strong> {{ trans('lang.starting_from') }}</span>
																@endif
															
															</div>
														</div>
													</div>
												</span>
											</td>
											<td data-th="Service Status">
												<span class="bt-content">
													<form class="wt-formtheme wt-formsearch" id="change_job_status">
														<fieldset>
															<div class="form-group">
																<span class="wt-select">
																	{!! Form::select('status', $status_list, $cource['status'], array('id'=>$cource["id"].'-cource_status', 'data-placeholder' => trans('lang.select_status'))) !!}
																</span>
																<a href="javascrip:void(0);" class="wt-searchgbtn job_status_popup" @click.prevent='changeStatus({{$cource['id']}})'><i class="fa fa-check"></i></a>
															</div>
														</fieldset>
													</form>
												</span>
											</td>
											<td data-th="In Queue">
												<span class="bt-content">
													<span>
														@if ($total_orders > 0)
														<a href="/course/{{ $cource["id"] }}/enrolled-students">
															<i class="fa fa-spinner fa-spin"></i> 
															{{{$total_orders}}} Students Enrolled
														</a>
														@else
														<a href="#" >0 Students Enrolled</a>
														@endif
														
													</span>
												</span>
											</td>
											<td data-th="In Queue">
												<span class="bt-content">
													<span>
														@if ($total_waiting_students > 0)
														<a href="/course/{{ $cource["id"] }}/waiting-students">
															<i class="fa fa-spinner fa-spin"></i> 
															{{{$total_waiting_students}}} Students waiting for Approval
														</a>
														@else
														<a href="#" >0 Students on Wait</a>
														@endif
														
													</span>
												</span>
											</td>
											<td data-th="Action">
												<span class="bt-content">
													<div class="wt-actionbtn">
														<a href="{{{route('CourceDetail',$cource['slug'])}}}" class="wt-viewinfo">
															<i class="lnr lnr-eye"></i>
														</a>
														<a href="{{{route('edit_course',$cource['id'])}}}" class="wt-addinfo wt-skillsaddinfo">
															<i class="lnr lnr-pencil"></i>
														</a>
														@if ($total_orders == 0)
															<delete :title="'{{trans("lang.ph_delete_confirm_title")}}'" :id="'{{ $cource['id'] }}'" :message="'{{trans("lang.ph_course_delete_message")}}'" :url="'{{url('freelancer/dashboard/delete-course')}}'"></delete>
														@endif
														@if ($total_orders > 0)
														<a href="javascript:void(0);"  v-on:click.prevent="getMessageForm({{ $cource['id'] }})" class="wt-addinfo wt-skillsaddinfo" v-cloak>
															<i class="fas fa-envelope-open"></i>
														</a>
														@endif
													</div>
												</span>
											</td>
										</tr>
										<b-modal ref="myModalRef-{{ $cource['id'] }}" hide-footer title="Send Message to All Students">
											<div class="d-block text-center">
												<form class="wt-formtheme wt-form-paycard" id="course-message-form-{{ $cource['id'] }}" >
													
													<fieldset>
														<div class="form-group wt-inputwithicon">
															<label>{{ 'Message' }}</label>
															<textarea class="form-control" id="message-{{ $cource['id'] }}" name="message-{{ $cource['id'] }}" ></textarea>
														</div>
														{{-- <input type="text" class="form-control" value="hello"> --}}
														<div class="form-group wt-btnarea">
															<a class="wt-btn" href="javascript:void(0);" v-on:click='sendMessage({{ $cource['id'] }})'>Send</a>
														</div>
													</fieldset>
												</form>
											</b-modal>	
									@endforeach
								</tbody>
							</table>
						@else
							@if (file_exists(resource_path('views/extend/errors/no-record.blade.php'))) 
								@include('extend.errors.no-record')
							@else 
								@include('errors.no-record')
							@endif
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
