<div class="wt-tabscontenttitle">
    <h2>{{{ trans('lang.change_password') }}}</h2>
</div>
<div class="wt-formtheme">
    <fieldset>
        <div class="form-group">
            {!! Form::password( 'old_password',  ['class' =>'form-control', 'placeholder' => trans('lang.ph_old_password')] ) !!}
        </div>
        <div class="form-group">
            {!! Form::password( 'change_password',  ['class' =>'form-control', 'placeholder' => trans('lang.ph_change_password')] ) !!}
        </div>
        <div class="form-group">
            {!! Form::password( 'password_confirmation',  ['class' =>'form-control', 'placeholder' => trans('lang.ph_confirm_change_password')] ) !!}
        </div>
    </fieldset>
</div>