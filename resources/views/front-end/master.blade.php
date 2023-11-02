@extends('master')
@push('stylesheets')

@endpush

@section('header')
	@if (file_exists(resource_path('views/extend/includes/header.blade.php')))
		@include('extend.includes.header')
	@else 
		@include('includes.header')
	@endif
@endsection

@section('slider')
	@yield('homeSlider')
@endsection
@section('main')@stack('stylesheets')

<main id="wt-main" class="wt-main wt-innerbgcolor wt-haslayout {{ !empty($body_class) ? $body_class : '' }}">
    @if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === 'amentotech.com')		
    <div id="wt-demo-sidebar" class="wt-demo-sidebar">			
    <div id="wt-btndemotoggle" class="wt-btndemotoggle">				
    <span class="menu-icon">					
    <i class="lnr lnr-layers"></i>				</span>			</div>			
    <div id="wt-verticalscrollbar" class="wt-verticalscrollbar">				
    <div class="wt-demo-holder">					<a href="{{url('/')}}">						
    <figure class="wt-demo-img">						
    <img src="{{url('images/demo-img/img-01.jpg')}}" alt="img">						
    </figure>					</a>					
    <a href="{{url('page/home-page-two')}}">					
    <figure class="wt-demo-img">						
    <img src="{{url('images/demo-img/img-02.jpg')}}" alt="img">							
    <figcaption>								
    <div class="wt-demo-tags">									
    <span class="wt-demo-new">New</span>							
    </div>							
    </figcaption>						
    </figure>					
    </a>					
    <a href="{{url('page/home-page-three')}}">						
    <figure class="wt-demo-img">							
    <img src="{{url('images/demo-img/img-03.jpg')}}" alt="img">						
    <figcaption>								<div class="wt-demo-tags">									
    <span class="wt-demo-populor">New</span>							
    </div>							
    </figcaption>						
    </figure>					</a>				</div>			</div>		
    <div class="wt-demo-content">				
    <div class="wt-demo-heading">					<h4>Outstanding Demos</h4>					<p>With easy<em> ONE CLICK INSTALL</em> and fully customizable options, our demos are the best start you'll ever get!!</p>					<div class="wt-demo-btns">						<a href="https://codecanyon.net/item/worketic-market-place-for-freelancers/23712284" target="blank" class="wt-demo-btn">Click To LAUNCH</a>					</div>				</div>			</div>		</div>
@endif			
@yield('content')
<!-- Registration Modal -->

<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <!-- <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" onclick="closefunction()" id="closebutton" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div> -->
        <div class="modal-body">
            <div class="talent-popup-t1">Registration</div>
            <!-- <div class="talent-popup-t2">Click <button type="button" id="moveonhome" class="btn btn-primary">here</button> to speed up this process</div> -->
            <div class="talent-popup-t2">Please register to continue browsing our website.</div>
            <div class="talent-popup-buttons">
                <button type="button" onclick="location.href='{{ route('clear.registration.modal') }}'" class="btn btn-secondary" id="cancelbutton" data-dismiss="modal">Cancel</button>
                <a href="{{ route('register') }}" id="moveonhome" class="btn btn-primary">Join Now</a>
            </div>
            
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelbutton" data-dismiss="modal">Close</button>
            <button type="button" id="moveonhome" class="btn btn-primary">Need Assistance</button>
        </div> -->
        </div>
    </div>
</div>
</main>

@endsection


@section('footer')
	@if (file_exists(resource_path('views/extend/front-end/includes/footer.blade.php')))
		@include('extend.front-end.includes.footer')
	@else 
		@include('front-end.includes.footer')
	@endif
@endsection

@section('whatsapp')
	@if (file_exists(resource_path('views/extend/front-end/includes/whatsapp.blade.php')))
		@include('extend.front-end.includes.whatsapp')
	@else 
		@include('front-end.includes.whatsapp')
	@endif
@endsection

@push('scripts')
@if (session('show_registration_modal'))
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Show the modal
            $('#registrationModal').modal('show');
            // Now, make an AJAX request to a route that will forget the session
            $.post('/clear-modal-session', {_token: '{{ csrf_token() }}'}, function(data) {
                // Session 'show_registration_modal' is now cleared
            });
        });
    </script>
@endif

<script>
	jQuery('.wt-btndemotoggle').on('click', function() {
		var _this = jQuery(this);
		_this.parents('.wt-demo-sidebar').toggleClass('wt-demoshow');
	});
</script>
@stack('scripts')
@endpush
