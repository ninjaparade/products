@extends('layouts/default')

{{-- Page title --}}
@section('title')

@parent
@stop

{{-- Meta description --}}
@section('meta-description')

@stop

{{ Asset::queue('jquery.form.js', 'ninjaparade/products::js/form/jquery.form.js', 'jquery') }}
{{-- Page content --}}
@section('content')
<div id="content-wrapper">

<div id="image-background">
	
</div>
<video id="video-background" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0"> 
<source src="videos/splash.webm" type="video/webm"> 
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
					<img src="@media($product->image)" alt="{{$product->name}}">
					<div class="caption">
						<h2>{{{ $product->name }}}</h2>
						<p class="description">{{{ $product->description }}}</p>
						<p class="price">{{ $product->price }}</p>

						<div class="product-form">
							{{ Form::open(array('url' => URL::route('cart.add', [$product->id]), 'method' => 'post', 'class'=>'form-inline'))}}
                        	{{ Form::selectRange('quantity', 1, 20,null, array('class' => 'product-qty form-control') )}}
                        	{{ Form::submit('ADD TO CART', array('class'=> 'ajax-cart add-to-cart', 'data-action' => 'add'))}}
                        	{{Form::close()}} 
						</div>	
					</div>
				</div>
				@endforeach

		{{-- shop-items --}}
		</div>
	{{-- page body --}}
	</div>
{{-- page wrapper --}}
</div>

</div>
@stop



@section('scripts')
<script>
	$('.ajax-cart').on('click', function(event) {
		event.preventDefault();
	
		$(this).closest('form').ajaxSubmit({

			success: function (response){
				console.log(response);
				$('.cart-nav').next('span').html( "( " + response.count + " )");
				// button.button('reset');
			}
		});
	});
</script>
@stop