@php $seller_id = !empty($seller) ? $seller->id : 0; @endphp
@if(Auth::user() && Auth::user()->id != $seller_id)
<div class="wt-clicksavearea">
    <span>{{{trans("lang.cource_id")}}}: {{{$cource->code}}}</span>
    @if (!empty($saved_cources))
        <a href="javascrip:void(0);" class="wt-clicksavebtn wt-clicksave wt-btndisbaled">
            <i class="fa fa-heart"></i> 
            {{{trans("lang.saved")}}}
        </a>
    @else
        <div class="wt-clicksavearea">
            <a href="javascript:void(0);" id="profile-{{$cource->id}}" v-bind:class="disable_btn" class="wt-clicksavebtn" @click.prevent="add_wishlist('profile-{{$cource->id}}', {{ $cource->id }}, 'saved_cources', {{$seller_id}}, '{{{trans("lang.saved")}}}')" v-cloak>
                <i v-bind:class="heart_class"></i> 
                @{{text}}
            </a>
        </div>
    @endif
</div>
@endif