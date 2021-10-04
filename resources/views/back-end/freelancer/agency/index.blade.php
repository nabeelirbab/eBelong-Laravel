@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
<section class="wt-haslayout wt-dbsectionspace" id="profile_settings">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-right">
			@if (Session::has('message'))
				<div class="flash_msg">
					<flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages> 
				</div>
			@endif
			<div class="wt-dashboardbox">
				<div class="wt-dashboardboxtitle wt-titlewithsearch"> 
					<h2>{{{ trans('lang.agency_user') }}}</h2>
					<form class="wt-formtheme wt-formsearch">
						<fieldset>
							<div class="form-group">
								<input type="text" name="keyword" value="{{{ !empty($_GET['keyword']) ? $_GET['keyword'] : '' }}}"
									class="form-control" placeholder="{{{ trans('lang.ph_search_users') }}}">
								<button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="wt-dashboardboxcontent wt-categoriescontentholder">
					@if ($agency_users->count() > 0)
						<table class="wt-tablecategories">
							<thead>
								<tr>
									<th>{{{ trans('lang.user_name') }}}</th>
									<th>{{{ trans('lang.ph_email') }}}</th>
									<th>{{{ trans('lang.role') }}}</th>
									<th>{{{ trans('lang.agency_name') }}}</th>
									<th>{{{ trans('lang.status') }}}</th>
								</tr>
							</thead> 
							<tbody>
								@foreach($agency_users as $key => $agency_data)
									@php  
										$user = \App\User::find($agency_data->id); 
									@endphp
									<tr class="del-user-{{ $user->id }}">
										<td>{{{ ucwords(\App\Helper::getUserName($user->id)) }}}</td>
										<td>{{{ $user->email }}}</td>
										<td>{{ $user->getRoleNames()->first() }}</td>
										<td>{{ $agency_data->agency_name }}</td>
										<td>
											@if($agency_data->agency_status == 1)
												{{ "Approved" }}
											@else	 
												<select class="form-control" v-on:change.prevent="changeAgencyStatus({{$user->id}})">
													<option value="0" selected disabled>Pendding</option>
													<option value="1">Approve</option>
												</select>
											@endif
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
					@if ( method_exists($agency_users,'links') )
						{{ $agency_users->links('pagination.custom') }}
					@endif
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
