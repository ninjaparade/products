<?php namespace Ninjaparade\Products\Controllers\Frontend;

/**
 * @package    Produtcts
 * @version    1.0.0
 * @author     Ninjaparade Inc
 * @license    DO WHAT YOU WANT
 */

use Platform\Foundation\Controllers\Controller;
use View;

class ProductsController extends Controller {


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
		return View::make('ninjaparade/products::index');
	}

}
