<nav id="wt-nav" class="wt-nav navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="lnr lnr-menu"></i>
    </button>
    <div class="collapse navbar-collapse wt-navigation" id="navbarNav">
    <ul class="navbar-nav">
								
        <?php $user_role = Helper::getSessionUserRole(); ?>

        <?php if($user_role): ?>

            <?php if($user_role == 'guest'): ?>
            <li style="order: 1;">
                <a href="{{url('search-results?type=instructors')}}">
                    {{{ trans('lang.browse_instructors') }}}
                </a>
            </li>
                <li style="order: 2;">
                <a href="{{url('search-results?type=freelancer')}}">
                    {{{ trans('lang.view_freelancers') }}}
                </a>
                </li>
                <li style="order: 4;">
                <a href="{{url('search-results?type=job')}}">
                    {{{ trans('lang.browse_jobs') }}}
                </a>
                </li>
                <li style="order: 5;">
                <a href="{{url('search-results?type=service')}}">
                    {{{ trans('lang.browse_services') }}}
                </a>
                </li>
                <li style="order: 6;" class="join-now-menu">
					<a href="{{{ route('register') }}}" class="">
						{{{ trans('lang.join_now') }}}
					</a>
				</li>

            <?php elseif($user_role == 'admin'): ?>
                <li style="order: 2;">
                <a href="{{url('search-results?type=freelancer')}}">
                    {{{ trans('lang.view_freelancers') }}}
                </a>
                </li>
                <li style="order: 4;">
                <a href="{{url('search-results?type=job')}}">
                    {{{ trans('lang.browse_jobs') }}}
                </a>
                </li>
                <li style="order: 5;">
                <a href="{{url('search-results?type=service')}}">
                    {{{ trans('lang.browse_services') }}}
                </a>
                </li>
            <?php elseif($user_role == 'employer'): ?>

                <li style="order: 2;">
                <a href="{{url('search-results?type=freelancer')}}">
                    {{{ trans('lang.view_freelancers') }}}
                </a>
                </li>

                <li style="order: 5;">
                <a href="{{url('search-results?type=service')}}">
                    {{{ trans('lang.browse_services') }}}
                </a>
                </li>
                
            <?php elseif($user_role == 'freelancer'): ?>

                <li style="order: 4;">
                <a href="{{url('search-results?type=job')}}">
                    {{{ trans('lang.browse_jobs') }}}
                </a>
                </li>
                
            <?php endif;  ?>
        <?php endif;  ?>

    </ul>
    </div>
</nav>