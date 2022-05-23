<!doctype html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="" dir="{{Helper::getTextDirection()}}">
<!--<![endif]-->

<head>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	@if (trim($__env->yieldContent('title')))
		<title>@yield('title')</title>
	@else 
		<title>{{ config('app.name') }}</title>
	@endif
	<meta name="description" content="@yield('description')">
	<meta name="keywords" content="@yield('keywords')">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:image" content="https://dev.ebelong.com/uploads/courses/460/medium-1653306820-wp.png"/>
	<meta property="og:title" content="After Affects"/>
	<meta property="og:type" content="article"/>
	<meta property="og:url" content="https://dev.ebelong.com/course/after-effects"/>
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="icon" href="{{{ asset(Helper::getSiteFavicon()) }}}" type="image/x-icon">
	<link href="{{asset('css/app.css') }}" rel="stylesheet">
	<link href="{{asset('css/normalize-min.css') }}" rel="stylesheet">
	<link href="{{asset('css/scrollbar-min.css') }}" rel="stylesheet">
    <link href="{{asset('css/fontawesome/fontawesome-all.min.css') }}" rel="stylesheet">
	<link href="{{asset('css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{asset('css/themify-icons.css') }}" rel="stylesheet">
	<link href="{{asset('css/jquery-ui-min.css') }}" rel="stylesheet">
	<link href="{{asset('css/linearicons.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.timepicker.css') }}" >
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	 @stack('sliderStyle') 
	<!--<link href="{{ asset('css/prettyPhoto-min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">  -->
	<link href="{{asset('css/main.css') }}" rel="stylesheet">
	<link href="{{asset('css/custom.css') }}" rel="stylesheet">
	<link href="{{asset('css/responsive.css') }}" rel="stylesheet">
	<link href="{{asset('css/rtl.css') }}" rel="stylesheet">
	<link href="{{asset('css/color.css') }}" rel="stylesheet">
	@php echo \App\Typo::setSiteStyling(); @endphp
    <link href="{{asset('css/transitions.css') }}" rel="stylesheet">
	 @stack('stylesheets') 
	<script type="text/javascript">
		var APP_URL = {!! json_encode(url('/')) !!}
		var readmore_trans = {!! json_encode(trans('lang.read_more')) !!}
		var less_trans = {!! json_encode(trans('lang.less')) !!}
		var Map_key = {!! json_encode(Helper::getGoogleMapApiKey()) !!}
		var APP_DIRECTION = {!! json_encode(Helper::getTextDirection()) !!}
	</script>
	@if (Auth::user())
		<script type="text/javascript">
			var USERID = {!! json_encode(Auth::user()->id) !!}
			window.Laravel = {!! json_encode([
			'csrfToken'=> csrf_token(),
			'user'=> [
				'authenticated' => auth()->check(),
				'id' => auth()->check() ? auth()->user()->id : null,
				'name' => auth()->check() ? auth()->user()->first_name : null,
				'image' => !empty(auth()->user()->profile->avater) ? asset('uploads/users/'.auth()->user()->id .'/'.auth()->user()->profile->avater) : asset('images/user-login.png'),
				'image_name' => !empty(auth()->user()->profile->avater) ? auth()->user()->profile->avater : '',
				]
				])
			!!};
		</script>
	@endif
	<script>
		window.trans = <?php
		$lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
		$trans = [];
		foreach ($lang_files as $f) {
			$filename = pathinfo($f)['filename'];
			$trans[$filename] = trans($filename);
		}
		echo json_encode($trans);
		?>;
	</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-47887669-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-47887669-1');
</script>
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '1215284715662272');
	fbq('track', 'PageView');
</script>
<noscript>
	<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1215284715662272&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->


</head>

@php 
	$is_preview = "";
	$is_preview = (array_key_exists("is_preview",$_GET) && $_GET["is_preview"] == 1) ? 	"profile-preview" : "";
@endphp

<body class="wt-login {{Helper::getBodyLangClass()}} {{Helper::getTextDirection()}} {{empty(Request::segment(1)) ? 'home-wrapper' : '' }} {{ $is_preview }}" style="{{ $is_preview != '' ? 'pointer-events:none;': '' }}">
	{{ \App::setLocale(env('APP_LANG')) }}
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<div class="preloader-outer">
		<div class="preloader-holder">
			<div class="loader"></div> 
		</div>
	</div>
	<div id="wt-wrapper" class="wt-wrapper wt-haslayout">
		<div class="wt-contentwrapper">
			@yield('header')
						@yield('slider')			
						  @yield('main') 
			@yield('footer')
			@yield('whatsapp')
		</div>
            <div id="login-notification" class="">
                <notifications group="login-notification" position="bottom left" /></notifications>
            </div>
	</div>
	<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
	@yield('bootstrap_script')
	<script src="{{asset('js/app.js') }}"></script>
	<script src="{{ asset('js/vendor/jquery-library.js') }}"></script>
	<script src="{{ asset('js/scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.timepicker.js' )}}"></script>
   @stack('scripts')
    <script>
        jQuery(window).load(function () {
            jQuery(".preloader-outer").delay(500).fadeOut();
            jQuery(".pins").delay(500).fadeOut("slow");
        });
    </script>

