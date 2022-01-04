@php $seller_id = !empty($seller) ? $seller->id : 0; @endphp
<div class="wt-clicksavearea">
    <span>{{{trans("lang.service_id")}}}: {{{$service->code}}}</span>
    <a href="javascrip:void(0);" id="remove-{{$service->id}}" class="wt-clicksavebtn wt-clicksave " style="{{ $service_saved ? '' : 'display: none;' }}"
            @click.prevent="remove_wishlist('remove-{{$service->id}}', {{ $service->id }}, 'saved_services', {{$seller_id}}, 'Save','add-{{$service->id}}')" v-cloak>
            <i class="fa fa-heart"></i> 
            {{{trans("lang.saved")}}}
        </a>
    
        <div class="wt-clicksavearea">
            <a href="javascript:void(0);" id="add-{{$service->id}}" class="wt-clicksavebtn" style="{{ $service_saved ? 'display: none;' : '' }}" @click.prevent="add_wishlist('add-{{$service->id}}', {{ $service->id }}, 'saved_services', {{$seller_id}}, 'Saved','remove-{{$service->id}}')" v-cloak>
                <i v-bind:class="heart_class"></i> 
                Click to Save
            </a>
        </div>
  
</div>