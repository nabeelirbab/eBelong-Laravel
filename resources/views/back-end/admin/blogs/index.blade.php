@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
	<div class="wt-haslayout wt-dbsectionspace la-manage-jobs-holder">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-right" id="blog">
				<div class="preloader-section" v-if="loading" v-cloak>
					<div class="preloader-holder">
						<div class="loader"></div>
					</div>
				</div>
				<div class="wt-dashboardbox wt-dashboardservcies">
					<div class="wt-dashboardboxtitle wt-titlewithsearch">
						<h2>{{ trans('lang.blog_listing') }}</h2>
					</div>
					<div class="wt-dashboardboxcontent wt-categoriescontentholder">
						@if ($blogs->count() > 0)
							<table class="wt-tablecategories wt-tableservice">
								<thead>
									<tr>
										<th>{{ trans('lang.blog_title') }}</th>
										<th>{{ trans('lang.blog_status') }}</th>
										<th>Posted On</th>
										<th>Posted By</th>
										<th>Role</th>
										<th>{{ trans('lang.action') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($blogs as $blog)
										@php 
											$attachment = Helper::getUnserializeData($blog['attachments']); 
										@endphp
										<tr class="del-{{{ $blog['status'] }}}">
											<td data-th="Service Title">
												<span class="bt-content">
													
													<div class="wt-service-tabel">
														@if (!empty($attachment))
															<figure class="service-feature-image"><img src="{{{asset( Helper::getImageWithSize('uploads/blogs/'.$blog->id, $attachment[0], 'small' ))}}}" alt="{{{$blog['title']}}}"></figure>
														@endif
														<div class="wt-freelancers-content">
															<div class="dc-title">
																
																<h3>{{{$blog['title']}}}</h3>
																
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
																	{!! Form::select('status', $status_list, $blog['status'], array('id'=>$blog["id"].'-blog_status', 'data-placeholder' => trans('lang.select_status'))) !!}
																</span>
																<a href="javascrip:void(0);" class="wt-searchgbtn job_status_popup" @click.prevent='changeStatus({{$blog['id']}})'><i class="fa fa-check"></i></a>
															</div>
														</fieldset>
													</form>
												</span>
											</td>
											
											<td><?= date('d/m/Y', strtotime($blog->created_at)) ?></td>
											@if(!empty($blog->editor_id))
											<td> {{{ ucwords(\App\Helper::getUserName($blog->editor_id)) }}}</td>
											<td>{{ 'Editor' }}</td>
		                                    @endif
											
											<td data-th="Action">
												<span class="bt-content">
													<div class="wt-actionbtn">
														<a href="{{{route('BlogDetail',$blog['slug'])}}}" class="wt-viewinfo">
															<i class="lnr lnr-eye"></i>
														</a>
														<a href="{{{url('admin/dashboard/edit-blog/'.$blog['id'])}}}" class="wt-addinfo wt-skillsaddinfo">
															<i class="lnr lnr-pencil"></i>
														</a>
													        @php $role = \App\Helper::getSessionUserRole();@endphp
															<delete :title="'{{trans("lang.ph_delete_confirm_title")}}'" :id="'{{ $blog['id'] }}'" :message="'{{trans("lang.ph_blog_delete_message")}}'" :url="'{{url($role.'/dashboard/delete-blog')}}'"></delete>
													
														
													</div>
												</span>
											</td>
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
