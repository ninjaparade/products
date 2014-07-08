<?php
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

use Cartalyst\Extensions\ExtensionInterface;
use Illuminate\Foundation\Application;

return [

	/*
	|--------------------------------------------------------------------------
	| Name
	|--------------------------------------------------------------------------
	|
	| This is your extension name and it is only required for
	| presentational purposes.
	|
	*/

	'name' => 'Products',

	/*
	|--------------------------------------------------------------------------
	| Slug
	|--------------------------------------------------------------------------
	|
	| This is your extension unique identifier and should not be changed as
	| it will be recognized as a new extension.
	|
	| Ideally, this should match the folder structure within the extensions
	| folder, but this is completely optional.
	|
	*/

	'slug' => 'ninjaparade/products',

	/*
	|--------------------------------------------------------------------------
	| Author
	|--------------------------------------------------------------------------
	|
	| Because everybody deserves credit for their work, right?
	|
	*/

	'author' => 'Ninja',

	/*
	|--------------------------------------------------------------------------
	| Description
	|--------------------------------------------------------------------------
	|
	| One or two sentences describing the extension for users to view when
	| they are installing the extension.
	|
	*/

	'description' => 'Product management for platform',

	/*
	|--------------------------------------------------------------------------
	| Version
	|--------------------------------------------------------------------------
	|
	| Version should be a string that can be used with version_compare().
	| This is how the extensions versions are compared.
	|
	*/

	'version' => '0.1.0',

	/*
	|--------------------------------------------------------------------------
	| Requirements
	|--------------------------------------------------------------------------
	|
	| List here all the extensions that this extension requires to work.
	| This is used in conjunction with composer, so you should put the
	| same extension dependencies on your main composer.json require
	| key, so that they get resolved using composer, however you
	| can use without composer, at which point you'll have to
	| ensure that the required extensions are available.
	|
	*/

	'require' => [
		'platform/admin',
	],

	/*
	|--------------------------------------------------------------------------
	| Autoload Logic
	|--------------------------------------------------------------------------
	|
	| You can define here your extension autoloading logic, it may either
	| be 'composer', 'platform' or a 'Closure'.
	|
	| If composer is defined, your composer.json file specifies the autoloading
	| logic.
	|
	| If platform is defined, your extension receives convetion autoloading
	| based on the Platform standards.
	|
	| If a Closure is defined, it should take two parameters as defined
	| bellow:
	|
	|	object \Composer\Autoload\ClassLoader      $loader
	|	object \Illuminate\Foundation\Application  $app
	|
	| Supported: "composer", "platform", "Closure"
	|
	*/

	'autoload' => 'composer',

	/*
	|--------------------------------------------------------------------------
	| Register Callback
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is registered. This can do
	| all the needed custom logic upon registering.
	|
	| The closure parameters are:
	|
	|	object \Cartalyst\Extensions\ExtensionInterface  $extension
	|	object \Illuminate\Foundation\Application        $app
	|
	*/

	'register' => function(ExtensionInterface $extension, Application $app)
	{
		$ProductRepository = 'Ninjaparade\Products\Repositories\ProductRepositoryInterface';

		if ( ! $app->bound($ProductRepository))
		{
			$app->bind($ProductRepository, function($app)
			{
				$model = get_class($app['Ninjaparade\Products\Models\Product']);

				return new Ninjaparade\Products\Repositories\DbProductRepository($model, $app['events']);
			});
		}

		$PackageRepository = 'Ninjaparade\Products\Repositories\PackageRepositoryInterface';

		if ( ! $app->bound($PackageRepository))
		{
			$app->bind($PackageRepository, function($app)
			{
				$model = get_class($app['Ninjaparade\Products\Models\Package']);

				return new Ninjaparade\Products\Repositories\DbPackageRepository($model, $app['events']);
			});
		}
	},

	/*
	|--------------------------------------------------------------------------
	| Boot Callback
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is booted. This can do
	| all the needed custom logic upon booting.
	|
	| The closure parameters are:
	|
	|	object \Cartalyst\Extensions\ExtensionInterface  $extension
	|	object \Illuminate\Foundation\Application        $app
	|
	*/

	'boot' => function(ExtensionInterface $extension, Application $app)
	{
		if (class_exists('Ninjaparade\Products\Models\Product'))
		{
			// Get the model
			$model = $app['Ninjaparade\Products\Models\Product'];

			// Register a new attribute namespace
			$app['Platform\Attributes\Models\Attribute']->registerNamespace($model);
		}

		if (class_exists('Ninjaparade\Products\Models\Package'))
		{
			// Get the model
			$model = $app['Ninjaparade\Products\Models\Package'];

			// Register a new attribute namespace
			$app['Platform\Attributes\Models\Attribute']->registerNamespace($model);
		}
	},

	/*
	|--------------------------------------------------------------------------
	| Routes
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is started. You can register
	| any custom routing logic here.
	|
	| The closure parameters are:
	|
	|	object \Cartalyst\Extensions\ExtensionInterface  $extension
	|	object \Illuminate\Foundation\Application        $app
	|
	*/

	'routes' => function(ExtensionInterface $extension, Application $app)
	{
		Route::group(['namespace' => 'Ninjaparade\Products\Controllers'], function()
		{
			Route::group(['prefix' => admin_uri().'/products/products', 'namespace' => 'Admin'], function()
			{
				Route::get('/', 'ProductsController@index');
				Route::post('/', 'ProductsController@executeAction');
				Route::get('grid', 'ProductsController@grid');
				Route::get('create', 'ProductsController@create');
				Route::post('create', 'ProductsController@store');
				Route::get('{id}/edit', 'ProductsController@edit');
				Route::post('{id}/edit', 'ProductsController@update');
				Route::get('{id}/delete', 'ProductsController@delete');
			});

			Route::group(['prefix' => 'products/products', 'namespace' => 'Frontend'], function()
			{
				Route::get('/', 'ProductsController@index');
			});
		});

		Route::group(['namespace' => 'Ninjaparade\Products\Controllers'], function()
		{
			Route::group(['prefix' => admin_uri().'/products/packages', 'namespace' => 'Admin'], function()
			{
				Route::get('/', 'PackagesController@index');
				Route::post('/', 'PackagesController@executeAction');
				Route::get('grid', 'PackagesController@grid');
				Route::get('create', 'PackagesController@create');
				Route::post('create', 'PackagesController@store');
				Route::get('{id}/edit', 'PackagesController@edit');
				Route::post('{id}/edit', 'PackagesController@update');
				Route::get('{id}/delete', 'PackagesController@delete');
			});

			Route::group(['prefix' => 'products/packages', 'namespace' => 'Frontend'], function()
			{
				Route::get('/', 'PackagesController@index');
			});
		});
	},

	/*
	|--------------------------------------------------------------------------
	| Database Seeds
	|--------------------------------------------------------------------------
	|
	| Platform provides a very simple way to seed your database with test
	| data using seed classes. All seed classes should be stored on the
	| `database/seeds` directory within your extension folder.
	|
	| The order you register your seed classes on the array below
	| matters, as they will be ran in the exact same order.
	|
	| The seeds array should follow the following structure:
	|
	|	Vendor\Namespace\Database\Seeds\FooSeeder
	|	Vendor\Namespace\Database\Seeds\BarSeeder
	|
	*/

	'seeds' => [

	],

	/*
	|--------------------------------------------------------------------------
	| Permissions
	|--------------------------------------------------------------------------
	|
	| List of permissions this extension has. These are shown in the user
	| management area to build a graphical interface where permissions
	| may be selected.
	|
	| The admin controllers state that permissions should follow the following
	| structure:
	|
	|    Vendor\Namespace\Controller@method
	|
	| For example:
	|
	|    Platform\Users\Controllers\Admin\UsersController@index
	|
	| These are automatically generated for controller routes however you are
	| free to add your own permissions and check against them at any time.
	|
	| When writing permissions, if you put a 'key' => 'value' pair, the 'value'
	| will be the label for the permission which is displayed when editing
	| permissions.
	|
	*/

	'permissions' => function()
	{
		return [
			'Ninjaparade\Products\Controllers\Admin\ProductsController@index,grid'   => Lang::get('ninjaparade/products::products.permissions.index'),
			'Ninjaparade\Products\Controllers\Admin\ProductsController@create,store' => Lang::get('ninjaparade/products::products.permissions.create'),
			'Ninjaparade\Products\Controllers\Admin\ProductsController@edit,update'  => Lang::get('ninjaparade/products::products.permissions.edit'),
			'Ninjaparade\Products\Controllers\Admin\ProductsController@delete'       => Lang::get('ninjaparade/products::products.permissions.delete'),

			'Ninjaparade\Products\Controllers\Admin\PackagesController@index,grid'   => Lang::get('ninjaparade/products::packages.permissions.index'),
			'Ninjaparade\Products\Controllers\Admin\PackagesController@create,store' => Lang::get('ninjaparade/products::packages.permissions.create'),
			'Ninjaparade\Products\Controllers\Admin\PackagesController@edit,update'  => Lang::get('ninjaparade/products::packages.permissions.edit'),
			'Ninjaparade\Products\Controllers\Admin\PackagesController@delete'       => Lang::get('ninjaparade/products::packages.permissions.delete'),
		];
	},

	/*
	|--------------------------------------------------------------------------
	| Widgets
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is started. You can register
	| all your custom widgets here. Of course, Platform will guess the
	| widget class for you, this is just for custom widgets or if you
	| do not wish to make a new class for a very small widget.
	|
	*/

	'widgets' => function()
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Settings
	|--------------------------------------------------------------------------
	|
	| Register any settings for your extension. You can also configure
	| the namespace and group that a setting belongs to.
	|
	*/

	'settings' => function()
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Menus
	|--------------------------------------------------------------------------
	|
	| You may specify the default various menu hierarchy for your extension.
	| You can provide a recursive array of menu children and their children.
	| These will be created upon installation, synchronized upon upgrading
	| and removed upon uninstallation.
	|
	| Menu children are automatically put at the end of the menu for extensions
	| installed through the Operations extension.
	|
	| The default order (for extensions installed initially) can be
	| found by editing app/config/platform.php.
	|
	*/

	'menus' => [

		'admin' => [
			[
				'slug' => 'admin-ninjaparade-products',
				'name' => 'Products',
				'class' => 'fa fa-circle-o',
				'uri' => 'products',
				'children' => [
					[
						'slug' => 'admin-ninjaparade-products-product',
						'name' => 'Products',
						'class' => 'fa fa-circle-o',
						'uri' => 'products/products',
					],
					[
						'slug' => 'admin-ninjaparade-products-package',
						'name' => 'Packages',
						'class' => 'fa fa-circle-o',
						'uri' => 'products/packages',
					],
				],
			],
		],
		'main' => [
			[
				'slug' => 'main-ninjaparade-products',
				'name' => 'Products',
				'class' => 'fa fa-circle-o',
				'uri' => 'products',
			],
		],
	],

];
