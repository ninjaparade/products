<?php namespace Ninjaparade\Products\Controllers\Admin;
/**
 * Part of the Workshop package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Workshop
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use DataGrid;
use Input;
use Lang;
use Platform\Admin\Controllers\Admin\AdminController;
use Redirect;
use Response;
use View;
use Ninjaparade\Products\Repositories\ProductRepositoryInterface;

class ProductsController extends AdminController {

	/**
	 * {@inheritDoc}
	 */
	protected $csrfWhitelist = [
		'executeAction',
	];

	/**
	 * The Products repository.
	 *
	 * @var \Ninjaparade\Products\Repositories\ProductRepositoryInterface
	 */
	protected $product;

	/**
	 * Holds all the mass actions we can execute.
	 *
	 * @var array
	 */
	protected $actions = [
		'delete',
		'enable',
		'disable',
	];

	/**
	 * Constructor.
	 *
	 * @param  \Ninjaparade\Products\Repositories\ProductRepositoryInterface  $product
	 * @return void
	 */
	public function __construct(ProductRepositoryInterface $product)
	{
		parent::__construct();

		$this->product = $product;
	}

	/**
	 * Display a listing of product.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return View::make('ninjaparade/products::products.index');
	}

	/**
	 * Datasource for the product Data Grid.
	 *
	 * @return \Cartalyst\DataGrid\DataGrid
	 */
	public function grid()
	{
		$data = $this->product->grid();

		$columns = [
			'id',
			'name',
			'sku',
			'price',
			'image',
			'brand',
			'stock',
			'created_at',
		];

		$settings = [
			'sort'      => 'created_at',
			'direction' => 'desc',
		];

		return DataGrid::make($data, $columns, $settings);
	}

	/**
	 * Show the form for creating new product.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new product.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating product.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating product.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified product.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($this->product->delete($id))
		{
			$message = Lang::get('ninjaparade/products::products/message.success.delete');

			return Redirect::toAdmin('products/products')->withSuccess($message);
		}

		$message = Lang::get('ninjaparade/products::products/message.error.delete');

		return Redirect::toAdmin('products/products')->withErrors($message);
	}

	/**
	 * Executes the mass action.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function executeAction()
	{
		$action = Input::get('action');

		if (in_array($action, $this->actions))
		{
			foreach (Input::get('entries', []) as $entry)
			{
				$this->product->{$action}($entry);
			}

			return Response::json('Success');
		}

		return Response::json('Failed', 500);
	}

	/**
	 * Shows the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return mixed
	 */
	protected function showForm($mode, $id = null)
	{
		// Do we have a product identifier?
		if (isset($id))
		{
			if ( ! $product = $this->product->find($id))
			{
				$message = Lang::get('ninjaparade/products::products/message.not_found', compact('id'));

				return Redirect::toAdmin('products/products')->withErrors($message);
			}
		}
		else
		{
			$product = $this->product->createModel();
		}

		// Show the page
		return View::make('ninjaparade/products::products.form', compact('mode', 'product'));
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null)
	{
		// Get the input data
		$data = Input::all();

		// Do we have a product identifier?
		if ($id)
		{
			// Check if the data is valid
			$messages = $this->product->validForUpdate($id, $data);

			// Do we have any errors?
			if ($messages->isEmpty())
			{
				// Update the product
				$product = $this->product->update($id, $data);
			}
		}
		else
		{
			// Check if the data is valid
			$messages = $this->product->validForCreation($data);

			// Do we have any errors?
			if ($messages->isEmpty())
			{
				// Create the product
				$product = $this->product->create($data);
			}
		}

		// Do we have any errors?
		if ($messages->isEmpty())
		{
			// Prepare the success message
			$message = Lang::get("ninjaparade/products::products/message.success.{$mode}");

			return Redirect::toAdmin("products/products/{$product->id}/edit")->withSuccess($message);
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

}
