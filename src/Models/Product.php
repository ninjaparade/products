<?php namespace Ninjaparade\Products\Models;

/**
 * @package    Products
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
        'product_image'
	];

	/**
	 * {@inheritDoc}
	 */
	protected $eavNamespace = 'ninjaparade/products.product';

	
	public function items()
    {
      return $this->belongsTo('Ninjaparade\Products\Models\Package');
    }


    public function product_image()
    {
        return $this->belongsTo('Platform\Media\Models\Media', 'image', 'id');
    }


    public function getSlugAttribute($value)
	{	
		if( isset( $this->attributes['name']))
		{
			
			return Str::slug( $this->attributes['name'] );
		}
		 
		return "";
	}

   


}
