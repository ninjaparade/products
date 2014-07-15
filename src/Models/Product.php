<?php namespace Ninjaparade\Products\Models;

/**
 * @package    Produtcts
 * @version    1.0.0
 * @author     Ninjaparade Inc
 * @license    DO WHAT YOU WANT
 */

use Platform\Attributes\Models\Entity;
use Illuminate\Support\Str;

class Product extends Entity {

	/**
	 * {@inheritDoc}
	 */
	protected $table = 'products';

	/**
	 * {@inheritDoc}
	 */
	protected $guarded = [
		'id',
	];

	protected $appends = ['slug'];

	/**
	 * {@inheritDoc}
	 */
	protected $with = [
		'values.attribute',
	];

	/**
	 * {@inheritDoc}
	 */
	protected $eavNamespace = 'ninjaparade/products.product';

	
	public function items()
    {
      return $this->belongsTo('Ninjaparade\Products\Models\Package');
    }

	public function getSlugAttribute($value)
	{	

		if( isset( $this->attributes['name']))
		{
			return Str::slug($this->attributes['name']);	
		}

		return "";
     	
    }

   


}
