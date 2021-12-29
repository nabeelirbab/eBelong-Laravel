@php $seller_id = !empty($seller) ? $seller->id : 0; @endphp
@if(Auth::user() && Auth::user()->id != $seller_id)
<div class="wt-widget wt-reportjob">
    <div class="wt-widgettitle">
        <h2>{{ trans('lang.report_course') }}</h2>
    </div>
    <div class="wt-widgetcontent">
        {!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-formreport', 'id' => 'submit-report',  '@submit.prevent'=>'submitReport("'.$cource->id.'","cource-report")']) !!}
            <fieldset>
                <div class="form-group">
                    <span class="wt-select">
                        {!! Form::select('reason', \Illuminate\Support\Arr::pluck($reasons, 'title'), null ,array('class' => '', 'placeholder' => trans('lang.select_reason'), 'v-model' => 'report.reason')) !!}
                    </span>
                </div>
                <div class="form-group">
                    {!! Form::textarea( 'description', null, ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc'), 'v-model' => 'report.description'] ) !!}
                </div>
                <div class="form-group wt-btnarea">
                    {!! Form::submit(trans('lang.btn_submit'), ['class' => 'wt-btn', 'id'=>'submit-profile']) !!}
                </div>
            </fieldset>
        {!! form::close(); !!}
    </div>
</div>
@endif