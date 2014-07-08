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

 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Database\Migrations\Migration;

class AddProductPacksPivotes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('package_product', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('package_id')->unsigned()->index();
			$table->integer('product_id')->unsigned()->index();
			$table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->integer('qty')->unsigned()->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('package_product');
	}

}
