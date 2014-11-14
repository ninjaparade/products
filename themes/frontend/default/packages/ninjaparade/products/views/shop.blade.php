@extends('layouts/default')

{{-- Page title --}}
@section('title')
52 North Shop
@parent
@stop

{{-- Meta description --}}
@section('meta-description')
52 North Shop
@stop

{{ Asset::queue('jquery.form.js', 'ninjaparade/products::js/form/jquery.form.js', 'jquery') }}
{{ Asset::queue('bootstrap.modal', 'bootstrap/js/modal.js', 'jquery') }}
{{-- Page content --}}
@section('content')
<div id="content-wrapper">

<div id="image-background"></div>
<video id="video-background" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0">
<source src="videos/splash.webm" type="video/webm">
		<source src="{{Asset::getUrl('img/global/video/background3.mp4')}}" type="video/mp4">
		Video not supported
	</video>


	<div class="page-wrapper">
		<div class="page-window">
			<h1>the 52 North Shop</h1>
			<p><span class="grey-underline"></span></p>
			<p>Enjoy British Columbia’s most refreshing drink by having 52° North conveniently delivered by the case to your door.</p>
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
                        	{{ Form::selectRange('quantity', 1, 20, $qty[$product->id] , array('class' => 'product-qty form-control') )}}

                        	@if($qty[$product->id])
                        	{{ Form::submit('UPDATE CART', array('class'=> 'ajax-cart add-to-cart', 'data-action' => 'add', 'data-name' => $product->name ))}}
                        	@else
                        	{{ Form::submit('ADD TO CART', array('class'=> 'ajax-cart add-to-cart', 'data-action' => 'add', 'data-name' => $product->name ))}}
                        	@endif
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


@include('ninjaparade/cart::cart-notification')
@stop


@section('scripts')
<script>
	$('.ajax-cart').on('click', function(event) {
		event.preventDefault();
		
		ga('send', 'event', 'category', 'action', 'label', $(this).data('name') );

		$(this).closest('form').ajaxSubmit({
			success: function (response){
			     $.get( "{{URL::route('cart.get_modal')}}", function( data ) {
                   $('#cart-content').html(data);
                   $('#cart-modal').modal({
                    keyboard: false
                   });
                 });




				$('.cart-nav').next('span').html( "( " + response.count + " )");

			}
		});
	});
</script>
@stop