@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">

@section('content')
    <section class="wt-haslayout wt-dbsectionspace" id="profile_settings">

    <div >
        <div >
            <h2>Ebelong Statistics</h2>
            <div >
            <div >

                <div >
                {!! $chart->container() !!}
                </div>
                <hr>
                {!!$pie->container() !!}
            </div>
            </div>
        </div>
    </div>
    {!! $chart->script() !!}
    {!! $pie->script() !!}

    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
