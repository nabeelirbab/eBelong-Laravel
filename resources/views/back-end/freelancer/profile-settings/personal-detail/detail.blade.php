<div class="wt-tabscontenttitle">
    <h2>{{{ trans('lang.your_details') }}}</h2>
</div>
<div class="wt-formtheme">
    <fieldset>
        <div class="form-group form-group-half">
            <span class="wt-select">
                {!! Form::select( 'gender', ['male' => 'Male', 'female' => 'Female'], e($gender), ['placeholder' => trans('lang.ph_select_gender'),'maxlength' => 10 ] ) !!}
            </span>
        </div>
        <div class="form-group form-group-half">
            {!! Form::text( 'first_name', e(Auth::user()->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_first_name'),'maxlength' => 25 ] ) !!}
        </div>
        <div class="form-group form-group-half">
            {!! Form::text( 'last_name', e(Auth::user()->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph_last_name'),'maxlength' => 25] ) !!}
        </div>
        <div class="form-group form-group-half">
            {!! Form::number( 'hourly_rate', e($hourly_rate), ['class' =>'form-control', 'placeholder' => trans('lang.ph_service_hoyrly_rate'),'maxlength' => 10] ) !!}
        </div>
        <div class="form-group">
            {!! Form::text( 'tagline', e($tagline), ['class' =>'form-control', 'placeholder' => trans('lang.ph_add_tagline'),'maxlength' => 30] ) !!}
        </div>
        <div class="form-group">
            {!! Form::textarea( 'description', e($description), ['class' =>'form-control', 'placeholder' => trans('lang.ph_desc'),'maxlength' => 500] ) !!}
            <span>max character limit 500</span>
        </div>
        <div class="form-group">
            <span class="wt-select">
                @php
                    $categoryArr = array();
                    foreach($categories as $cs){
                        $categoryArr[$cs->id] = $cs->title;
                    }
                @endphp
                {!! Form::select( 'category_id',$categoryArr,e($selectedcategories), ['class' =>'form-control', 'placeholder' => trans('lang.ph_cat_lbl'),'maxlength' => 50] ) !!}
            </span>
        </div>
    </fieldset>
</div>