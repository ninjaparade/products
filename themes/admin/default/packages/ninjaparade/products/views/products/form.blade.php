@extends('layouts/default')

{{-- Page title --}}
@section('title')
	@parent
	: {{{ trans("ninjaparade/products::products/general.{$mode}") }}} {{{ $product->exists ? '- ' . $product->name : null }}}
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

	<h1>{{{ trans("ninjaparade/products::products/general.{$mode}") }}} <small>{{{ $product->name }}}</small></h1>

</div>

{{-- Content form --}}
<form id="products-form" action="{{ Request::fullUrl() }}" method="post" accept-char="UTF-8" autocomplete="off">

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

					<label for="name" class="control-label">{{{ trans('ninjaparade/products::products/form.name') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::products/form.name_help') }}}"></i></label>

					<input type="text" class="form-control" name="name" id="name" placeholder="{{{ trans('ninjaparade/products::products/form.name') }}}" value="{{{ Input::old('name', $product->name) }}}">

					<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>

				</div>

				<div class="form-group{{ $errors->first('sku', ' has-error') }}">

					<label for="sku" class="control-label">{{{ trans('ninjaparade/products::products/form.sku') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::products/form.sku_help') }}}"></i></label>

					<input type="text" class="form-control" name="sku" id="sku" placeholder="{{{ trans('ninjaparade/products::products/form.sku') }}}" value="{{{ Input::old('sku', $product->sku) }}}">

					<span class="help-block">{{{ $errors->first('sku', ':message') }}}</span>

				</div>

				<div class="form-group{{ $errors->first('price', ' has-error') }}">

					<label for="price" class="control-label">{{{ trans('ninjaparade/products::products/form.price') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::products/form.price_help') }}}"></i></label>

					<input type="text" class="form-control" name="price" id="price" placeholder="{{{ trans('ninjaparade/products::products/form.price') }}}" value="{{{ Input::old('price', $product->price) }}}">

					<span class="help-block">{{{ $errors->first('price', ':message') }}}</span>

				</div>

				<div class="form-group{{ $errors->first('image', ' has-error') }}">

					<label for="image" class="control-label">{{{ trans('ninjaparade/products::products/form.image') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::products/form.image_help') }}}"></i></label>

					<input type="text" class="form-control" name="image" id="image" placeholder="{{{ trans('ninjaparade/products::products/form.image') }}}" value="{{{ Input::old('image', $product->image) }}}">

					<span class="help-block">{{{ $errors->first('image', ':message') }}}</span>

				</div>

				<div class="form-group{{ $errors->first('brand', ' has-error') }}">

					<label for="brand" class="control-label">{{{ trans('ninjaparade/products::products/form.brand') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::products/form.brand_help') }}}"></i></label>

					<input type="text" class="form-control" name="brand" id="brand" placeholder="{{{ trans('ninjaparade/products::products/form.brand') }}}" value="{{{ Input::old('brand', $product->brand) }}}">

					<span class="help-block">{{{ $errors->first('brand', ':message') }}}</span>

				</div>

				<div class="form-group{{ $errors->first('stock', ' has-error') }}">

					<label for="stock" class="control-label">{{{ trans('ninjaparade/products::products/form.stock') }}} <i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('ninjaparade/products::products/form.stock_help') }}}"></i></label>

					<input type="text" class="form-control" name="stock" id="stock" placeholder="{{{ trans('ninjaparade/products::products/form.stock') }}}" value="{{{ Input::old('stock', $product->stock) }}}">

					<span class="help-block">{{{ $errors->first('stock', ':message') }}}</span>

				</div>


			</div>

		</div>

		{{-- Attributes tab --}}
		<div class="tab-pane clearfix" id="attributes">

			@widget('platform/attributes::entity.form', [$product])

		</div>

	</div>

	{{-- Form actions --}}
	<div class="row">

		<div class="col-lg-12 text-right">

			{{-- Form actions --}}
			<div class="form-group">

				<button class="btn btn-success" type="submit">{{{ trans('button.save') }}}</button>

				<a class="btn btn-default" href="{{{ URL::toAdmin('products/products') }}}">{{{ trans('button.cancel') }}}</a>

				<a class="btn btn-danger" data-toggle="modal" data-target="modal-confirm" href="{{ URL::toAdmin("products/products/{$product->id}/delete") }}">{{{ trans('button.delete') }}}</a>

			</div>

		</div>

	</div>

</form>

@stop
