@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
@php
    $selected_role = !empty($_GET['role']) ? $_GET['role'] : '';
    
@endphp

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
                        <h2>My Connections</h2>
                        {{-- <form class="wt-formtheme wt-formsearch">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="keyword" value="{{{ !empty($_GET['keyword']) ? $_GET['keyword'] : '' }}}"
                                        class="form-control" placeholder="{{{ trans('lang.ph_search_users') }}}">
                                    <button type="submit" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></button>
                                </div>
                            </fieldset>
                        </form>
                     --}}
                    
                    </div>
                    <div class="wt-dashboardboxcontent wt-categoriescontentholder">
                        @if ($connections->count() > 0)
                            <table class="wt-tablecategories">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{{ trans('lang.user_name') }}}</th>
                                        <th>{{{ trans('lang.ph_email') }}}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($connections as $key => $user)
                                     
                                            <tr class="del-user-{{ $user->connected->id }}">
                                                <td><figure class="service-feature-image" style="width: 60px; height:60px"><img src="{{{asset(Helper::getProfileImage($user->connected->id))}}}" style="width: 60px; height:60px"  alt="{{{trans('lang.image')}}}"></figure></td>
                                                <td><a href="{{{url('profile/'.$user->connected->slug)}}}">{{{Helper::getUserName($user->connected->id)}}}</a></td>
                                                <td>{{{ $user->connected->email }}}</td>
                                                <td> <button onclick="location.href='/reject-request/{{ $user->id }}'" class="wt-btn">Remove</a></button></td>
                                          
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
                        @if ( method_exists($connections,'links') )
                            {{ $connections->links('pagination.custom') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection