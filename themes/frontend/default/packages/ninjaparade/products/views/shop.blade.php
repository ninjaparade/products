@extends('layouts/default')

{{-- Page title --}}
@section('title')

@parent
@stop

{{-- Meta description --}}
@section('meta-description')

@stop


{{-- Page content --}}
@section('content')
<div id="content-wrapper">

	<video id="video_background" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0"> 
<!-- <source src="videos/splash.webm" type="video/webm">  -->
		<source src="{{Asset::getUrl('img/global/video/background3.mp4')}}" type="video/mp4"> 
		Video not supported 
	</video>


	<div class="page-wrapper">
		<div class="page-window">
			<h1>the 52 North Shop</h1>
			<p><span class="grey-underline"></span></p>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>

		<div class="page-body">

			<div class="shop-items">
				@foreach ($products as $product)

				<div id="{{Str::slug($product->name)}}" class="shop-item">
					<img src="@media($product->image)" alt="{{$product->name}}" class="image-responsive">
					<div class="caption">
						<h2>{{{ $product->name }}}</h2>
						<p>{{{ $product->description }}}</p>
						<p>{{ $product->price }}</p>
					</div>
				</div>

			
	@endforeach
		{{-- shop-items --}}
		</div>
	{{-- page body --}}
	</div>
{{-- page wrapper --}}
</div>

@stop



@section('scripts')

@stop