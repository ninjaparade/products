@extends('layouts/default')

@section('title')

@stop

@section('styles')

@stop


{{ Asset::queue('ladda.css', 'ninjaparade/products::css/ladda/ladda.min.css', 'styles') }}


{{ Asset::queue('ladda.spin.js', 'ninjaparade/products::js/ladda/spin.min.js', 'jquery') }}
{{ Asset::queue('ladda.js', 'ninjaparade/products::js/ladda/ladda.min.js', ['ladda.spin.js', 'jquery']) }}

{{ Asset::queue('jquery.form.js', 'ninjaparade/products::js/form/jquery.form.js', 'jquery') }}

{{ Asset::queue('bootstrap.button', 'bootstrap/js/button.js', 'jquery') }}
@section('scripts')
<script>
	$('.ajax-cart').on('click', function(event) {
		event.preventDefault();
		// var button = $(this);
		// button.button('loading');
		$(this).closest('form').ajaxSubmit({

			success: function (response){
				console.log(response);
				// button.button('reset');
			}
		});
	});


	Ladda.bind( 'button[type=submit]', { timeout: 1000 } );

</script>
@stop


@section('content')


<div class="row">

	@foreach ($products as $product)
	<div class="col-3 col-sm-3 col-lg-3">

		<div class="thumbnail">

			<div class="caption">
				<h2>{{{ $product->name }}}</h2>
				<p>{{ $product->price }}</p>
				<p>
					@if ($item = $cart->find(array('id' => $product->id)))

					{{ Form::open(array('url' => URL::route('cart.update', [ $product->id ]), 'method' => 'post', 'class'=>'form-inline'))}}
						{{ Form::selectRange('quantity', 1, 20,$item[0]->get('quantity'), array('class' => 'product-qty') )}}

						<button type="submit" class="ladda-button ajax-cart" data-style="zoom-out" data-size="s"><span class="ladda-label">Update</span></button>
                        {{-- Form::submit('Update', array('class'=> 'btn btn-danger ajax-cart', 'data-action' => 'update' , 'data-loading-text' =>"Loading...")) --}}                            
                    {{Form::close()}} 

                    {{ Form::open(array('url' => URL::route('cart.remove', [ $item[0]->get('rowId') ]), 'method' => 'post', 'class'=>'form-inline', 'data-loading-text' =>"Loading..."))}}
                        {{ Form::submit('Remove', array('class'=> 'btn btn-danger ajax-cart', 'data-action' => 'delete'))}}                            
                    {{Form::close()}}

					@else
					

					{{ Form::open(array('url' => URL::route('cart.add', [$product->id]), 'method' => 'post', 'class'=>'form-inline'))}}
                        {{ Form::selectRange('quantity', 1, 20,null, array('class' => 'product-qty') )}}
                          
                        {{ Form::submit('ADD TO CART', array('class'=> 'btn btn-danger ajax-cart', 'data-action' => 'add'))}}                            
                    {{Form::close()}} 

					@endif
				</p>

			</div>

		</div>

	</div>
	@endforeach

</div>

@stop