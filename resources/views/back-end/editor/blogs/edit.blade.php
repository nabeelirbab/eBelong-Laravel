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
                {!! Form::open(['url' => '', 'class' =>'wt-haslayout', 'id' => 'update_blog_form','@submit.prevent'=>'updateBlog("'.$blog->id.'")']) !!}
                    <div class="wt-dashboardbox">
                        <div class="wt-dashboardboxtitle">
                            <h2>{{ trans('lang.update_blog') }}</h2>
                        </div>
                        <div class="wt-dashboardboxcontent">
                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.blog_title') }}</h2>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    <fieldset>
                                        <div class="form-group">
                                            {!! Form::text('title', e($blog->title), array('class' => 'form-control', 'placeholder' => trans('lang.blog_title'))) !!}
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="wt-jobdescription wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.blog_slug') }}</h2>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    <fieldset>
                                        <div class="form-group">
                                            {!! Form::text('blog_slug', e($blog->slug), array('class' => 'form-control', 'placeholder' => trans('lang.blog_slug'))) !!}
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
                                            {!! Form::select('categories[]', $categories, $blog->categories, array('class' => 'chosen-select', 'multiple', 'data-placeholder' => trans('lang.select_blog_cats'))) !!}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="wt-jobdetails wt-tabsinfo">
                                <div class="wt-tabscontenttitle">
                                    <h2>{{ trans('lang.blog_content') }}</h2>
                                </div>
                                <div class="wt-formtheme wt-userform wt-userformvtwo">
                                    {!! Form::textarea('description', e($blog->content), ['class' => 'wt-tinymceeditor', 'id' => 'wt-tinymceeditor', 'placeholder' => trans('lang.service_desc_note')]) !!}
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
                           
                                <div class="wt-attachmentsholder">
                                    <div class="lara-attachment-files">
                                        <div class="wt-tabscontenttitle">
                                            <h2>{{ trans('lang.attachments') }}</h2>
                                        </div>
                                        <image-attachments :temp_url="'{{url('blog/upload-temp-image')}}'" :type="'image'"></image-attachments>
                                        <div class="form-group input-preview">
                                            <ul class="wt-attachfile dropzone-previews">
                                                @if (!empty($attachments))
                                                    @php $count = 0; @endphp
                                                    @foreach ($attachments as $key => $attachment)
                                                    <li id="attachment-item-{{$key}}">
                                                        <span>{{{Helper::formateFileName($attachment)}}}</span>
                                                        <em>
                                                            @if (Storage::disk('local')->exists('uploads/blogs/'.$blog->id.'/'.$attachment))
                                                                {{ trans('lang.file_size') }} {{{Helper::bytesToHuman(Storage::size('uploads/blogs/'.$blog->id.'/'.$attachment))}}}
                                                            @endif
                                                            <a href="{{{route('getfile', ['type'=>'blogs','attachment'=>$attachment,'id'=>$blog->id])}}}"><i class="lnr lnr-download"></i></a>
                                                            <a href="#" v-on:click.prevent="deleteAttachment('attachment-item-{{$key}}')"><i class="lnr lnr-cross"></i></a>
                                                        </em>
                                                        <input type="hidden" value="{{{$attachment}}}" class="" name="attachments[{{$key}}]">
                                                    </li>
                                                    @php $count++; @endphp
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                    <div class="wt-updatall">
                        <i class="ti-announcement"></i>
                        <span>{{{ trans('lang.save_changes_note') }}}</span>
                        {!! Form::submit(trans('lang.blog_update'), ['class' => 'wt-btn', 'id'=>'submit-blog']) !!}
                    </div>
                {!! form::close(); !!}
            </div>
        </div>
    </div>
</div>
@endsection
