<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;



/**
 * Class SelectType
 * @package Jan\Component\Database\Builder\Type
*/
class SelectType extends SqlType
{

    /**
     * @var string
    */
    protected $baseSQL = 'SELECT';


    /**
     * @var array
    */
    private $columns = [];



    /**
     * @var bool
    */
    protected $distinct;



    /**
     * SelectType constructor.
     * @param array $columns
    */
    public function __construct(array $columns = [], bool $distinct = false)
    {
        if(! empty($columns) && \is_array($columns[0]))
        {
            $columns =  $columns[0];
        }

        $this->columns = $columns;

         if($distinct === true)
         {
             $this->baseSQL = 'SELECT DISTINCT';
         }
    }



    /**
     * @return string|null
    */
    public function build(): ?string
    {
        $selects = '*';

        if($this->columns)
        {
             $selects = $this->buildSelectedColumns($this->columns);
        }

        $sql = sprintf('%s %s', $this->baseSQL, $selects);

        if($this->table)
        {
            $sql .= ' FROM '. $this->getTableSQL();
        }
        
        return $sql;
    }


    /**
     * @return string
    */
    public function getName(): string
    {
         return 'select';
    }


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
}