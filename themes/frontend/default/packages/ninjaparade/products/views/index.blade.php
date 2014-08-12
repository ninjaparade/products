@extends('layouts/default')

@section('title')

@stop

@section('styles')

@stop



@section('scripts')

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
                        {{ Form::submit('Update', array('class'=> 'btn btn-danger'))}}                            
                    {{Form::close()}} 

                    {{ Form::open(array('url' => URL::route('cart.remove', [ $item[0]->get('rowId') ]), 'method' => 'post', 'class'=>'form-inline'))}}
                        {{ Form::submit('Remove', array('class'=> 'btn btn-danger'))}}                            
                    {{Form::close()}}

					@else
					

					{{ Form::open(array('url' => URL::route('cart.add', [$product->id]), 'method' => 'post', 'class'=>'form-inline'))}}
                        {{ Form::selectRange('quantity', 1, 20,null, array('class' => 'product-qty') )}}
                          
                        {{ Form::submit('ADD TO CART', array('class'=> 'btn btn-danger'))}}                            
                    {{Form::close()}} 

					@endif
				</p>

			</div>

		</div>

	</div>
	@endforeach

</div>

@stop