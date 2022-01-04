<div class="wt-clicksavearea">
    <span>{{{trans("lang.project_id")}}}: {{{$job->code}}}</span>
    <a href="javascrip:void(0);" id="remove-{{$job->id}}" class="wt-clicksavebtn wt-clicksave " style="{{ $job_saved ? '' : 'display: none;' }}"
            @click.prevent="remove_wishlist('remove-{{$job->id}}', {{ $job->id }}, 'saved_jobs', 'Save','add-{{$job->id}}')" v-cloak>
            <i class="fa fa-heart"></i> 
            {{{trans("lang.saved")}}}
        </a>
    
        <div class="wt-clicksavearea">
            <a href="javascript:void(0);" id="add-{{$job->id}}" class="wt-clicksavebtn" style="{{ $job_saved ? 'display: none;' : '' }}"
            @click.prevent="add_wishlist('add-{{$job->id}}', {{ $job->id }}, 'saved_jobs', '{{{trans('lang.saved')}}}','remove-{{$job->id}}')" v-cloak>
                <i v-bind:class="heart_class"></i> 
                Click to Save
            </a>
        </div>
</div>
