@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')

<!-- <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

<script src="//code.jquery.com/jquery.js"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" defer></script>
<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->

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
                                        <th>Member Name</th>
                                        <th>Member Role</th>
										<th>is Pending</th>
                                        <th>is Accepted</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                       
                                            <tr class="del-user-{{ $user->user_id }}">
                                                <td>{{{ ucwords(\App\Helper::getUserName($user->user_id)) }}}</td>
                                                <td>{{ $user->member_role }}</td>                                          
                                                <td>
                                                    @if($user->is_pending==1)
                                                        {{ 'Pending' }}
                                                    @else
                                                        {{ 'Not Pending' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($user->is_accepted==1)
                                                        {{ 'Accepted' }}
                                                    @else
                                                        {{ 'Not Accepted' }}
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
                        @if ( method_exists($users,'links') )
                            {{ $users->links('pagination.custom') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

{{--    <section class="custome-datatable">--}}
{{--        <div class="row">--}}
{{--            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-right">--}}
{{--                <div class="wt-dashboardbox">--}}
{{--                    <div class="wt-dashboardboxtitle wt-titlewithsearch">--}}
{{--                        <h2>{{{ trans('lang.manage_users') }}}</h2>--}}
{{--                    </div>--}}
{{--                    <div class="panel">--}}
{{--                        <!-- <div class="panel-heading">Server Side Datatable in Laravel 5</div> -->--}}
{{--                        <div class="panel-body wt-dashboardboxcontent wt-categoriescontentholder">    --}}
{{--                            <table class="table table-bordered wt-tablecategories" id="users-table">--}}
{{--                                <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>Id</th>--}}
{{--                                        <th>Name</th>--}}
{{--                                        <th>Status</th>--}}
{{--                                        <th>Email</th>--}}
{{--                                        <th>Invitation Status</th>--}}
{{--                                        <th>Joining Date</th>--}}
{{--                                        <th>Is featured</th>--}}
{{--                                        <th>Is certified</th>--}}
{{--                                        <th class="hideClick" ></th>--}}
{{--                                    </tr>--}}
{{--                                </thead>--}}
{{--                            </table>--}}
{{--                            --}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{-- 
    <script>
        {{--$(function() {--}}
        {{--    // alert(222);--}}
        {{--    $('#users-table').DataTable({--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        ajax: '{!! route('users.data') !!}',--}}
        {{--        columns: [--}}
        {{--            { data: 'id', name: 'id' },--}}
        {{--            { data: 'first_name', name: 'first_name' },--}}
        {{--            { data: 'status', name: 'status' },--}}
        {{--            { data: 'email', name: 'email' },--}}
        {{--            { data: 'invitation_status', name: 'invitation_status' },--}}
        {{--            { data: 'created_at', name: 'created_at' },--}}
        {{--            { data: 'is_featured', name: 'is_featured',--}}
        {{--                render: function(data){--}}
        {{--                    return  "<select id='is_featured_dropdown'>"+--}}
        {{--                            "<option>No</option>"+--}}
        {{--                            "<option>Yes</option>"+--}}
        {{--                            "</select>";--}}
        {{--                }--}}
        {{--            },--}}
        {{--            { data: 'is_certified', name: 'is_certified',--}}
        {{--                render: function(data){--}}
        {{--                    return  "<select id='is_certified_dropdown'>"+--}}
        {{--                            "<option>No</option>"+--}}
        {{--                            "<option>Yes</option>"+--}}
        {{--                            "</select>";--}}
        {{--                }--}}
        {{--            },--}}
        {{--            {--}}
        {{--                render: function(data){--}}
        {{--                    return  "<div class='wt-actionbtn'>"+--}}
		{{--					"<a href='javascript:void()' class='wt-addinfo wt-skillsaddinfo'><i class='lnr lnr-eye'></i></a>"+--}}
        {{--                    "<a href='javascript:void()' class='wt-addinfo wt-skillsaddinfo'><i class='fa fa-edit'></i></a>"+--}}
		{{--												--}}
        {{--                    "<a href='javascript:void()' v-on:click.prevent='deleteUser({{$user->id}})' class='wt-deleteinfo wt-skillsaddinfo'><i class='fa fa-trash'></i></a>"+--}}
        {{--                    "</div>";--}}
        {{--                }--}}
        {{--               --}}
        {{--            }--}}
        {{--        ]--}}
        {{--    });--}}
        {{--});--}}
  

    @endsection