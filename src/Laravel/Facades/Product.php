<?php namespace Ninjaparade\Products\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Product extends Facade {

	/**
	 * {@inheritDoc}
	 */
	protected static function getFacadeAccessor()
	{
		return 'ninjaparade.packages';
	}

}
