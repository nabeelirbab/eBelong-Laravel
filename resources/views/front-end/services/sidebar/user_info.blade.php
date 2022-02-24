<div class="wt-widget la-empinfo-holder wt-user-service">
    <div class="wt-companysdetails">
        <figure class="wt-companysimg">
            <img src="{{{ asset(Helper::getUserProfileBanner($seller->id, 'small')) }}}" alt="{{ trans('lang.profile_img') }}">
        </figure>
        <div class="wt-companysinfo">
            <figure><img src="{{{asset(Helper::getProfileImage($seller->id))}}}" alt="{{ trans('lang.profile_img') }}"></figure>
            <div class="wt-userprofile">
                <div class="wt-title">
                    <h3>			
                        <a href="{{{ url('profile/'.$seller->slug) }}}">
                            @if ($seller->user_verified === 1) <i class="fa fa-check-circle"></i> @endif &nbsp;{{{ Helper::getUserName($seller->id) }}}
                        </a>
                    </h3>
                    {{ trans('lang.member_since') }}&nbsp;{{  \Carbon\Carbon::parse($seller->created_at)->format('Y-m-d') }}	<a href="javascript:;">@ {{$seller->slug}}</a> 
                    <a href="{{{ url('profile/'.$seller->slug) }}}" class="wt-btn">View Profile</a>
                    @php $is_member_agency = DB::table('agency_associated_users')->where('user_id',$seller->id)->where('is_pending',0)->where('is_accepted',1)->first(); @endphp
                    @if (!empty($seller->is_agency))
                    @php $agencylogo = DB::table('agency_user')->where('id',$seller->agency_id)->first();@endphp
                    <li>
                        <span>
                            <img src="{{ asset('uploads/agency_logos/' . $seller->agency_id.'/'.$agencylogo->agency_logo) }}"> {{{ $agencylogo->agency_name }}}
                        </span>
                    </li>
                    @elseif(!empty($is_member_agency))
                    @php $agencylogo = DB::table('agency_user')->where('id',$is_member_agency->agency_id)->first();@endphp
                    <li>
                        <span>
                          <a href="{{{url('agency/'.$agencylogo) }}}">  <img src="{{ asset('uploads/agency_logos/' . $is_member_agency->agency_id.'/'.$agencylogo->agency_logo) }}"style="max-width: 70px; right:190px"> {{{ $agencylogo->agency_name }}}</a>
                        </span>
                    </li>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
