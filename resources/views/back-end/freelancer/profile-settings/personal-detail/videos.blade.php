<div class="wt-tabscontenttitle">
    <h2>{{{ trans('lang.videos') }}}</h2>
</div>
<div class="wt-skillsform">
    <fieldset class="social-icons-content">
        @if (!empty($videos))
            @php $counter = 0 @endphp
            @foreach ($videos as $video_key => $mem_value)
                <div class="wrap-social-icons wt-haslayout">
                    <div class="form-group">
                        <div class="form-group-holder">
                            {!! Form::text('video['.$counter.'][url]', e($mem_value['url']),
                            ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group wt-rightarea">
                            @if ($video_key == 0 )
                                <span class="wt-addinfobtn" @click="addVideo"><i class="fa fa-plus"></i></span> 
                            @else
                                <span class="wt-addinfobtn wt-deleteinfo delete-social" data-check="{{{$counter}}}">
                                    <i class="fa fa-trash"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @php $counter++; @endphp
            @endforeach
        @else
            <div class="wrap-social-icons wt-haslayout">
                <div class="form-group">
                    <div class="form-group-holder">
                        {!! Form::text('video[0][url]', null, ['class' => 'form-control',
                            'placeholder' => trans('lang.video_url')])
                        !!}
                    </div>
                    <div class="form-group wt-rightarea">
                        <span class="wt-addinfobtn" @click="addVideo"><i class="fa fa-plus"></i></span>
                    </div>
                </div>
                
            </div>
        @endif
            <div v-for="(video, index) in videos" v-cloak>
                <div class="wrap-social-icons wt-haslayout">
                    <div class="form-group">
                        <div class="form-group-holder">
                            <input v-bind:name="'video['+[video.count]+'][url]'" type="text" class="form-control"
                            v-model="video.url" placeholder="Enter video url">
                        </div>
                        <div class="form-group wt-rightarea">
                            <span class="wt-addinfobtn wt-deleteinfo" @click="removeVideo(index)"><i class="fa fa-trash"></i></span>
                        </div>
                    </div>
                </div>
            </div>
    </fieldset>
    OR
    <div class="wt-formtheme wt-userform wt-userformvtwo">
        <!-- File Input for Video Upload -->
        <div class="mb-2">
            <button type="button" class="wt-btn" id="startRecord">Record your Video Introduction
            </button>
            <button type="button" class="wt-btn" id="stopRecord" style="display: none;">Stop Recording</button>
            @if($video_uplaod)
            <button type="button" class="wt-btn" id="deleteVideo">Delete Video</button>
            @endif
        </div>
        
        <video id="recorder" width="640" height="480" controls autoplay></video>
        <video id="playback" width="640" height="480" controls></video>
        @if($video_uplaod)
        <video id="playback2" src="{{{ s3_base_url().$video_uplaod }}}" width="640" height="480" controls></video>
        @endif
        <div style="display: none">
            <button type="button" id="play" disabled>Play</button>
            <button type="button" id="pause" disabled>Pause</button>
        </div>
    </div>

</div>
