<div class="wt-userrating wt-userratingvtwo">

    <div class="wt-ratingtitle">
      @if(isset($cource->promotion_price) && $cource->promotion_price > 0)
      <h5><del>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}{{ $cource->price }}</del></h5> <h3>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}{{ $cource->promotion_price }}</h3>
      @else
            <h3>{{ !empty($symbol) ? $symbol['symbol'] : '$' }}{{ $cource->price }}</h3>
      @endif
  
       <span>{{trans('lang.starting_from')}}</span>
    </div>
    <div class="wt-rating-info">
       <ul class="wt-service-info test">
         @if($cource->course_date)
          <li>
             <span><i class="fa fa-calendar-check-o iconcolor1"></i>
             <strong>{{{$cource->course_date}}}</strong> </span>
          </li>
          @endif
          <li>
             <span><i class="fa fa-search iconcolor2"></i><strong>{{{$cource->views}}}</strong>&nbsp;{{ trans('lang.views') }}</span>
          </li>
          <li>
             <span><i class="fa fa-shopping-basket iconcolor3"></i><strong>{{{Helper::getCourceCount($cource->id,'completed')}}}</strong>&nbsp;{{ trans('lang.sales') }}</span>
          </li>
          @if($cource->course_time)
          <li>
             <span><i class="fa fa-clock-o iconcolor4"></i><strong>{{{$cource->course_time}}}</strong></span>
          </li>
          @endif
          <li>
             <span><i class="fa fa-briefcase iconcolor4"></i><strong>
              @if(!$cource->user_type)
                  Remote
                 @else
                  {{{$cource->user_type}}}
               @endif</strong></span>
          </li>
       </ul>
       <div class="wt-ratingcontent">
          <p><em>*</em> {{ trans('lang.service_note') }}</p>
          @php $seller_id = !empty($seller) ? $seller->id : 0; 
          $user_role = Helper::getSessionUserRole();
          @endphp
          @if((Auth::user() && Auth::user()->id != $seller_id  && $boughtcourse == false && $waiting_status== false) || $user_role == "guest")
          <a href="javascript:;" class="wt-btn" v-on:click.prevent="BuyCource('{{{$cource->id}}}', '{{{trans('lang.hire_cource_title')}}}', '{{{trans('lang.hire_cource_text')}}}', '{{$mode}}','{{ $user_role }}')">{{ trans('lang.buy_now') }} </a>
          @endif
          @if(Auth::user() && $boughtcourse == true)
          <a href="{{url('freelancer/courses/bought')}}" class="wt-btn" disabled>Enrolled </a>
          @endif
          @if(Auth::user() && $waiting_status == true)
          <p><em>*</em> {{ "Wait for the Instructor to Enroll you " }}</p>
          <a href="{{url('freelancer/courses/waiting')}}" class="wt-btn" disabled>Bought </a>
          @endif
         </div>
    </div>
    @if($cource->user_type && $cource->user_type != 'Remote')
      <iframe
      width="600"
      height="450"
      frameborder="0"
      scrolling="no"
      marginheight="0"
      marginwidth="0"
      src="https://maps.google.com/maps?q={{ urlencode($cource->address) }}&hl=en&z=14&amp;output=embed"
    ></iframe>

    @endif
 </div>