<nav id="wt-nav" class="wt-nav navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="lnr lnr-menu"></i>
    </button>
    <div class="collapse navbar-collapse wt-navigation" id="navbarNav">
    <ul class="navbar-nav">
								
        <?php $user_role = Helper::getSessionUserRole(); ?>

        <?php if($user_role): ?>

            <?php if($user_role == 'guest'||$user_role == 'editor'): ?>
            <li style="order: 1;">
		        <a href="{{url('/hire-remote-developers')}}">
					Hire Developer
				</a>
			</li>
            <li style="order: 1;">
                <a href="{{url('/courses')}}">
                    {{{ trans('lang.courses') }}}
                </a>
            </li>
                <li style="order: 2;">
                <a href="{{url('hire')}}">
                    {{{ trans('lang.Talent') }}}
                </a>
                </li>
                {{-- <li style="order: 4;">
                <a href="{{url('/jobs')}}">
                    {{{ trans('lang.jobs') }}}
                </a>
                </li> --}}
                <li style="order: 5;">
                <a href="{{url('/services')}}">
                    {{{ trans('lang.services') }}}
                </a>
                </li>
                <li style="order: 5;">
                    <a href="{{url('/blogs')}}">
                        {{{ trans('lang.Blogs') }}}
                    </a>
                </li>
                <?php elseif($user_role == 'editor'): ?>
                <li style="order: 6;" class="join-now-menu">
					<a href="{{{ route('register') }}}" class="">
						{{{ trans('lang.join_now') }}}
					</a>
				</li>

            <?php elseif($user_role == 'admin'): ?>
            <li style="order: 1;">
                <a href="{{url('/courses')}}">
                    {{{ trans('lang.courses') }}}
                </a>
            </li>
                <li style="order: 2;">
                <a href="{{url('hire')}}">
                    {{{ trans('lang.Talent') }}}
                </a>
                </li>
                {{-- <li style="order: 4;">
                <a href="{{url('/jobs')}}">
                    {{{ trans('lang.jobs') }}}
                </a>
                </li> --}}
                <li style="order: 5;">
                <a href="{{url('/services')}}">
                    {{{ trans('lang.services') }}}
                </a>
                </li>
                <li style="order: 6;">
                    <a href="{{url('/blogs')}}">
                        {{{ trans('lang.Blogs') }}}
                    </a>
                </li>
            <?php elseif($user_role == 'employer'): ?>

                <li style="order: 2;">
                <a href="{{url('hire')}}">
                    {{{ trans('lang.Talent') }}}
                </a>
                </li>

                <li style="order: 5;">
                <a href="{{url('/services')}}">
                    {{{ trans('lang.services') }}}
                </a>
                </li>
                
            <?php elseif($user_role == 'freelancer'): ?>
            <li style="order: 1;">
                <a href="{{url('/courses')}}">
                    {{{ trans('lang.courses') }}}
                </a>
            </li>
                <li style="order: 4;">
                    <a href="{{url('search-results?type=freelancerjobs')}}">
                    {{{ trans('lang.jobs') }}}
                </a>
                </li>
                
            <?php endif;  ?>
        <?php endif;  ?>

    </ul>
    </div>
</nav>