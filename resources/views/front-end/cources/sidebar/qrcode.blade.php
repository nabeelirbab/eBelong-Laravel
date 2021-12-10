<div class="wt-proposalsr">
    <div class="tg-authorcodescan">
        <figure class="tg-qrcodeimg">
            {!! QrCode::size(100)->generate(Request::url('instructor/'.$cource->slug)); !!}
        </figure>
        <div class="tg-qrcodedetail">
            <span class="lnr lnr-laptop-phone"></span>
            <div class="tg-qrcodefeat">
                <h3>{{ trans('lang.scan_with_smartphone') }} <span>{{ trans('lang.smartphone') }} </span> {{ trans('lang.get_handy') }}</h3>
            </div>
        </div>
    </div>
    @if (file_exists(resource_path('views/extend/front-end/cources/sidebar/addtofavourite.blade.php'))) 
        @include('extend.front-end.cources.sidebar.addtofavourite')
    @else 
        @include('front-end.cources.sidebar.addtofavourite')
    @endif
</div>
