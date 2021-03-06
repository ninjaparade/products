<?php namespace Ninjaparade\Products\Repositories;

/**
 * @package    Produtcts
 * @version    1.0.0
 * @author     Ninjaparade Inc
 * @license    DO WHAT YOU WANT
 */

interface ProductRepositoryInterface {

	/**
	 * Returns a dataset compatible with data grid.
	 *
	 * @return \Ninjaparade\Products\Models\Product
	 */
	public function grid();

	/**
	 * Returns all the products entries.
	 *
	 * @return \Ninjaparade\Products\Models\Product
	 */
	public function findAll();

	/**
	 * Returns a products entry by its primary key.
	 *
	 * @param  int  $id
	 * @return \Ninjaparade\Products\Models\Product
	 */
	public function find($id);

	/**
	 * Determines if the given products is valid for creation.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForCreation(array $data);

	/**
	 * Determines if the given products is valid for update.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForUpdate($id, array $data);

	/**
	 * Creates a products entry with the given data.
	 *
	 * @param  array  $data
	 * @return \Ninjaparade\Products\Models\Product
	 */
	public function create(array $data);

	/**
	 * Updates the products entry with the given data.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Ninjaparade\Products\Models\Product
	 */
	public function update($id, array $data);

	/**
	 * Deletes the products entry.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function delete($id);

}
