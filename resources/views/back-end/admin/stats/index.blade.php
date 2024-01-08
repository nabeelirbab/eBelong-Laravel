@extends(file_exists(resource_path('views/extend/back-end/master.blade.php')) ? 'extend.back-end.master' : 'back-end.master')
@push('stylesheets')
<style>
.card {
    border-radius: 12px;
}
.card-inner {
    padding: 1.5rem;
    text-align: center;
}
</style>
@endpush
@section('content')
    <section class="wt-haslayout wt-dbsectionspace" id="profile_settings">

    <div >
        <div >
            <h2>Ebelong Statistics</h2>
            <div class="row mb-4">
            <div class="col-xxl-3 col-md-3  col-sm-6">
                <div class="card">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">
                            <div class="">
                                <div class="card-title">
                                    <h6 class="title">Total Users</h6>
                                </div>
                            </div>
                            <div class="data">
                                <div class="">
                                    <div class="amount">{{ $users }}</div>
                                    
                                </div>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
                </div>
                <div class="col-xxl-3 col-md-3 col-sm-6">
                    <div class="card">
                        <div class="nk-ecwg nk-ecwg6">
                            <div class="card-inner">
                                <div class="">
                                    <div class="card-title">
                                        <h6 class="title">Total Jobs</h6>
                                    </div>
                                </div>
                                <div class="data">
                                    <div class="">
                                        <div class="amount">{{ $jobs }}</div>
                                        
                                    </div>
                                </div>
                            </div><!-- .card-inner -->
                        </div><!-- .nk-ecwg -->
                    </div><!-- .card -->
                    </div>
                    <div class="col-xxl-3 col-md-3 col-sm-6">
                        <div class="card">
                            <div class="nk-ecwg nk-ecwg6">
                                <div class="card-inner">
                                    <div class="">
                                        <div class="card-title">
                                            <h6 class="title">Total Courses</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="">
                                            <div class="amount">{{ $cources }}</div>
                                            
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                            </div><!-- .nk-ecwg -->
                        </div><!-- .card -->
                        </div>
                        <div class="col-xxl-3 col-md-3 col-sm-6">
                        <div class="card">
                            <div class="nk-ecwg nk-ecwg6">
                                <div class="card-inner">
                                    <div class="">
                                        <div class="card-title">
                                            <h6 class="title">Total Services</h6>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="">
                                            <div class="amount">{{ $services }}</div>
                                            
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                            </div><!-- .nk-ecwg -->
                        </div><!-- .card -->
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-xxl-3 col-md-3  col-sm-6">
                            <div class="card">
                                <div class="nk-ecwg nk-ecwg6">
                                    <div class="card-inner">
                                        <div class="">
                                            <div class="card-title">
                                                <h6 class="title">Total Active Users</h6>
                                            </div>
                                        </div>
                                        <div class="data">
                                            <div class="">
                                                <div class="amount">{{ $active_users }}</div>
                                                
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                </div><!-- .nk-ecwg -->
                            </div><!-- .card -->
                            </div>
                            <div class="col-xxl-3 col-md-3 col-sm-6">
                                <div class="card">
                                    <div class="nk-ecwg nk-ecwg6">
                                        <div class="card-inner">
                                            <div class="">
                                                <div class="card-title">
                                                    <h6 class="title">Users with percentage completed more than 60%</h6>
                                                </div>
                                            </div>
                                            <div class="data">
                                                <div class="">
                                                    <div class="amount">{{ $profileCount }}</div>
                                                    
                                                </div>
                                            </div>
                                        </div><!-- .card-inner -->
                                    </div><!-- .nk-ecwg -->
                                </div><!-- .card -->
                                </div>
                                <div class="col-xxl-3 col-md-3 col-sm-6">
                                    <div class="card">
                                        <div class="nk-ecwg nk-ecwg6">
                                            <div class="card-inner">
                                                <div class="">
                                                    <div class="card-title">
                                                        <h6 class="title">This week added users</h6>
                                                    </div>
                                                </div>
                                                <div class="data">
                                                    <div class="">
                                                        <div class="amount">{{ $thisweek }}</div>
                                                        
                                                    </div>
                                                </div>
                                            </div><!-- .card-inner -->
                                        </div><!-- .nk-ecwg -->
                                    </div><!-- .card -->
                                    </div>
                                </div>
                                
                    <div >
                        <div >
                        <div >
                        {!! $chart->container() !!}
                        </div>
                        <hr>
                        {{-- {!!$pie->container() !!} --}}
                    </div>
                    </div>
                </div>
            </div>
            {!! $chart->script() !!}
            {!! $pie->script() !!}

            </section>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        @endsection
