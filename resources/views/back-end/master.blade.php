@extends('master')
@push('stylesheets')
    @stack('backend_stylesheets')
    <link href="{{ asset('css/chosen.css') }}" rel="stylesheet">
	<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dbresponsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/emojionearea.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/basictable.css') }}" rel="stylesheet"> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>  #recorder, #playback {
	width: 100%;
	max-width: 640px;
	display: none;
}
</style>
@endpush
@section('header')
    @if (file_exists(resource_path('views/extend/includes/header.blade.php')))
        @include('extend.includes.header')
    @else 
        @include('includes.header')
    @endif
@endsection
@section('main')

	<main id="wt-main" class="wt-main wt-haslayout">
        @if (Auth::user())
            @if (file_exists(resource_path('views/extend/back-end/includes/dashboard-menu.blade.php')))
                @include('extend.back-end.includes.dashboard-menu')
            @else 
                @include('back-end.includes.dashboard-menu')
            @endif
        @endif
        @yield('content')
    </main>

@endsection
@push('scripts')
    <script src="{{ asset('js/chosen.jquery.js') }}"></script>
    <script src="{{ asset('js/jquery.basictable.min.js') }}"></script>
	
    <script>
        jQuery('.chosen-select').chosen();
        jQuery('.wt-tablecategories').basictable({
            breakpoint: 767,
        });
        jQuery('.wt-ordertable').basictable({ breakpoint: 420,});

        /*========== For agency user assign in freelancer ==========*/
		@if(Request::segment(1) == "profile" && Request::segment(2) == "settings" &&
			Request::segment(3) == "manage-account" && Helper::getRoleByUserID(Auth::user()->id) == 3)
			jQuery(document).ready(function(){
				jQuery('.profile-freelancer-type-section select[name="freelancer_type"]').change(function(){
					if($(this).val() == "Agency Freelancers"){
						var form = "";
						form += "<div class='wt-tabscontenttitle'>"+
									"<h2>{{{ trans('lang.agency_section') }}}</h2>"+
								"</div>"+
								"<div class='wt-settingscontent'>"+ 
									"<div class='wt-description'>"+
										"<p>{{{ trans('lang.select_option') }}}</p>"+
									"</div>"+
									"<div class='wt-formtheme wt-userform'>"+
										"<div class='form-group'>"+
											"<input type='radio' name='agency_type' value='existing_agency'> Existing Agency &nbsp;&nbsp; "+
											"<input type='radio' name='agency_type' value='new_agency'> Create New Agency"+
										"</div>"+
									"</div>"+
									"<div class='wt-formtheme wt-userform agency-form'></div>"+
								"</div>";
						$(this).parents('.profile-freelancer-type-section').next('.agency-selection-form').append(form).css('display','block');
					}else{
						$(this).parents('.profile-freelancer-type-section').next('.agency-selection-form').html('').css('display','none');
					}
				});
				
				jQuery('body').on('change','.agency-selection-form input[name="agency_type"]',function(){
					$('.agency-selection-form .agency-form').html('');
					if($(this).val() == "existing_agency"){
						//var agencylist = JSON.parse('{!! json_encode(Helper::getAgencyList()) !!}');
						var existingAgnecyList = 
							"<div class='row'>"+ 
								"<div class='col-md-12'>"+ 
									"<div class='form-group'>"+ 
										"<input class='form-control' id='agency_search'><input type='hidden'  name='agency_id'>"; 
							existingAgnecyList += 	"</div>"+
								"</div>"+
							"</div>";
						$(this).parents('.agency-selection-form').find('.agency-form').append(existingAgnecyList); 
						loadautocomplete('agency_search');
					}else if($(this).val() == "new_agency"){
						var newAgency = 
							"<div class='row'>"+ 
								"<div class='col-md-6'>"+ 
									"<div class='form-group'>"+ 
										"<input type='text' name='agency_name' placeholder='Agency Name' class='form-control'>"+
									"</div>"+
								"</div>"+
								
								"<div class='col-md-6'>"+ 
									"<div class='form-group'>"+ 
										"<input type='text' name='contact_no' placeholder='Agency Contect No' class='form-control'>"+
									"</div>"+
								"</div>"+
								
								"<div class='col-md-12'>"+ 
									"<div class='form-group'>"+ 
										"<input type='text' name='contact_email' placeholder='Agency Email' class='form-control'>"+
									"</div>"+
								"</div>"+
							"</div>";
						$(this).parents('.agency-selection-form').find('.agency-form').append(newAgency);
					}
				});
			});
		@endif
		/*========== End agency user assign in freelancer ==========*/
	</script>
@stack('stripe')
	<script src="{{ asset('js/bootstrap-typeahead.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function(){
			if($('#agency_search').length){
				loadautocomplete('agency_search');
			}
		});

		function loadautocomplete(id){
			$('#'+id).typeahead({
				hint: true,
				highlight: true,
				minLength: 1,
				ajax: {
					url: '{{ env("APP_URL") }}/get-agency-list',
					timeout: 500,
					displayField: "agency_name",
					value: "value",
					triggerLength: 1,
					method: "get",
					loadingClass: "loading-circle",
					preDispatch: function (query) {
						return {
							query: query
						}
					},
					preProcess: function (data) {
						if (data.success === false) {
							// Hide the list, there was some error
							return false;
						}
						// We good!
						return data.options;
					}
				}
			});

			$("#"+id).on('typeahead:selected', function (e, datum) {  
				console.log(datum); 
				$('input[name=agency_id]').val(datum.value);
			});
		}
	</script>
@endpush
