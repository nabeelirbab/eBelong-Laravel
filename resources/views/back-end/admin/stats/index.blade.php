@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace" id="profile_settings">

    <div >
        <div >

            <h2>Ebelong Statistics</h2>
            <div >
            <div >

                <div >
                {!! $chart->html() !!}
                </div>
                <hr>
                {!!$pie->html() !!}
            </div>
            </div>
        </div>
    </div>
    {!! Charts::scripts() !!}
    {!! $chart->script() !!}
    {!! $pie->script() !!}

    </section>
@endsection
