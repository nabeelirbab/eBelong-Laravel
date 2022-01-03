@php $seller_id = !empty($seller) ? $seller->id : 0; @endphp
@if(Auth::user() && Auth::user()->id != $seller_id)
<div class="wt-clicksavearea">
    <span>{{{trans("lang.cource_id")}}}: {{{$cource->code}}}</span>
  
        <a href="javascrip:void(0);" id="remove-{{$cource->id}}" class="wt-clicksavebtn wt-clicksave " style="{{ $course_saved ? '' : 'display: none;' }}"
            @click.prevent="remove_wishlist('remove-{{$cource->id}}', {{ $cource->id }}, 'saved_cources', {{$seller_id}}, 'Save','add-{{$cource->id}}')" v-cloak>
            <i class="fa fa-heart"></i> 
            {{{trans("lang.saved")}}}
        </a>
    
        <div class="wt-clicksavearea">
            <a href="javascript:void(0);" id="add-{{$cource->id}}" class="wt-clicksavebtn" {{ $course_saved ? 'display: none;' : '' }} @click.prevent="add_wishlist('add-{{$cource->id}}', {{ $cource->id }}, 'saved_cources', {{$seller_id}}, '{{{trans("lang.saved")}}}','remove-{{$cource->id}}')" v-cloak>
                <i v-bind:class="heart_class"></i> 
                Click to Save
            </a>
        </div>
  
</div>
@endif