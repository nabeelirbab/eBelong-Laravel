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
                        <h2>{{{ trans('lang.manage_users') }}}</h2>
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
                        @if ($users->count() > 0)
                            <table class="wt-tablecategories">
                                <thead>
                                    <tr>
                                        <th>{{{ trans('lang.user_name') }}}</th>
                                        <th>{{{ trans('lang.ph_email') }}}</th>
                                        <th>{{{ trans('lang.role') }}}</th>
                                        <th>{{{ trans('lang.joining_date') }}}</th>
                                        <th>{{{ trans('lang.invited_at') }}}</th>
                                        <th>{{{ trans('lang.invitation_status') }}}</th>
										<th>{{{ trans('lang.is_featured') }}}</th>
                                        <th>{{{ trans('lang.is_certified') }}}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user_data)
                                        @php $user = \App\User::find($user_data['id']); @endphp
                                        @if ($user->getRoleNames()->first() != 'admin')
                                            <tr class="del-user-{{ $user->id }}">
                                                <td>{{{ ucwords(\App\Helper::getUserName($user->id)) }}}</td>
                                                <td>{{{ $user->email }}}</td>
                                                <td>{{{ ucfirst($user->getRoleNames()->first()) }}}</td>
                                                <?php $default = "0000-00-00 00:00:00"; ?>                                               
                                                <td><?= date('d/m/Y', strtotime($user->created_at)) ?></td>
                                                <td>
                                                <?php
                                                if($user->invited_at > $default)
                                                    echo $user->invited_at;
                                                else
                                                    echo'-';

                                                ?>

                                                </td>
                                                <td>
                                                    @if($user->invitation_status==1)
                                                        {{ 'Invited' }}
                                                    @else
                                                        {{ 'Not Invited' }}
                                                    @endif
                                                </td>
												<td>
													<select id="{{$user->id}}-is_featured" v-on:change.prevent='changeFeaturedStatus({{$user->id}})'>
														<option value="0" {{ $user->is_featured == 0 ? "selected":"" }}>No</option>
														<option value="1" {{ $user->is_featured == 1 ? "selected":"" }}>Yes</option>
													</select>
												</td>
                                                <td>
													<select id="{{$user->id}}-is_certified" v-on:change.prevent='changeCertifiedStatus({{$user->id}})'>
														<option value="0" {{ $user->is_certified == 0 ? "selected":"" }}>No</option>
														<option value="1" {{ $user->is_certified == 1 ? "selected":"" }}>Yes</option>
													</select>
												</td>
                                                <td>
                                                    <div class="wt-actionbtn">
														<a href="{{ url('profile/'.$user->slug) }}" class="wt-addinfo wt-skillsaddinfo"><i class="lnr lnr-eye"></i></a>
													 
														<a href="{{ url('users/profile-edit/'.$user->id) }}" class="wt-addinfo wt-skillsaddinfo"><i class="fa fa-edit"></i></a>
														
                                                        <a href="javascript:void()" v-on:click.prevent="deleteUser({{$user->id}})" class="wt-deleteinfo wt-skillsaddinfo"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
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
                        @if ( method_exists($users,'links') )
                            {{ $users->links('pagination.custom') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
