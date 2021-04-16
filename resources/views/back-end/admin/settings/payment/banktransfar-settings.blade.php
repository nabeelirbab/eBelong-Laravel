{!! Form::open(['url' => '', 'class' =>'wt-formtheme wt-userform wt-bank-transfar-form', 'id' =>'bank-transfar-form',  '@submit.prevent'=>'submitBankSettings'])!!}  
    <div class="wt-location wt-tabsinfo">
        <div class="wt-tabscontenttitle la-switch-option"> 
            <h2>{{{ trans('lang.banktranfar_settings') }}}</h2>
            <switch_button v-model="enable_sandbox">{{{ trans('lang.enable_sandbox') }}}</switch_button>
            <input type="hidden" :value="enable_sandbox" name="enable_sandbox">
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group"> 
                    {!! Form::text('banktransfar_key',e($banktransfar_key), ['class' => 'form-control', 'placeholder' => trans('lang.banktransfar_key')]) !!}
                </div>
            </div>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('banktransfar_secret', e($banktransfar_secret), ['class' => 'form-control', 'placeholder' => trans('lang.banktransfar_secret')]) !!}
                </div>
            </div>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('api_endpoint', e($api_endpoint), ['class' => 'form-control', 'placeholder' => trans('lang.api_endpoint')]) !!}
                </div>
            </div>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('remitter_identification_type', e($remitter_identification_type), ['class' => 'form-control', 'placeholder' => trans('lang.remitter_identification_type')]) !!}
                </div>
            </div>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('remitter_identification_number', e($remitter_identification_number), ['class' => 'form-control', 'placeholder' => trans('lang.remitter_identification_number')]) !!}
                </div>
            </div>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('remitter_country_code', e($remitter_country_code), ['class' => 'form-control', 'placeholder' => trans('lang.remitter_country_code')]) !!}
                </div>
            </div>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('remitter_address', e($remitter_address), ['class' => 'form-control', 'placeholder' => trans('lang.remitter_address')]) !!}
                </div>
            </div>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('remit_purpose_code', e($remit_purpose_code), ['class' => 'form-control', 'placeholder' => trans('lang.remit_purpose_code')]) !!}
                </div>
            </div>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('remitter_city',e($remitter_city), ['class' => 'form-control', 'placeholder' => trans('lang.remitter_city')]) !!}
                </div>
            </div>
        </div>
        <div class="wt-settingscontent">
            <div class="wt-formtheme wt-userform">
                <div class="form-group">
                    {!! Form::text('remitter_postcode',e($remitter_postcode), ['class' => 'form-control', 'placeholder' => trans('lang.remitter_postcode')]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="wt-updatall la-updateall-holder">
        <i class="ti-announcement"></i>
        <span>{{{ trans('lang.save_changes_note') }}}</span>
        {!! Form::submit(trans('lang.btn_save'),['class' => 'wt-btn']) !!}
    </div>
{!! Form::close() !!}
