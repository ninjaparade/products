<?php namespace Ninjaparade\Products\Controllers\Frontend;

use Platform\Foundation\Controllers\BaseController;
use View;
use Store;

class StoresController extends BaseController {

	public function __construct() {
		
		parent::__construct();
		
	}

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

		$products = Store::findAll();

		return View::make('ninjaparade/products::index')
			->with(compact('products'));
	}

}
