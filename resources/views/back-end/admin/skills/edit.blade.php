@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <div class="skills-listing" id="skill-list">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @elseif (Session::has('error'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <section class="wt-haslayout wt-dbsectionspace">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6 float-left">
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{{ trans('lang.edit_skill') }}}</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            {!! Form::open(['url' => url('admin/skills/update-skills/'.$skills->id.''),
                                'class' =>'wt-formtheme wt-formprojectinfo wt-formcategory',
                                'enctype' => 'multipart/form-data',
                                'id' => 'skills'] ) !!}
                            <fieldset>
                                <div class="form-group">
                                    {!! Form::text( 'skill_title', e($skills['title']), ['class' =>'form-control'.($errors->has('skill_title') ? ' is-invalid' : '')] ) !!}
                                    <span class="form-group-description">{{{ trans('lang.desc') }}}</span>
                                    @if ($errors->has('skill_title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('skill_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::text( 'skill_heading', e($skills['heading']), ['class' =>'form-control'.($errors->has('skill_heading') ? ' is-invalid' : '')] ) !!}
                                    <span class="form-group-description">{{{ "Heading Text For skills" }}}</span>
                                    @if ($errors->has('skill_title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('skill_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('category_id', 'Category') !!}
                                    {!! Form::select('categories[]', $categories, $skills->categories, [
                                        'class' => 'form-control select2-multiple',
                                        'multiple' => 'multiple'
                                    ]) !!}
                                    @if ($errors->has('categories'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('categories') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    {!! Form::text( 'skill_slug', e($skills['slug']), ['class' =>'form-control'.($errors->has('skill_slug') ? ' is-invalid' : '')] ) !!}
                                    <span class="form-group-description">{{{ trans('lang.desc') }}}</span>
                                    @if ($errors->has('skill_slug'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('skill_slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label for="imageInput"><strong>Skill Logo</strong></label>
                                <div class="col-md-12">
                                    <div class="row">
                                        @if($skills['logo'])
                                        <div class="col-md-4">
                                            <img src="/uploads/logos/{{ $skills['logo'] }}" alt="" style="width:100px">
                                        </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="hidden" name="logo" value="{{ $skills['logo'] }}"> 
                                                <input name="skill_logo" type="file" id="imageInput" value="" accept="image/*" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="is_featured"><strong>Featured Skill</strong></label>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <label class="col-md-6">
                                                <input type="radio" id="enable" name="is_featured" value="1" {{ $skills['is_featured'] == 1 ? "checked" : '' }}> Enabled
                                            </label>
                                            <label class="col-md-6">
                                                <input type="radio" id="disable" name="is_featured" value="0" {{ $skills['is_featured'] == 0 || $skills['is_featured'] == '' ? "checked" : '' }}> Disabled
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::textarea( 'skill_desc', e($skills['description']), ['class' => 'wt-tinymceblogeditor', 'id' => 'wt-tinymceeditor',
                                    'placeholder' => trans('lang.ph_desc')] ) !!}
                                    <span class="form-group-description">{{{ trans('lang.cat_desc') }}}</span>
                                </div>
                                <div class="form-group wt-btnarea">
                                    {!! Form::submit(trans('lang.update_skill'), ['class' => 'wt-btn']) !!}
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
@push('stripe')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-multiple').select2();
    });
</script>
@endpush
