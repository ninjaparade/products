@extends('layouts/default')

{{-- Page title --}}
@section('title')
	@parent
	: {{{ trans("ninjaparade/products::packages/general.{$mode}") }}} {{{ $package->exists ? '- ' . $package->name : null }}}
@stop

{{-- Queue assets --}}
{{ Asset::queue('bootstrap.tabs', 'bootstrap/js/tab.js', 'jquery') }}
{{ Asset::queue('products', 'ninjaparade/products::js/script.js', 'jquery') }}

{{-- Inline scripts --}}
@section('scripts')
@parent
@stop

{{-- Inline styles --}}
@section('styles')
@parent
@stop

{{-- Page content --}}
@section('content')

{{-- Page header --}}
<div class="page-header">

	<h1>{{{ trans("ninjaparade/products::packages/general.{$mode}") }}} <small>{{{ $package->name }}}</small></h1>

</div>




{{-- Content form --}}
<form id="products-form" action="{{ Request::fullUrl() }}" method="post" accept-char="UTF-8" autocomplete="off" enctype="multipart/form-data">

	{{-- CSRF Token --}}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	{{-- Tabs --}}
	<ul class="nav nav-tabs">
		<li class="active"><a href="#general" data-toggle="tab">{{{ trans('ninjaparade/products::general.tabs.general') }}}</a></li>
		<li><a href="#attributes" data-toggle="tab">{{{ trans('ninjaparade/products::general.tabs.attributes') }}}</a></li>
	</ul>

	{{-- Tabs content --}}
	<div class="tab-content tab-bordered">

		{{-- General tab --}}
		<div class="tab-pane active" id="general">

			<div class="row">

				<div class="form-group{{ $errors->first('name', ' has-error') }}">

					<label for="name" class="control-label">{{{ trans('ninjaparade/products::packages/form.name') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::packages/form.name_help') }}}"></i></label>

					<input type="text" class="form-control" name="name" id="name" placeholder="{{{ trans('ninjaparade/products::packages/form.name') }}}" value="{{{ Input::old('name', $package->name) }}}">

					<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>

				</div>

				<div class="form-group{{ $errors->first('price', ' has-error') }}">

					<label for="price" class="control-label">{{{ trans('ninjaparade/products::packages/form.price') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::packages/form.price_help') }}}"></i></label>

					<input type="text" class="form-control" name="price" id="price" placeholder="{{{ trans('ninjaparade/products::packages/form.price') }}}" value="{{{ Input::old('price', $package->price) }}}">

					<span class="help-block">{{{ $errors->first('price', ':message') }}}</span>

				</div>

				@foreach($products as $product)
				<div class="form-group{{ $errors->first('products', ' has-error') }}">

					<label for="products" class="control-label">{{$product->name}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::packages/form.products_help') }}}"></i></label>					
				    	
					{{-- start products foreach --}}
					
					
				
					<?php 
						
						$amount=0;
	   					$slug = \Illuminate\Support\Str::slug($product->name); 	
	    				$id = $product->id;

				    	if($package->exists)
				    	{
			                if($package->items->find($id))
			                    $amount = $package->items->find($id)->pivot->qty;
				    	}
            
           				if(Input::old($slug))
			            {
			                $amount = Input::old($slug);
			            }
        	

            			if($package->items->find($id) && $amount > 0){
            				$checked = true;		
            			}else{
            				$checked = false;			
            			}
                
            			if(Input::old($slug))
                			$checked = true;
           
            			?>
					
        			{{Form::checkbox('products[]', $product->id, $checked)}}
        			 <select name="{{\Illuminate\Support\Str::slug($product->name)}}"   class="form-control" id="">
		            	<option value="0">---</option>
		            	<option @if($amount == 1) {{'selected'}} @endif value="1">1</option>
		                <option @if($amount == 2) {{'selected'}} @endif value="2">2</option>
		                <option @if($amount == 3) {{'selected'}} @endif value="3">3</option>
		                <option @if($amount == 4) {{'selected'}} @endif value="4">4</option>
		                <option @if($amount == 5) {{'selected'}} @endif value="5">5</option>
		                <option @if($amount == 6) {{'selected'}} @endif value="6">6</option>
		                <option @if($amount == 7) {{'selected'}} @endif value="7">7</option>
		                <option @if($amount == 8) {{'selected'}} @endif value="8">8</option>
		                <option @if($amount == 9) {{'selected'}} @endif value="9">9</option>
		                <option @if($amount == 10) {{'selected'}} @endif value="10">10</option>
		                <option @if($amount == 11) {{'selected'}} @endif value="11">11</option>
		                <option @if($amount == 12) {{'selected'}} @endif value="12">12</option>
		                <option @if($amount == 13) {{'selected'}} @endif value="13">13</option>
		                <option @if($amount == 14) {{'selected'}} @endif value="14">14</option>
		                <option @if($amount == 15) {{'selected'}} @endif value="15">15</option>
		       		 </select>

					{{-- end products foreach --}}
					
					
					{{-- <input type="text" class="form-control" name="products" id="products" placeholder="{{{ trans('ninjaparade/products::packages/form.products') }}}" value="{{{ Input::old('products', $package->products) }}}"> --}}

					<span class="help-block">{{{ $errors->first('products', ':message') }}}</span>

				</div>
				@endforeach


				@if($package->exists)
				<div class="form-group{{ $errors->first('description', ' has-error') }}">

					<label for="uploaded image" class="control-label">Uploaded Image <i class="fa fa-info-circle" data-toggle="popover" data-content="Uploaded Image"></i></label>
					   <img src="@media($package->image)" alt="" width="10%">
				</div>
				@endif

				<div class="form-group{{ $errors->first('image', ' has-error') }}">
					  
					<label for="image" class="control-label">{{{ trans('ninjaparade/products::packages/form.image') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::packages/form.image_help') }}}"></i></label>

					<input type="file" class="form-control" name="image" id="image" placeholder="{{{ trans('ninjaparade/products::packages/form.image') }}}" value="{{{ Input::old('image', $package->image) }}}">

					<span class="help-block">{{{ $errors->first('image', ':message') }}}</span>

				</div>

				<div class="form-group{{ $errors->first('description', ' has-error') }}">

					<label for="description" class="control-label">{{{ trans('ninjaparade/products::packages/form.description') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::packages/form.description_help') }}}"></i></label>

					<textarea class="form-control" name="description" id="description" placeholder="{{{ trans('ninjaparade/products::packages/form.description') }}}">{{{ Input::old('description', $package->description) }}}</textarea>

					<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>

				</div>

				<div class="form-group{{ $errors->first('brand', ' has-error') }}">

					<label for="brand" class="control-label">{{{ trans('ninjaparade/products::packages/form.brand') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::packages/form.brand_help') }}}"></i></label>

					<input type="text" class="form-control" name="brand" id="brand" placeholder="{{{ trans('ninjaparade/products::packages/form.brand') }}}" value="{{{ Input::old('brand', $package->brand) }}}">

					<span class="help-block">{{{ $errors->first('brand', ':message') }}}</span>

				</div>


			</div>

		</div>

		{{-- Attributes tab --}}
		<div class="tab-pane clearfix" id="attributes">

			@widget('platform/attributes::entity.form', [$package])

		</div>

	</div>

	{{-- Form actions --}}
	<div class="row">

		<div class="col-lg-12 text-right">

			{{-- Form actions --}}
			<div class="form-group">

				<button class="btn btn-success" type="submit">{{{ trans('button.save') }}}</button>

				<a class="btn btn-default" href="{{{ URL::toAdmin('products/packages') }}}">{{{ trans('button.cancel') }}}</a>

				<a class="btn btn-danger" data-toggle="modal" data-target="modal-confirm" href="{{ URL::toAdmin("products/packages/{$package->id}/delete") }}">{{{ trans('button.delete') }}}</a>

			</div>

		</div>

	</div>

</form>

@stop
