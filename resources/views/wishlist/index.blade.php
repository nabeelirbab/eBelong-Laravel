@extends(file_exists(resource_path('views/extend/front-end/master.blade.php')) ? 
'extend.front-end.master':
 'front-end.master', ['body_class' => 'wt-innerbgcolor'] )
@section('content')
<head>
	<link href="{{ asset('css/home.css') }}" rel="stylesheet">
</head>
<section>
    <div class="container"  id='candidate_wislist'>
        <div class="row">
            <candidate_wishlist></candidate_wishlist>
        </div>
        
       
    </div>
</section>
@endsection