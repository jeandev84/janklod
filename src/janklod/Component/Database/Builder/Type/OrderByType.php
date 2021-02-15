<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;


/**
 * Class OrderByType
 * @package Jan\Component\Database\Query\Type
*/
class OrderByType extends SqlType
{

    /**
     * @var string
    */
    private $column;



    /**
     * @var string
    */
    private $sort;


    /**
     * OrderByType constructor.
     * @param array|string $column
     * @param string $sort
    */
    public function __construct($column, $sort = 'asc')
    {
        $this->column = $column;
        $this->sort   = strtoupper($sort);
    }


    /**
     * @return string|null
    */
    public function build(): ?string
    {
        if(\is_array($this->column))
        {
            $this->column = implode(', ', $this->column);
        }

        if(\is_string($this->column))
        {
            return sprintf('ORDER BY %s %s', $this->column, $this->sort);
        }

        return '';
    }


    /**
     * @return string
    */
    public function getName(): string
    {
        return 'orderBy';
    }
}