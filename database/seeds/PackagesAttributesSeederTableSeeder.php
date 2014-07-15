<?php namespace Ninjaparade\Products\Database\Seeds;

use DB;
// use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

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

		// $faker = Faker::create();

		// DB::table('packages attributes seeder')->truncate();

		// foreach(range(1, 1) as $index)
		// {
		// 	// DB::table('packages attributes seeder')->insert([
		// 	// 	
		// 	// ]);
		// }
	}

}
