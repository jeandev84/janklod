<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;


/**
 * Class FromType
 * @package Jan\Component\Database\Builder\Type
*/
class FromType extends SqlType
{

    /**
     * FromType constructor.
     * @param string $table
     * @param string $alias
    */
    public function __construct(string $table, string $alias = '')
    {
          $this->setTable($table);

          if($alias)
          {
              $this->setAlias($alias);
          }
    }



    /**
     * @return string
    */
    public function build(): string
    {
        return sprintf('FROM %s', $this->getTableSQL());
    }



    /**
     * @return string|null
    */
    public function getName(): string
    {
        return 'from';
    }
}