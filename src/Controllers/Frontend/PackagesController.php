<?php namespace Ninjaparade\Products\Controllers\Frontend;

/**
 * @package    Produtcts
 * @version    1.0.0
 * @author     Ninjaparade Inc
 * @license    DO WHAT YOU WANT
 */

use Platform\Foundation\Controllers\Controller;
use View;

class PackagesController extends Controller {

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
