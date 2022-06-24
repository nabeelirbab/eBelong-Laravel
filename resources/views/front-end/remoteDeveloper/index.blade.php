@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ?
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@push('stylesheets')
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endpush
@section('title'){{$remote_list_meta_title }} @stop
@section('description', $remote_list_meta_desc)
@section('content')
@include('sweetalert::alert')
<div class="landing-page">
    <div class="container">
        <div class="row section1 margin-row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 section1_right">
                <div class="section1_headline">
                    <!-- <h3 class="section1_firstTitle"></h3> -->
                    <h1 class="section1_headlineTitle">Looking to Hire Remote Developers?</h1>
                    <div class="Section1_subTitle">Are you in the market for vetted remote developers and software programmers that have sharp technical and interactive skills, we have just what you're looking for!</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 section1_left">
              
                {{-- @if (Session::has('message'))
                    <div class="alert alert-success">
                        {{ Session::get('message') }}
                    </div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif --}}
               
                <div class="form-banner">
                    <h2>Fill out the form and one of our Hiring experts will contact you promptly</h2>
                    <form action="{{ url('/post-guest-message') }}" method="post" class="cmxform banner-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="name" id="bnm" placeholder="Name:" value="{{ old('name') }}"> 
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" style="display: block; position: absolute; bottom: -19px;" role="alert">
                                        {{ $errors->first('name') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <input  onkeypress="
                                 const allowedRegex = /[0-9]/g;
                                if (!event.key.match(allowedRegex)) {
                                    event.preventDefault();
                                }
                                "type="phone"  name="phone" placeholder="Phone:" id="bpn" value="{{ old('phone') }}"
                               > 
                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback"style="display: block; position: absolute; bottom: 20px;" role="alert">
                                        {{ $errors->first('phone') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <input type="email" placeholder="Email:" id="bem" name="guest_email" value="{{ old('guest_email') }}">
                                @if ($errors->has('guest_email'))
                                    <span class="invalid-feedback" style="display: block; position: absolute; bottom: 20px;" role="alert">
                                        {{ $errors->first('guest_email') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="message" id="bmsg" rows="10" placeholder="Message">{{ old('message') }}</textarea>
                                @if ($errors->has('message'))
                                    <span class="invalid-feedback"style="display: block; position: absolute; bottom: 0px;" role="alert">
                                        {{ $errors->first('message') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" value="Submit" placeholder="Connect With Us">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row additional-section">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h2 class="additional_headlineTitle">
                    Take on the most Professional Remote Developers 
                </h2>
                <p class="additional_subTitle">
                    Whether your business requires teams or individuals for remote development, app buildout, web development, or any other software development projects we have strong programmers and engineers waiting to help you.
                </p>
            </div>
        </div>
        <div class="row additional-section">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h2 class="additional_headlineTitle">
                    How Do We Locate Qualified Software Developers for Your Needs? 
                </h2>
                <p class="additional_subTitle1">
                    Firstly, our people will hear out and pay close attention to your requirements, this is inclusive of project details, position descriptions, the desired outcome, and required workflow. All these key points help us find the ideal team of specialists for you.
                </p>
                <p class="additional_subTitle1">
                    Next up, after getting a basic layout of your plan, our team reviews candidates to find the best remote developers and programmers for you. Checking out their tech skills, language proficiency, background but also their soft skills. Soft skills, are essential and enhance an individual's technical abilities, allowing them to figure out your unique needs and arrange plans for designing programs. We'll present you with a list of the most suitable developers and programmers available.
                </p>
                <p class="additional_subTitle">
                    On to the next step, after you finalize your choice from our list of developers and hire remote developers or hire software programmers they are integrated into your project to improve efficiency. In the end, you will have a team of professionals, or an individual if you prefer, working for you directly just like an in-house team but the only difference is, that our team works remotely.
                </p>
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
                        <h2 class="section2_left_info-list-title tablet-hidden mobile-hidden"></h2>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="{{ asset('uploads/settings/landingpageicons/icon-box-money.svg') }}">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3 style="margin-bottom: 60px;">Top Tier Talent at Half The Cost</h3>
                                <!-- <p class="section2_left_list-item-text">
                                    Hire the top 1% of 1.5 million+ developers from 150+ countries who have applied to eBelong.
                                </p> -->
                            </div>
                        </div>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="{{ asset('uploads/settings/landingpageicons/icon-box-skills.svg') }}">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3 style="margin-bottom: 60px;">100+ skills</h3>
                                <!-- <p class="section2_left_list-item-text">
                                    Hire React, Node, React Native, Python, Golang, Data Engineers, Angular, DevOps, Rails, Swift, Android, Java, ML, and more.
                                </p> -->
                            </div>
                        </div>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="{{ asset('uploads/settings/landingpageicons/icon-box-guard.svg') }}">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info">
                                <h3 style="margin-bottom: 60px;">Vetted Developers</h3>
                                <!-- <p class="section2_left_list-item-text">
                                    If you decide to stop within two weeks, you pay nothing.
                                </p> -->
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
                        <h2 class="section2_left_info-list-title tablet-hidden mobile-hidden">Expert Vetted Talent</h2>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="{{ asset('uploads/settings/landingpageicons/icon-box-checked.svg') }}">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info" style="margin-bottom: 20px;">
                                <!-- <h3>5+ hours of tests and interviews</h3> -->
                                <p class="section2_left_list-item-text">
                                    We look for great communicators who can take charge of business and product goals without the need of being micromanaged.
                                </p>
                            </div>
                        </div>
                        <div class="section2_left_list-item">
                            <div class="section2_left_list-item-icon">
                                <span>
                                    <img alt="icon" src="{{ asset('uploads/settings/landingpageicons/icon-box-medal.svg') }}">
                                </span>
                            </div>
                            <div class="section2_left_list-item-info" style="margin-bottom: 20px;">
                                <!-- <h3>Seniority tests</h3> -->
                                <p class="section2_left_list-item-text">
                                    We extensively screen our remote developers to ensure that you are only matched with top-tier talent.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row section4 margin-row"> 
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
                                    <img alt="icon" src="{{ asset('uploads/settings/landingpageicons/icon-box-timezone.svg') }}">
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
                                    <img alt="icon" src="{{ asset('uploads/settings/landingpageicons/icon-box-manage.svg') }}">
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
                                    <img alt="icon" src="{{ asset('uploads/settings/landingpageicons/icon-box-calendar.svg') }}">
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
        </div> -->
        <div class="row additional-section">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h2 class="additional_headlineTitle">
                    Advantages of Hiring Remote Developers and Programmers for your Business 
                </h2>
                <p class="additional_subTitle">
                    The world is quickly changing and remote jobs are going to be the next big thing, the shift to remote work has already begun and In fact, there are many advantages to this type of hiring.
                </p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h3 class="additional_headlineTitle1">
                    1. Lower Operational Costs  
                </h3>
                <p class="additional_subTitle1">
                    Hiring a remote development team is financially smart and will save you some big bucks in the long run. Not only does it prevent you from spending unnecessarily on rent for a workplace but It even cuts down the costs of the hiring procedure. Rather than spending hours looking for the best candidate, you can simply choose a company to do it for you, and in the end, you'll have a team of experts at your disposal at lower costs.
                </p>
                <h3 class="additional_headlineTitle1">
                    2. Larger Pool of Candidates  
                </h3>
                <p class="additional_subTitle1">
                    Hiring remote developers gives you an undeniable competitive edge because unlike the companies hiring in-house employees, you can hire anyone from around the world. Meaning you have a much higher chance of finding talented, dedicated, and smart employees.
                </p>
                <h3 class="additional_headlineTitle1">
                    3. Developers' Availability  
                </h3>
                <p class="additional_subTitle">
                    Some projects will require a massive number of hours from your team, and this simply isn't feasible in the long run when it comes to an in-house developers team. On the other hand, remote programmers and remote software developers are hired from around the globe, and can likely work on a project at any time since you will be hiring different individuals from different countries. Multiple individuals can work on one project at all hours allowing you to exert double the amount of effort in the same amount of time.
                </p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h2 class="additional_headlineTitle">
                    Tips to Streamline Communication with your Team of Remote Developers 
                </h2>
                <p class="additional_subTitle">
                    Now that you've decided on hiring remote software developers and programmers, How can you avoid misunderstandings, and cooperate successfully with your remote development team?
                </p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h3 class="additional_headlineTitle1">
                    1. Share the Knowledge  
                </h3>
                <p class="additional_subTitle1">
                    Unshared knowledge has been known to have a negative long-term impact on your bottom line but also on your team's day-to-day productivity and workflow. Make sure you and your remote developers and software programmers are on the same page about the project and different tasks at all times. To avoid duplicating each other's work or getting stuck teams should be communicating and exchanging information through some form of regular documentation and even live training or one-on-one meetings. These are some of the key ways to ensure your team has access to required information at any given time, saving precious time in the long run.
                </p>
                <h3 class="additional_headlineTitle1">
                    2. Establish Coding Practices  
                </h3>
                <p class="additional_subTitle1">
                    Many different coding practices exist and making sure you and your developer's vision of exactly what is to be done will help prevent miscommunication from the start. This means clarifying all features and characteristics of the project such as which data structure they are accustomed to or if they comment on their code.
                </p>
                <h3 class="additional_headlineTitle1">
                    3. Build Trust  
                </h3>
                <p class="additional_subTitle">
                    To achieve maximum success, proper communication with your remote developer's team is a key factor. Show interest in your team and share all the required knowledge with them, motivating them with regular meetings and conferences dedicated to tackling communication issues. Show them that you are willing to solve their problems and are just as dedicated to them as they are to you, this will help foster a strong and fruitful relationship, which is essential for your business and workplace morale.
                </p>
            </div>
        </div>
    </div> 
    <section class="color_section">
        <div class="container">
            <h5 class="BackedBySection_title">
                Join 200+ fast-scaling start-ups<br/>
                and Fortune 500 companies that have hired eBelong developers
            </h5>
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
    <!-- <section class="video_section">
        <div class="container">
            <video width="80%" controls>
            <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
            </video>
        </div>
    </section> -->
    <section class="section6">
        <div class="container">
            <div class="GradientCard_list">
                <!-- <div class="GradientCard_root" href="/press">
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
                </div> -->
                <a class="GradientCard_root" href="/blogs">
                    <div class="GradientCard_gradient GradientCard_gradient-purple">
                        <span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%">
                            <span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%">
                                <img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="{{ asset('uploads/settings/landingpageicons/blog-icon-white.svg') }}">
                            </span>
                        </span>
                    </div>
                    <div class="GradientCard_content">
                        <h3>Blog</h3>
                        <div>Know more about remote work. Check out our blog here.
                        </div>
                    </div>
                </a>
                <a class="GradientCard_root" href="/press">
                    <div class="GradientCard_gradient GradientCard_gradient-green">
                        <span style="box-sizing:border-box;display:inline-block;overflow:hidden;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;position:relative;max-width:100%">
                            <span style="box-sizing:border-box;display:block;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0;max-width:100%">
                                <img style="display:block;max-width:100%;width:initial;height:initial;background:none;opacity:1;border:0;margin:0;padding:0" alt="" aria-hidden="true" src="{{ asset('uploads/settings/landingpageicons/contact-us.svg') }}">
                            </span>
                        </span>
                    </div>
                    <div class="GradientCard_content">
                        <h3>Contact</h3>
                        <div>Have any questions? We'd love to hear from you.
                        </div>
                    </div>
                </a>
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
    setTimeout(function () {
    
    Tawk_API.maximize();
    
}, 10000);
    })();
 
    </script>
    <!--End of Tawk.to Script-->
