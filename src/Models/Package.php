<?php namespace Ninjaparade\Products\Models;

/**
 * @package    Produtcts
 * @version    1.0.0
 * @author     Ninjaparade Inc
 * @license    DO WHAT YOU WANT
 */

use Platform\Attributes\Models\Entity;

class Package extends Entity {

    /**
     * {@inheritDoc}
     */
    protected $table = 'packages';

    /**
     * {@inheritDoc}
     */
    protected $guarded = [
        'id',
    ];

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
    protected $eavNamespace = 'ninjaparade/products.package';


    public function items()
    {
        return $this->belongsToMany('Ninjaparade\Products\Models\Product')->withPivot(['qty']);
    }

    public function product_image()
    {
        return $this->belongsTo('Platform\Media\Models\Media', 'image', 'id');
    }

}
