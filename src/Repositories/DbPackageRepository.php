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
use Input;
use Str;

class DbPackageRepository implements PackageRepositoryInterface {

	/**
	 * The Eloquent products model.
	 *
	 * @var string
	 */
	protected $model;

	/**
	 * @var Platform\Media\Repositories\MediaRepositoryInterface
	 */
	protected $media;

	/**
	 * @var Ninjaparade\Products\Repositories\PackageRepositoryInterface
	 */
	protected $product;

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
		'name' => 'required',
        'price' => 'required|numeric',
        'description' => 'required',
        'products' => 'required',
        'brand' => 'required',
	];

	/**
	 * Constructor.
	 *
	 * @param  string  $model
	 * @param  \Illuminate\Events\Dispatcher  $dispatcher
	 * @return void
	 */
	public function __construct($model, Dispatcher $dispatcher, $media, $product)
	{
		$this->model = $model;

		$this->dispatcher = $dispatcher;

		$this->media = $media;

		$this->product = $product;
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

    public function getAll()
    {
        return $this
            ->createModel()
            ->all();
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

		//Package Image
		$file = Input::file('image');
		
		$image = $this->media->upload($file, [ $data['name'] ]);

		$data['image'] = $image['id'];

		$products = [];

		foreach ($data['products'] as $product) {

			$p = $this->product->find($product);
			
			$slug = Str::slug($p->name);

			array_push($products, ['id'=> $p->id, 'qty' => Input::get($slug)]);

			unset($data[$slug]);

		}

		unset($data['products']);

		with($package = $this->createModel())->fill($data)->save();

		foreach ($products as $product) {
			
			$package->items()->attach($product['id'], ['qty'=> $product['qty']]);
		}
		
		$this->dispatcher->fire('ninjaparade.products.package.created', $package);


		return $package;
	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $data)
	{
		$package = $this->find($id);

		if( $file = Input::file('image') )
		{
			//delete the previous image.
			$this->media->delete($package->image);

			$image = $this->media->upload($file, [ $data['name'] ]);

			$data['image'] = $image['id'];

		}else{

			$data['image'] = $package->image;
		}

		$products = [];

		foreach ($data['products'] as $product) {

			$p = $this->product->find($product);
			
			$slug = Str::slug($p->name);

			array_push($products, ['id'=> $p->id, 'qty' => Input::get($slug)]);

			unset($data[$slug]);

			unset($data[$p->name]);
		}


		unset($data['products']);

		$package->fill($data)->save();

		$package->items()->detach();

		foreach ($products as $product) {
			
			$package->items()->attach($product['id'], ['qty'=> $product['qty']]);
		}

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
