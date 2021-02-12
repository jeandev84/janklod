<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;


/**
 * Class ShowColumnType
 * @package Jan\Component\Database\Builder\Type
*/
class ShowColumnType extends SqlType
{

    public function build(): ?string
    {
        return sprintf('SHOW COLUMNS FROM %s', $this->getTableSQL());
    }

    public function getName(): string
    {
        return 'showColumn';
    }


    /**
     * @return bool
    */
    public function isBaseSQL()
    {
        return true;
    }
}