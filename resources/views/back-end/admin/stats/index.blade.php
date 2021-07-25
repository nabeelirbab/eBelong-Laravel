@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace" id="profile_settings">

    <div >
        <div >
            <div >
            <div >
                <div >Chart Demo</div>

                <div >
                {!! $chart->html() !!}
                </div>
            </div>
            </div>
        </div>
    </div>
    {!! Charts::scripts() !!}
    {!! $chart->script() !!}

    </section>
@endsection
