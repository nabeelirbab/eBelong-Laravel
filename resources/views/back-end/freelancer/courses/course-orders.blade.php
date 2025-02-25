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
						<h2>{{ trans('lang.course_orders') }}</h2>
					</div>
					<div class="wt-dashboardboxcontent wt-categoriescontentholder">
						@if ($courses->count() > 0)
							<table class="wt-tablecategories wt-tableservice">
								<thead>
									<tr>
										<th>{{ trans('lang.course_title') }}</th>
										<th>{{ 'Student Name' }}</th>
										<th>{{ trans('lang.course_status') }}</th>
										<th>{{ 'Placed Order On:' }}</th>
										<th>Students Enrolled</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($courses as $course)
										@php 
										    $username = ucwords(\App\Helper::getUserName($course->user_id));
                                            $cource = App\Cource::find($course->cource_id);
											$seller = $course->seller_id;
											$attachment = Helper::getUnserializeData($cource['attachments']); 
											$total_orders = Helper::getcourceCount($cource['id'],'bought');
											$order = App\Invoice::find($course->invoice_id);
										@endphp
										<tr class="del-{{{ $cource['status'] }}}">
											<td data-th="Service Title">
												<span class="bt-content">
													<div class="wt-service-tabel">
														@if (!empty($attachment))
															<figure class="service-feature-image"><img src="{{{asset( Helper::getImageWithSize('uploads/courses/'.$seller, $attachment[0], 'small' ))}}}" alt="{{{$cource['title']}}}"></figure>
														@endif
														<div class="wt-freelancers-content">
															<div class="dc-title">
																@if ($cource['is_featured'] == 'true')
																	<span class="wt-featuredtagvtwo">Featured</span>
																@endif
																<h3>{{{$cource['title']}}}</h3>
																<span><strong>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}{{{$cource['price']}}}</strong></span>
																<span><b>Posted On: </b>{{$cource['created_at']->format('d-m-Y')}}</span>
															</div>
														</div>
													</div>
												</span>
											</td>
											<td>{{ $username }}</td>
											<td data-th="Service Status">
												<span class="bt-content">
													<form class="wt-formtheme wt-formsearch" id="change_job_status">
														<fieldset>
															<div class="form-group">
																<span class="wt-select">
																	{!! Form::select('status', $status_list, $course->status, array('id'=>$course->id.'-course_status', 'data-placeholder' => trans('lang.select_status'))) !!}
																</span>
																<a href="javascrip:void(0);" class="wt-searchgbtn job_status_popup" @click.prevent='changeCourseStatus({{$course->id}})'><i class="fa fa-check"></i></a>
															</div>
														</fieldset>
													</form>
												</span>
											</td>
											
											<td><b>{{ $order['created_at']->format('d-m-Y') }}</b></td>
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
											{{-- <td data-th="Action">
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
													</div>
												</span>
											</td> --}}
										</tr>	
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
