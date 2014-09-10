<?php namespace Ninjaparade\Products\Controllers\Frontend;

use Platform\Foundation\Controllers\BaseController;
use View;
use Store;

class StoresController extends BaseController {

	protected $cart;

	public function __construct() {
		
		parent::__construct();

		$this->cart = app('cart');
		
	}

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{

		$products = Store::findAll();
		
		$cart = $this->cart;



		return View::make('ninjaparade/products::shop')
			->with(compact('products', 'cart'));
	}

}
