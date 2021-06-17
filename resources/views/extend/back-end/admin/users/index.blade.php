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
                                        <th>
                                            {{{ trans('lang.user_name') }}}
                                            <!--@sortablelink('first_name', trans('lang.user_name') )-->
                                        </th>
                                        <th>
                                            {{{ trans('lang.ph_email') }}}
                                            <!--@sortablelink('email',trans('lang.ph_email'), ['filter' => 'active, visible'], ['rel' => 'nofollow'])-->
                                        </th>
                                        <th>
                                             {{{ trans('lang.role') }}}
                                            <!--@sortablelink('role',trans('lang.role'))-->
                                        </th>
                                        <th>
                                             {{{ trans('lang.location') }}}
                                            <!--@sortablelink('location',trans('lang.location'))-->
                                        </th>
                                        <th>
                                            {{{ trans('lang.city') }}}
                                            <!--@sortablelink('city',trans('lang.city'))-->
                                        </th>
                                        <th>
                                            {{{ trans('lang.state') }}}
                                            <!--@sortablelink('state',trans('lang.state'))-->
                                        </th>
                                        <th>
                                            {{{ trans('lang.joining_date') }}}
                                            <!--@sortablelink('joining_date',trans('lang.joining_date'))-->
                                        </th>
                                        <th>
                                            {{{ trans('lang.updated_at') }}}
                                            <!--@sortablelink('updated_at',trans('lang.updated_at'))-->
                                        </th>
                                        <th>
                                            {{{ trans('lang.invited_at') }}}
                                            <!--@sortablelink('invited_at',trans('lang.invited_at'))-->
                                        </th>
                                        <th>
                                            {{{ trans('lang.invitation_status') }}}
                                            <!--@sortablelink('invitation_status',trans('lang.invitation_status'))-->
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($users->count())
                                    @foreach ($users as $key => $user_data)
                                        @php $user = \App\User::find($user_data['id']); @endphp
                                        @if ($user->getRoleNames()->first() != 'admin')
                                            <tr class="del-user-{{ $user->id }}">
                                                <td>{{{ ucwords(\App\Helper::getUserName($user->id)) }}}</td>
                                                <td>{{{ $user->email }}}</td>
                                                <td>{{ $user->getRoleNames()->first() }}</td>
                                                <td>{{ ucwords(\App\Location::getLocationName($user->location_id)) }}</td>
                                                <td>{{ $user->city }}</td>
                                                <td>{{ $user->state }}</td>
                                                 <td>{{ $user->created_at }}</td>
                                                  <td>{{ $user->updated_at }}</td>
                                                   <td>{{ $user->invited_at }}</td>
                                                    <td>
                                                        @if($user->invitation_status==1)
                                                                {{ 'Invited' }}
                                                        @else
                                                                 {{ 'Direct' }}
                                                        @endif
                                                    </td>
                                                <td>
                                                    <div class="wt-actionbtn">
                                                        <a href="javascript:void()" v-on:click.prevent="deleteUser({{$user->id}})" class="wt-deleteinfo wt-skillsaddinfo"><i class="fa fa-trash"></i></a>
                                                        <a href="{{ url('profile/'.$user->slug) }}" class="wt-addinfo wt-skillsaddinfo"><i class="lnr lnr-eye"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        <!--{!! $users->appends(\Request::except('page'))->render() !!}-->
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
