<aside id="wt-sidebar" class="wt-sidebar">
    @if (file_exists(resource_path('views/extend/front-end/cources/sidebar/cource_info.blade.php'))) 
        @include('extend.front-end.cources.sidebar.cource_info')
    @else 
        @include('front-end.cources.sidebar.cource_info')
    @endif
    @if (!empty($seller))
        @if (file_exists(resource_path('views/extend/front-end/cources/sidebar/user_info.blade.php'))) 
            @include('extend.front-end.cources.sidebar.user_info')
        @else 
            @include('front-end.cources.sidebar.user_info')
        @endif
    @endif
    @if (file_exists(resource_path('views/extend/front-end/cources/sidebar/qrcode.blade.php'))) 
        @include('extend.front-end.cources.sidebar.qrcode')
    @else 
        @include('front-end.cources.sidebar.qrcode')
    @endif
    @if (file_exists(resource_path('views/extend/front-end/cources/sidebar/social-share.blade.php'))) 
        @include('extend.front-end.cources.sidebar.social-share')
    @else 
        @include('front-end.cources.sidebar.social-share')
    @endif
    @if (file_exists(resource_path('views/extend/front-end/cources/sidebar/report.blade.php'))) 
        @include('extend.front-end.cources.sidebar.report')
    @else 
        @include('front-end.cources.sidebar.report')
    @endif
</aside>
