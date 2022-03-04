@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
   
<div class="invite-people" id="invite_people">
    @if (Session::has('success'))
    <div class="flash_msg">
        <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('success') }}}'" v-cloak></flash_messages>
    </div>
    @endif
    @if (Session::has('message'))
    <div class="flash_msg">
        <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="flash_msg">
        <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
    </div>
    @endif
    @if ($errors->any())
        <ul class="wt-jobalerts">
            @foreach ($errors->all() as $error)
                <div class="flash_msg">
                    <flash_messages :message_class="'danger'" :time ='10' :message="'{{{ $error }}}'" v-cloak></flash_messages>
                </div>
            @endforeach
        </ul>
    @endif
           
    <section class="wt-haslayout wt-dbsectionspace la-addnewcats">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 float-left">
                 @if (Session::has('sent_email_num'))
             <div class="alert alert-success">
                 {{ Session::get('sent_email_num') }}
            </div>
            @endif
            @if (Session::has('duplicate_email_num'))
             <div class="alert alert-success">
                 {{ Session::get('duplicate_email_num') }}
            </div>
            @endif
            @if (Session::has('empty_email_num'))
            <div class="alert alert-success">
                {{ Session::get('empty_email_num') }}
           </div>
           @endif
           @if (Session::has('wrong_email_num'))
            <div class="alert alert-success">
                {{ Session::get('wrong_email_num') }}
           </div>
           @endif
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 float-left">
                <div class="wt-dashboardbox la-category-box">
                    <div class="wt-dashboardboxtitle">
                          <login-notification></login-notification>
                        <h2>{{{ trans('invite.invite_people') }}}</h2>
                    </div>

                    <div class="wt-dashboardboxcontent">

                        {!! Form::open([ 'url' => url('admin/invite-people'), 'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory','enctype'=>'multipart/form-data','method'=>'post', 'id' => 'invite-people', 'id' => 'invite_people_form' ]) !!}
                        <fieldset>

                            <div class="form-group">
                                <span class="wt-checkbox">
                                    {!! Form::radio('user_type', '3' , true) !!} Freelancer
                                    {!! Form::radio('user_type', '2',  false) !!} Employer
                                    {!! Form::radio('user_type', '4',  false) !!} Editor
                                </span>
                            </div>
                            <!--        <div class="form-group">
                                <label for="subject"><span>{{trans('invite.subject')}}</span></label>
                                {!! Form::text('subject', null, array('class' => 'form-control', 'placeholder' => 'subject')) !!}
                            </div>-->
                            <div class="form-group">
                                  <label for="subject"><span>{{trans('invite.email_address')}}</span></label>
                                  {!! Form::textarea('email_address', null, ['class'=>'form-control','rows'=>'5']) !!}
                              
                            </div>
                            <div class="wt-settingscontent">
                                <div class = "wt-formtheme wt-userform">
                                    {!!  Form::file('email_address_csv',['class'=>'form-control','width'=>'100','accept'=>'.csv']) !!}
                                    <div class="label label-default " style="">
                                        <strong>[Note:</strong> must import a csv file.]
                                    </div> 
                                    <a href="{{ asset('/')}}sample_files/people-information.csv" class="pull-left" style="font-style: italic">
                                        <i class="fa fa-download"></i>{{trans('invite.sample_file')}}</a>
                                </div>
                            </div>
                            <div class="form-group wt-btnarea">
                                {!! Form::submit(trans('invite.invite_people'), ['class' => 'wt-btn float-right']) !!}

                            </div>
                        </fieldset>
                        {!! Form::close(); !!}
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
