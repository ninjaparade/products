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
use Ninjaparade\Products\Models\Package;
use Symfony\Component\Finder\Finder;
use Validator;

class DbPackageRepository implements PackageRepositoryInterface {

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
		return $this->validatePackage($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForUpdate($id, array $data)
	{
		return $this->validatePackage($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function create(array $data)
	{
		with($package = $this->createModel())->fill($data)->save();

		$this->dispatcher->fire('ninjaparade.products.package.created', $package);

		return $package;
	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $data)
	{
		$package = $this->find($id);

		$package->fill($data)->save();

		$this->dispatcher->fire('ninjaparade.products.package.updated', $package);

		return $package;
	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		if ($package = $this->find($id))
		{
			$this->dispatcher->fire('ninjaparade.products.package.deleted', $package);

			$package->delete();

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
	protected function validatePackage($data)
	{
		$validator = Validator::make($data, $this->rules);

		$validator->passes();

		return $validator->errors();
	}

}
