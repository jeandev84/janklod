<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;

/**
 * Class SetType
 * @package Jan\Component\Database\Builder\Type
*/
class SetType extends SqlType
{

    /**
     * SetType constructor.
     * @param array $attributes
    */
    public function __construct(array $attributes)
    {
         $this->setAttributes($attributes);
    }


    /**
     * @return string|null
     * @throws \Exception
    */
    public function build(): ?string
    {
         return $this->setSQL();
    }


    /**
     * @return string
    */
    public function getName(): string
    {
        return 'set';
    }

}