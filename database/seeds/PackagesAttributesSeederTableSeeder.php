<?php namespace Ninjaparade\Products\Database\Seeds;

use Illuminate\Database\Seeder;
use DB;

class PackagesAttributesSeederTableSeeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$attribute = app('Platform\Attributes\Repositories\AttributeRepositoryInterface');

		$attribute->create([
			'namespace' => 'ninjaparade/products.package',
			'name'      => 'On Sale',
			'type'      => 'radio',
			'slug'      => 'on_sale',
			'options'	=> ["No", "Yes"],
			'enabled'   => 1,
		]);

		$attribute->create([
			'namespace' => 'ninjaparade/products.package',
			'name'      => 'Sale Price',
			'type'      => 'input',
			'slug'      => 'sale_price',
			'enabled'   => 1,
		]);

	}

}
