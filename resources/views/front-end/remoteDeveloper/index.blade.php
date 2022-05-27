@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ?
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
@section('content')

<div class="container landing-page">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">Left side</div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif
            <div class="form-banner">
                <h2>Fill out the form and one of our Publishing  experts will contact you promptly</h2>
                <form action="{{ url('/post-guest-message') }}" method="post" class="cmxform banner-form" id="bannerform">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="name" id="bnm" placeholder="Name:"> 
                        </div>
                        <div class="col-md-6">
                            <input type="phone"  name="phone" placeholder="Phone:" id="bpn"> 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="email" placeholder="Email:" id="bem" name="email">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <textarea name="message" id="bmsg" rows="10" placeholder="Message"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" value="Submit" id="banner-form-submit" name="banner-form-submit" placeholder="Connect With Us">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6290b9a3b0d10b6f3e745567/1g42laa69';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
