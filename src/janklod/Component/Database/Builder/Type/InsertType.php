<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;


/**
 * Class InsertType
 * @package Jan\Component\Database\Builder\Type
*/
class InsertType extends SqlType
{

    /**
     * @var array
    */
    protected $attributes;


    /**
     * InsertType constructor.
     * @param array $attributes
    */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }



    /**
     * @return bool
    */
    public function resetPreviousSQL()
    {
        return true;
    }


    /**
     * @return string|null
     * @throws \Exception
    */
    public function build(): string
    {
        $sql = sprintf('INSERT INTO %s ', $this->table);

        if($fields = $this->getAttributesFields())
        {
             $columns = '`' . implode('`, `', $fields) . '`';
             /* $bindPlaceholders = implode(', ', array_fill(0, count($fields), '?')); */
             /* $bindPlaceholders = "':" . implode("', ':", $fields) ."'"; */
             $placeholders = ":" . implode(", :", $fields);
             $sql .= sprintf('(%s) VALUES (%s)', $columns, $placeholders);
        }

        return $sql;
    }



    /**
     * @return string|null
    */
    public function getName(): string
    {
        return 'insert';
    }


    /**
     * @return bool
    */
    public function isBaseSQL()
    {
        return true;
    }
}