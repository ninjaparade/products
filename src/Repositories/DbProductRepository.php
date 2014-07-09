<?php namespace Ninjaparade\Products\Repositories;

/**
 * @package    Produtcts
 * @version    1.0.0
 * @author     Ninjaparade Inc
 * @license    DO WHAT YOU WANT
 */

use Cartalyst\Interpret\Interpreter;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Ninjaparade\Products\Models\Product;
use Symfony\Component\Finder\Finder;
use Validator;

class DbProductRepository implements ProductRepositoryInterface {

	/**
	 * The Eloquent products model.
	 *
	 * @var string
	 */
	protected $model;

	/**
	 * The event dispatcher instance.
	 *
	 * @var \Illuminate\Events\Dispatcher
	 */
	protected $dispatcher;

	/**
	 * Holds the form validation rules.
	 *
	 * @var array
	 */
	protected $rules = [

	];

	/**
	 * Constructor.
	 *
	 * @param  string  $model
	 * @param  \Illuminate\Events\Dispatcher  $dispatcher
	 * @return void
	 */
	public function __construct($model, Dispatcher $dispatcher)
	{
		$this->model = $model;

		$this->dispatcher = $dispatcher;
	}

	/**
	 * {@inheritDoc}
	 */
	public function grid()
	{
		return $this
			->createModel();
	}

	/**
	 * {@inheritDoc}
	 */
	public function findAll()
	{
		return $this
			->createModel()
			->newQuery()
			->get();
	}

	/**
	 * {@inheritDoc}
	 */
	public function find($id)
	{
		return $this
			->createModel()
			->where('id', (int) $id)
			->first();
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForCreation(array $data)
	{
		return $this->validateProduct($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForUpdate($id, array $data)
	{
		return $this->validateProduct($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function create(array $data)
	{
		with($product = $this->createModel())->fill($data)->save();

		$this->dispatcher->fire('ninjaparade.products.product.created', $product);

		return $product;
	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $data)
	{
		$product = $this->find($id);

		$product->fill($data)->save();

		$this->dispatcher->fire('ninjaparade.products.product.updated', $product);

		return $product;
	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		if ($product = $this->find($id))
		{
			$this->dispatcher->fire('ninjaparade.products.product.deleted', $product);

			$product->delete();

			return true;
		}

		return false;
	}

	/**
	 * Create a new instance of the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function createModel()
	{
		$class = '\\'.ltrim($this->model, '\\');

		return new $class;
	}

	/**
	 * Validates a products entry.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	protected function validateProduct($data)
	{
		$validator = Validator::make($data, $this->rules);

		$validator->passes();

		return $validator->errors();
	}

}
