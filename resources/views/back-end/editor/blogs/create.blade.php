@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
<div class="wt-haslayout wt-dbsectionspace">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 float-left" id="blog">
            <div class="preloader-section" v-if="loading" v-cloak>
                <div class="preloader-holder">
                    <div class="loader"></div>
                </div>
            </div>
            <div class="wt-haslayout wt-post-job-wrap">
                {!! Form::open(['url' => '', 'class' =>'wt-haslayout', 'id' => 'post_blog_form',  '@submit.prevent'=>'submitBlog']) !!}
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{ trans('lang.post_blog') }}</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.blog_title') }}</h2>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    <fieldset>
                                        <div class="form-group">
                                            <input type="text" name="title" class="form-control" placeholder="{{ trans('lang.blog_title') }}" v-model="title">
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="wt-jobcategories wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.Blog_cats') }}</h2>
                                </div>
                                <div class="wt-divtheme wt-userform wt-userformvtwo">
                                    <div class="form-group">
                                        <span class="wt-select">
                                            {!! Form::select('categories[]', $categories, null, array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_blog_cats'))) !!}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="wt-courses wt-tabsinfo">
                                <div class="wt-skills la-skills-holder wt-tabsinfo" id="wt-skills">
                                    <div class="wt-tabscontenttitle">
                                        <h2>{{ trans('lang.skills_req') }}</h2>
                                    </div>
                                    <div class="wt-formtheme wt-userform">
                                        {{-- add Course Skills --}}
                                        <blog_skills :ph_rate_skills="'{{ trans('lang.ph_rate_skills') }}'"></blog_skills>
                                    </div>
                                </div>
                            </div>
                            <div class="wt-jobdetails wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.blog_content') }}</h2>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    {!! Form::textarea('content', null, ['class' => 'wt-tinymceeditor', 'id' => 'wt-tinymceeditor', 'placeholder' => trans('lang.blog_desc_note')]) !!}
                                </div>
                            </div>
                            <div class="wt-attachmentsholder">
                                <div class="lara-attachment-files">
                                    <div class="wt-tabscontenttitle">
                                        <h2>{{ trans('lang.attachments') }}</h2>
                                        {{-- <div class="wt-rightarea">
                                            <div class="wt-on-off float-right">
                                                <switch_button v-model="show_attachments">{{{ trans('lang.attachments_note') }}}</switch_button>
                                                <input type="hidden" :value="show_attachments" name="show_attachments">
                                            </div>
                                        </div> --}}
                                    </div>
                                    <image-attachments :temp_url="'{{url('blog/upload-temp-image')}}'" :type="'image'"></image-attachments>
                                    <div class="form-group input-preview">
                                        <ul class="wt-attachfile dropzone-previews">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wt-updatall">
                        <i class="ti-announcement"></i>
                        <span>{{{ trans('lang.save_changes_note') }}}</span>
                        {!! Form::submit(trans('lang.post_blog'), ['class' => 'wt-btn', 'id'=>'submit-blog']) !!}
                    </div>
                {!! form::close(); !!}
            </div>
        </div>
    </div>
</div>
@endsection
