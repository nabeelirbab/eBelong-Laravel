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
            <div class="form-banner">
                <h2>Fill out the form and one of our Publishing  experts will contact you promptly</h2>
                <form action="" method="post" class="cmxform banner-form" id="bannerform">

                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" required="" name="name" id="bnm" placeholder="Name:"> 
                        </div>
                        <div class="col-md-6">
                            <input type="phone" required="" name="phone" placeholder="Phone:" id="bpn"> 
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="email" name="email" required="" placeholder="Email:" id="bem">
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-md-12">
                            <textarea name="msg" id="bmsg" rows="10" placeholder="Message"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" value="Submit" id="banner-form-submit" name="banner-form-submit" placeholder="Connect With Us" required="">
                            <input type="hidden" id="web_url" class="web_url" value="amazonpublishingcentral.com/">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection