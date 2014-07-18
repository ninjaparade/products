<?php namespace Ninjaparade\Products\Laravel;

use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// $this->package('cartalyst/cart', 'cartalyst/cart', __DIR__.'/..');
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		$this->app['ninjaparade.products'] = $this->app->share( function($app){

			$model = get_class($app['Ninjaparade\Products\Models\Package']);

			$media = $app['Platform\Media\Repositories\MediaRepositoryInterface'];
			
			$product = $app['Ninjaparade\Products\Repositories\ProductRepositoryInterface'];

			return new \Ninjaparade\Products\Repositories\DbPackageRepository($model, $app['events'], $media, $product);
		});
	}

}
