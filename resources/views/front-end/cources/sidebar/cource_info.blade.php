<div class="wt-userrating wt-userratingvtwo">
    <div class="wt-ratingtitle">
       <h3>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}{{{$cource->price}}}</h3>
       <span>{{trans('lang.starting_from')}}</span>
    </div>
    <div class="wt-rating-info">
       <ul class="wt-service-info test">
          <li>
             <span><i class="fa fa-calendar-check-o iconcolor1"></i>
             <strong>{{{$delivery_time->title}}}</strong> &nbsp;{{ trans('lang.delivery_time') }}</span>
          </li>
          <li>
             <span><i class="fa fa-search iconcolor2"></i><strong>{{{$cource->views}}}</strong>&nbsp;{{ trans('lang.views') }}</span>
          </li>
          <li>
             <span><i class="fa fa-shopping-basket iconcolor3"></i><strong>{{{Helper::getCourceCount($cource->id,'completed')}}}</strong>&nbsp;{{ trans('lang.sales') }}</span>
          </li>
          <li>
             <span><i class="fa fa-clock-o iconcolor4"></i><strong>{{{$response_time->title}}}</strong>&nbsp;{{ trans('lang.response_time') }}</span>
          </li>
       </ul>
       <div class="wt-ratingcontent">
          <p><em>*</em> {{ trans('lang.service_note') }}</p>
          @php $seller_id = !empty($seller) ? $seller->id : 0; @endphp
          @if(Auth::user() && Auth::user()->id != $seller_id  && $boughtcourse == false)
          <a href="javascript:;" class="wt-btn" v-on:click.prevent="BuyCource('{{{$cource->id}}}', '{{{trans('lang.hire_cource_title')}}}', '{{{trans('lang.hire_cource_text')}}}', '{{$mode}}')">{{ trans('lang.buy_now') }} </a>
          @endif
          @if(Auth::user() && $boughtcourse == true)
          <a href="javascript:;" class="wt-btn" disabled>Bought </a>
          @endif
         </div>
    </div>
 </div>