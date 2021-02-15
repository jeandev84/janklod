<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;



/**
 * Class WhereType
 * @package Jan\Component\Database\Builder\Type
*/
class WhereType extends SqlType
{

    /**
     * @var string
    */
    protected $condition;


    /**
     * WhereType constructor.
    */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }



    /**
     * @return string|null
    */
    public function build(): ?string
    {
        return sprintf('%s', trim($this->condition));
    }


    /**
     * @return string
    */
    public function getName(): string
    {
         return 'where';
    }


    /**
     * @return bool
    */
    public function isConditional(): bool
    {
        return true;
    }
}