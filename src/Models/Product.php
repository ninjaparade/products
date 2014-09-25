<?php namespace Ninjaparade\Products\Models;

/**
 * @package    Products
 * @version    1.0.0
 * @author     Ninjaparade Inc
 * @license    DO WHAT YOU WANT
 */

use Cartalyst\Attributes\EntityInterface;
use Illuminate\Database\Eloquent\Model;
use Platform\Attributes\Traits\EntityTrait;
use Illuminate\Support\Str;

class Product extends Model implements EntityInterface {

    use EntityTrait;
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
        if ( isset($this->attributes['name']) )
        {

            return Str::slug($this->attributes['name']);
        }

        return "";
    }


}
