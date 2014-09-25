<?php namespace Ninjaparade\Products\Controllers\Frontend;


use Platform\Foundation\Controllers\Controller;
use Store;
use View;

class StoresController extends Controller {

    protected $cart;

    public function __construct()
    {

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

        $qty = [];
        foreach ( $products as $product )
        {
            $row = $this->cart->find(['id' => $product->id]);
            if ( $row )
            {
                $qty[$product->id] = $row[0]->get('quantity');
            } else
            {
                $qty[$product->id] = 0;
            }
        }

        return View::make('ninjaparade/products::shop')
            ->with(compact('products', 'cart', 'qty'));
    }

}