<script>
$('#proj-type').change(function(){    
var selectedval = $(this).val();    
if(selectedval == 'hourly'){
  $('#proj-cost').attr('placeholder','HOURLY RATE');
  $('#hours').removeAttr('disabled');
  $('#hours').css('background-color', '#fff');
  
}else if(selectedval == 'fixed'){
 $('#proj-cost').attr('placeholder','PROJECT COST');
 $('#hours').attr('disabled', 'disabled');
  $('#hours').css('background-color', '#ddd');
  $('#proj-cost').val('');
  $('#hours').val('');  
}else{
	selectedval == 'select_project_type';
	 $('#hours').attr('disabled', 'disabled');
	 $('#hours').attr('placeholder', '');
	 $('#proj-cost').val(''); 
	 $('#hours').val('');
} 
});
</script>

<script type="text/javascript">
  $(document).keydown(function () {	
var seen = {};
$('.list-group span').each(function() {
  var txt = $(this).text();
  if (seen.hasOwnProperty(txt)) {
    $(this).closest("a").remove();
  } else {
    seen[txt] = true;
  }
});
});
</script>


<script>
			$(function() {
				$('#start_time').timepicker();
				$('#end_time').timepicker();
			});
			</script>
			
		<script>
		
       function time_calculation(){
       	 var day = '1/1/1970';
		  var start_time = $('#start_time').val();
		  console.log(start_time);
		  var end_time = $('#end_time').val();
		  console.log(end_time);
		 		 		  
		  var timeStart = new Date("01/01/2007 " + start_time);
		// var timeStart = new Date("01/01/2007 13:15");
		 console.log(timeStart);
		  var timeEnd = new Date("01/01/2007 " + end_time);
		//var timeEnd = new Date("01/01/2007 14:15");
		  console.log(timeEnd);
		  if(timeEnd < timeStart){
		  	alert("Start Time Cannot be Greater than End Time");
		  }else {
		  var diff = (timeEnd - timeStart) / 60000;
		 
		  var minutes = diff % 60;
          var hours = (diff - minutes) / 60;
		  
		  console.log(hours);
		  console.log(minutes);
		// $('#hoursinaday').html('        ' + hours + ' '+ ':' + ' ' + minutes);
		//$('<h2>' + 'Total No of Hours in a Day: ' +  hours + '</h2>'  ).appendTo('#hoursinaday');
		 $('#hours').html(hours);
		 $('#minutes').html(minutes);
		}
       
       }
       $('#start_time').on('change',function(){
		  
		 time_calculation();
		  
	   });
		$('#end_time').on('change',function(){
		  
		   time_calculation();
		
		});
		
		
		</script>
<script>			
$(document).ready(function() {  
	$("button").click(function(){  
		setTimeout(function(){
		$("#captcha").css('display','block');  
	}, 1000);
	}); 
	
}); 
</script>

<script>
$('#continue').on('click',function() {  
   alert('Link Clicked');
   $("#captcha").css('display','none');
  
}); 
</script>

<script>
$(document).ready(function() {  
	if($('#step-2').is(':visible')){
		console.log('Visible');
	}
	
	$(".navbar-toggler").click(function(){
		$("div#navbarNav").toggle();
	});
	  
	$(".filter_icon").click(function(){
		$(this).next('div').slideToggle();
	});
}); 
	</script>
  <script>
$('#send_proposal').on('click',function() {  
   jQuery('.wt-loginarea .wt-loginformhold').slideToggle();
}); 
 
</script>


<script>  
  $( function() {
    $( "#start_date" ).datepicker();
    $( "#end_date" ).datepicker();
  } );
</script>
@if(Request::segment(1) == "admin" && Request::segment(2) == "payouts")
	<script>  
	  $(function(){
		$('.payout-info').click(function(){
			var bankdetails = JSON.parse($(this).attr('rel'));
			var modal = document.getElementById("paymentInfo");
			var span = document.getElementsByClassName("close")[0];
			$('.payout-email').text(bankdetails['email']);
			var account_holder = (bankdetails['account_holder']).trim() == "" ? "-" : bankdetails['account_holder'];
			$('.payout-account-holder').text(account_holder);
			$('.payout-country').text(bankdetails['country']);
			$('.payout-city').text(bankdetails['city']);
			$('.payout-zipcode').text(bankdetails['zipcode']);
			$('.payout-state').text(bankdetails['state']);
			$('.payout-isfccode').text(bankdetails['isfccode']);
			$('.payout-account-no').text(bankdetails['account_number']); 
			modal.style.display = "block";
			 
			 // When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				$('.payout-email').text('');
				$('.payout-account-holder').text('');
				$('.payout-country').text('');
				$('.payout-city').text('');
				$('.payout-zipcode').text('');
				$('.payout-state').text('');
				$('.payout-isfccode').text('');
				$('.payout-account-no').text(''); 
				modal.style.display = "none";
			}

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
			  if (event.target == modal) {
				modal.style.display = "none";
			  }
			}
		});
	  });
	</script>
@endif

</body>
</html>
