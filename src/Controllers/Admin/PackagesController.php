<?php namespace Ninjaparade\Products\Controllers\Admin;

/**
 * @package    Produtcts
 * @version    1.0.0
 * @author     Ninjaparade Inc
 * @license    DO WHAT YOU WANT
 */

use DataGrid;
use Input;
use Lang;
use Platform\Admin\Controllers\Admin\AdminController;
use Redirect;
use Response;
use View;
use Ninjaparade\Products\Repositories\PackageRepositoryInterface;
use Ninjaparade\Products\Repositories\ProductRepositoryInterface;

class PackagesController extends AdminController {

	/**
	 * {@inheritDoc}
	 */
	protected $csrfWhitelist = [
		'executeAction',
	];

	/**
	 * The Products repository.
	 *
	 * @var \Ninjaparade\Products\Repositories\PackageRepositoryInterface
	 */
	protected $package;
	
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
	 * @param  \Ninjaparade\Products\Repositories\PackageRepositoryInterface  $package
	 * @return void
	 */
	public function __construct(PackageRepositoryInterface $package, ProductRepositoryInterface $product)
	{
		parent::__construct();

		$this->package = $package;

		$this->product = $product;
	}

	/**
	 * Display a listing of package.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return View::make('ninjaparade/products::packages.index');
	}

	/**
	 * Datasource for the package Data Grid.
	 *
	 * @return \Cartalyst\DataGrid\DataGrid
	 */
	public function grid()
	{
		$data = $this->package->grid();

		$columns = [
			'id',
			'name',
			'price',
			'products',
			'image',
			'description',
			'brand',
			'created_at',
		];

		$settings = [
			'sort'      => 'created_at',
			'direction' => 'desc',
		];

		return DataGrid::make($data, $columns, $settings);
	}

	/**
	 * Show the form for creating new package.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new package.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating package.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating package.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified package.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		if ($this->package->delete($id))
		{
			$message = Lang::get('ninjaparade/products::packages/message.success.delete');

			return Redirect::toAdmin('products/packages')->withSuccess($message);
		}

		$message = Lang::get('ninjaparade/products::packages/message.error.delete');

		return Redirect::toAdmin('products/packages')->withErrors($message);
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
				$this->package->{$action}($entry);
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
		// Do we have a package identifier?
		if (isset($id))
		{
			if ( ! $package = $this->package->find($id))
			{
				$message = Lang::get('ninjaparade/products::packages/message.not_found', compact('id'));

				return Redirect::toAdmin('products/packages')->withErrors($message);
			}

		}
		else
		{
			$package = $this->package->createModel();

		}

		// Get products or return model
		if( ! $products = $this->product->findAll())
		{

			$products = $this->product->createModel();

		}

		// Show the page
		return View::make('ninjaparade/products::packages.form', compact('mode', 'package', 'products'));
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

		// Do we have a package identifier?
		if ($id)
		{
			// Check if the data is valid
			$messages = $this->package->validForUpdate($id, $data);

			// Do we have any errors?
			if ($messages->isEmpty())
			{
				// Update the package
				$package = $this->package->update($id, $data);
			}
		}
		else
		{
			// Check if the data is valid
			$messages = $this->package->validForCreation($data);

			// Do we have any errors?
			if ($messages->isEmpty())
			{
				// Create the package
				$package = $this->package->create($data);
			}
		}

		// Do we have any errors?
		if ($messages->isEmpty())
		{
			// Prepare the success message
			$message = Lang::get("ninjaparade/products::packages/message.success.{$mode}");

			return Redirect::toAdmin("products/packages/{$package->id}/edit")->withSuccess($message);
		}

		return Redirect::back()->withInput()->withErrors($messages);
	}

}
