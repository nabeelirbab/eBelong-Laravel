@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ?
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="landing-page">
    <div class="container">
        <div class="row section1 margin-row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 section1_right">
                <div class="section1_headline">
                    <h3 class="section1_firstTitle">For companies</h3>
                    <h1 class="section1_headlineTitle">Tired of fighting with Silicon Valley giants to hire software developers?</h1>
                    <div class="Section1_subTitle">Hire senior pre-vetted remote developers with strong technical and communication skills at unbeatable prices, ready to work in your timezone.</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 section1_left">
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
        <div class="row section2 margin-row"> 
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 order-2 section2_right">
                <div class="section2_image section2_image_height">
                    <span>
                        <img src="{{ asset('uploads/settings/general/image-1.jpg') }}" alt="img 1"/>
                    </span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 section2_left">
                <div class="section2_left_info">
                    <div class="section2_left_infoWrap">
                        <h2 class="section2_left_info-list-title tablet-hidden mobile-hidden">High quality/cost ratio</h2>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="https://www.turing.com/img/icons/icon-box-money.svg">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3>Hire Silicon Valley caliber at half the cost</h3>
                                <p class="section2_left_list-item-text">
                                    Hire the top 1% of 1.5 million+ developers from 150+ countries who have applied to Turing.
                                </p>
                            </div>
                        </div>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="https://www.turing.com/img/icons/icon-box-skills.svg">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3>100+ skills available</h3>
                                <p class="section2_left_list-item-text">
                                    Hire React, Node, Python, Angular, Swift, React Native, Android, Java, Rails, Golang, DevOps, ML, Data Engineers, and more.
                                </p>
                            </div>
                        </div>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="https://www.turing.com/img/icons/icon-box-guard.svg">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3>Zero risk</h3>
                                <p class="section2_left_list-item-text">
                                    If you decide to stop within two weeks, you pay nothing.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row section3 margin-row reverse-logic flex-column-reverse"> 
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 section2_right">
                <div class="section2_image section2_image_height">
                    <span>
                        <img src="{{ asset('uploads/settings/general/image-2.png') }}" alt="img 2"/>
                    </span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 section2_left">
                <div class="section2_left_info">
                    <div class="section2_left_infoWrap">
                        <h2 class="section2_left_info-list-title tablet-hidden mobile-hidden">Rigorous Vetting</h2>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="https://www.turing.com/img/icons/icon-box-checked.svg">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3>5+ hours of tests and interviews</h3>
                                <p class="section2_left_list-item-text">
                                    More rigorous than Silicon Valley job interviews. We test for 100+ skills, data structures, algorithms, systems design, software specializations & frameworks.
                                </p>
                            </div>
                        </div>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="https://www.turing.com/img/icons/icon-box-medal.svg">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3>Seniority tests</h3>
                                <p class="section2_left_list-item-text">
                                    We select excellent communicators who can proactively take ownership of business and product objectives without micromanagement.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row section4 margin-row"> 
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 order-2 section2_right">
                <div class="section2_image section2_image_height">
                    <span>
                        <img src="{{ asset('uploads/settings/general/image-3.jpg') }}" alt="img 3"/>
                    </span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 section2_left">
                <div class="section2_left_info">
                    <div class="section2_left_infoWrap">
                        <h2 class="section2_left_info-list-title tablet-hidden mobile-hidden">Effective collaboration</h2>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="https://www.turing.com/img/icons/icon-box-timezone.svg">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3>Daily updates</h3>
                                <p class="section2_left_list-item-text">
                                    Turing’s Workspace gives you even more visibility into your remote developer’s work with automatic time tracking & virtual daily stand-ups.
                                </p>
                            </div>
                        </div>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="https://www.turing.com/img/icons/icon-box-manage.svg">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3>Easy to manage</h3>
                                <p class="section2_left_list-item-text">
                                    High visibility makes eBelong developers easy to manage and ensures that they constantly work on what’s most valuable to you.
                                </p>
                            </div>
                        </div>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="https://www.turing.com/img/icons/icon-box-calendar.svg">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3>Match your timezone</h3>
                                <p class="section2_left_list-item-text">
                                    Our developers match your time zone and overlap a minimum of 4 hours with your workday.
                                </p>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="color_section">
        <div class="container">
            <h5 class="BackedBySection_title">
                Join 200+ fast-scaling start-ups<br/>
                and Fortune 500 companies that have hired eBelong developers
            </h5>
            <h6 class="BackedBySection_subtitle">Including top companies backed by</h6>
            <div class="BackedBySection_logos">
                <span>
                    <img alt="" aria-hidden="true" src="https://www.turing.com/img/backed-by/google-white.svg">
                </span>
                <span>
                    <img alt="" aria-hidden="true" src="https://www.turing.com/img/backed-by/andressen-white.svg">
                </span>
                <span>
                    <img alt="" aria-hidden="true" src="https://www.turing.com/img/backed-by/bloomerg-white.svg">
                </span>
                <span>
                    <img alt="" aria-hidden="true" src="https://www.turing.com/img/backed-by/kleiner-white.svg">
                </span>
                <span>
                    <img alt="" aria-hidden="true" src="https://www.turing.com/img/backed-by/founders-white.svg">
                </span>
            </div>
        </div>
    </section>
    <section class="section5">
        <div class="container">
            <div class="section5_heading">
                <h2 class="section5_title">How to hire top remote developers through eBelong?</h2>
            </div>
            <ol class="processBox_list">
                <li class="processBox_listItem">
                    <div class="processBox_item">
                        <span class="processBox_index"></span>
                        <div class="processBox_textWrap">
                            <h3 class="processBox_title">
                                <!-- <span class="processBox_index"></span> -->
                                <span>Tell us the skills you need<br></span>
                            </h3>
                            <p>We’ll schedule a call and understand your requirements.</p>
                        </div>
                    </div>
                </li>
                <li class="processBox_listItem">
                    <div class="processBox_item">
                        <span class="processBox_index"></span>
                        <div class="processBox_textWrap">
                            <h3 class="processBox_title">
                                <!-- <span class="processBox_index"></span> -->
                                <span>We find the best talent for you<br></span>
                            </h3>
                            <p>Get a list of pre-vetted candidates within days.</p>
                        </div>
                    </div>
                </li>
                <li class="processBox_listItem">
                    <div class="processBox_item">
                        <span class="processBox_index"></span>
                        <div class="processBox_textWrap">
                            <h3 class="processBox_title">
                                <!-- <span class="processBox_index"></span> -->
                                <span>Schedule interviews<br></span>
                            </h3>
                            <p>Meet and select the developers you like.</p>
                        </div>
                    </div>
                </li>
                <li class="processBox_listItem">
                    <div class="processBox_item">
                        <span class="processBox_index"></span>
                        <div class="processBox_textWrap">
                            <h3 class="processBox_title">
                                <!-- <span class="processBox_index"></span> -->
                                <span>Begin your trial<br></span>
                            </h3>
                            <p>Start building with a no-risk 2 week trial period.</p>
                        </div>
                    </div>
                </li>
            </ol>
        </div>
    </section>
    <section class="video_section">
        <div class="container">
            <video width="80%" controls>
            <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
            </video>
        </div>
    </section>
    <section class="section6">
        <div class="container">
            <div class="GradientCard_list">
                <div class="GradientCard_root" href="/press">
                    <div class="GradientCard_gradient GradientCard_gradient-purple">
                        <span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%">
                            <span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%">
                                <img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="https://www.turing.com/icons/campaign.svg">
                            </span>
                        </span>
                    </div>
                    <div class="GradientCard_content">
                        <h3>Press</h3>
                        <div>What's up with Turing? Get the latest news about us here.
                        </div>
                    </div>
                </div>
                <div class="GradientCard_root" href="/press">
                    <div class="GradientCard_gradient GradientCard_gradient-blue">
                        <span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%">
                            <span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%">
                                <img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="https://www.turing.com/icons/blog.svg">
                            </span>
                        </span>
                    </div>
                    <div class="GradientCard_content">
                        <h3>Blog</h3>
                        <div>Know more about remote work. Check out our blog here.
                        </div>
                    </div>
                </div>
                <div class="GradientCard_root" href="/press">
                    <div class="GradientCard_gradient GradientCard_gradient-green">
                        <span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%">
                            <span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%">
                                <img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="https://www.turing.com/icons/contact.svg">
                            </span>
                        </span>
                    </div>
                    <div class="GradientCard_content">
                        <h3>Contact</h3>
                        <div>Have any questions? We'd love to hear from you.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
