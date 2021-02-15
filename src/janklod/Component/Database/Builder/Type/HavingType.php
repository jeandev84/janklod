<?php


namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;



/**
 * Class HavingType
 * @package Jan\Component\Database\Builder\Type
*/
class HavingType extends SqlType
{

    /**
     * @var string
    */
    private $condition;


    /**
     * HavingType constructor.
     * @param string $condition
    */
    public function __construct(string $condition)
    {
         $this->condition = $condition;
    }



    /**
     * @return string|null
    */
    public function build(): ?string
    {
        return sprintf('HAVING %s', $this->condition);
    }


    /**
     * @return string
    */
    public function getName(): string
    {
        return 'having';
    }
}