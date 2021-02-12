<?php
namespace Jan\Component\Database\Capsule\Traits;


/**
 * Trait SoftDeletes
 *
 * @package Jan\Component\Database\Capsule\Traits
*/
trait SoftDeletes
{

    /**
     * @var bool
    */
    protected $softDelete = true;


    /**
     * @return bool
    */
    protected function isSoftDeleted(): bool
    {
        return $this->softDelete === true;
    }


    /*
    protected function toReview()
    {
        return $this->softDelete === true;
        || property_exists($this, 'deletedAt');
        \in_array('deleted_at', $mappedProperties)
    }
    */
}