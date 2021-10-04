@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
<script src="{{ URL::asset('js/jquery-3.3.1.min.js') }}"></script>

@section('content')

    <section class="wt-haslayout wt-dbsectionspace" id="profile_settings">
        <div class="wt-dbsectionspace wt-haslayout la-ps-freelancer">
            <div class="freelancer-profile" id="user_profile">
                <div class="preloader-section" v-if="loading" v-cloak>
                    <div class="preloader-holder">
                        <div class="loader"></div>
                    </div>
                </div>
                @if (session('alert'))
                    <div class="alert alert-success">
                        {{ session('alert') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class='wt-tabscontenttitle'>
                    <h2>Send Push Notifications</h2>
                </div>
                <div class="row">
                    <form action="{{ route('sendMobileNotification') }}" method="post">
                        @csrf
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                            <div class="">
                                <div class='wt-formtheme wt-userform agency-form'>
                                   <div class="wt-tabscontent tab-content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <select name="notification_type" id="notification_type">
                                                        <option value="">Please Select Notifications sent Via</option>
                                                        <option value="email">Using Email</option>
                                                        <option value="skills">Using Skills</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="notification-emails" >
                                                <div class="form-group">
                                                    <input type="text" name="notification_emails" placeholder="User Emails" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="notification-emails-note" >
                                                <div class="form-group">
                                                    <label for="">Provide Email address whom you want to send Notifications. (You can use comma seperated emails for mulitple's)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="skill-field" >
                                                <div class="form-group">
                                                    <span class="wt-select">
                                                        <select name="skills[]" class="chosen-select" multiple data-placeholder = "Select Skills">
                                                            @foreach($skills as $skill)
                                                                <option value="{{{ $skill->id }}}">{{{ $skill->title }}}</option>
                                                            @endforeach
                                                        </select>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="skill-field-note" >
                                                <div class="form-group">
                                                    <label for="">Please Select Skills of those you want to send Notifications. (You can use select mulitple's)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="title" placeholder="Notification Title" class="form-control" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="image" placeholder="Enter Image URL" class="form-control" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="sound" placeholder="Sound" class="form-control"  value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="description" id="" placeholder="Enter Notification Description" cols="20" rows="10"></textarea>
                                                </div>
                                            </div>
                                            <div class="wt-updatall la-updateall-holder">
                                                <i class="ti-announcement"></i>
                                                <input id="submit-profile" type="submit" value="Send Notifications" class="wt-btn">
                                            </div>
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>

        $(document).ready(function(){
            $('#notification-emails').hide();
            $('#notification-emails-note').hide();
            $('#skill-field').hide();
            $('#skill-field-note').hide();
        });

        $("#notification_type").change(function() {
            if ($("#notification_type").val() === 'email') {
                $('#skill-field').hide();
                $('#skill-field-note').hide();
                $('#notification-emails').show();
                $('#notification-emails-note').show();
            }
            else if($("#notification_type").val() === 'skills') {
                $('#notification-emails').hide();
                $('#notification-emails-note').hide();
                $('#skill-field').show();
                $('#skill-field-note').show();
            }
            else {
                $('#notification-emails').hide();
                $('#notification-emails-note').hide();
                $('#skill-field').hide();
                $('#skill-field-note').hide();
            }
        });

    </script>
@endpush
