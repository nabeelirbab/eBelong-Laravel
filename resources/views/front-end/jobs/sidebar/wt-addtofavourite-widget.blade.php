<div class="wt-clicksavearea">
    <span>{{{trans("lang.project_id")}}}: {{{$job->code}}}</span>
    @if (!empty($user->profile->saved_jobs) && in_array($job->id, unserialize($user->profile->saved_jobs)))
    <a href="javascrip:void(0);" class="wt-clicksavebtn wt-clicksave wt-btndisbaled">
    <i class="fa fa-heart"></i>
    {{{trans("lang.saved")}}}
    </a>
    @else
    <div class="wt-clicksavearea">
    <a href="javascript:void(0);" id="profile-{{$job->id}}" v-bind:class="disable_btn" class="wt-clicksavebtn" @click.prevent="add_wishlist('profile-{{$job->id}}', {{ $job->id }}, 'saved_jobs', '{{{trans("lang.saved")}}}')" v-cloak>
    <i class="fa fa-heart"></i>
    <span class="save_text"> {{ trans('lang.click_to_save') }}</span>
    </a>
    </div>
    @endif
</div>
