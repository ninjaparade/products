<?php namespace Ninjaparade\Products\Models;

use Cartalyst\Attributes\EntityInterface;
use Illuminate\Database\Eloquent\Model;
use Platform\Attributes\Traits\EntityTrait;

/**
 * @package    Produtcts
 * @version    1.0.0
 * @author     Ninjaparade Inc
 * @license    DO WHAT YOU WANT
 */
class Package extends Model implements EntityInterface {

    use EntityTrait;
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
