<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;


/**
 * Class DeleteType
 * @package Jan\Component\Database\Builder\Type
*/
class DeleteType extends SqlType
{

    /**
     * @return bool
    */
    public function isBaseSQL()
    {
        return true;
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
    */
    public function build(): string
    {
        $preSQL = 'DELETE';
        if($this->alias)
        {
            $preSQL .= sprintf(' %s', $this->alias);
        }
        return sprintf('%s FROM %s', $preSQL, $this->getTableSQL());
    }


    /**
     * @return string|null
    */
    public function getName(): string
    {
         return 'delete';
    }
}