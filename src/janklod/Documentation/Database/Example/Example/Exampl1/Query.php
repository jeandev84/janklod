<?php
namespace Jan\Component\Database;


use Jan\Component\Database\ORM\Builder\QueryBuilder;

/**
 * Class Query
 * @package Jan\Component\Database
*/
class Query
{

    private static $manager;


    /**
     * Query constructor.
     * @param array $params
     * @throws \Exception
    */
    public function __construct($params = [])
    {
        self::$manager = new DatabaseManager($params);
    }



    /**
     * @param $table
     * @return QueryBuilder
    */
    public static function table($table)
    {
         $queryBuilder = new QueryBuilder();
         $queryBuilder->table($table);

         return $queryBuilder;
    }
}