<?php
namespace Jan\Component\Database\Capsule;


use Exception;
use Jan\Component\Database\ConnectionTrait;
use Jan\Component\Database\DatabaseManager;



/**
 * Class Capsule
 * @package Jan\Component\Database\Capsule
*/
class Manager
{

    use ConnectionTrait;


    /**
     * @var DatabaseManager
    */
    protected static $instance;


    /**
     * @var array
    */
    protected $configParams = [];



    /**
     * @param array $configParams
     * @return Manager
    */
    public function addConnection(array $configParams): Manager
    {
        $this->configParams = $configParams;

        return $this;
    }


    /**
     * @return Exception|DatabaseManager
     * @throws Exception
    */
    public function create()
    {
        if(! $this->configParams)
        {
            return new Exception('no connection added.');
        }

        return new DatabaseManager($this->configParams);
    }


    /**
     * @return void
     * @throws Exception
    */
    public function setAsGlobal()
    {
        if(! self::$instance)
        {
            $manager = $this->create();
            $this->setManager($manager);
            self::$instance = $manager;
        }
    }


    /**
     * get Instance of manager
     * @throws Exception
    */
    public static function getInstance(): DatabaseManager
    {
        if(! self::$instance instanceof DatabaseManager)
        {
            throw new Exception('You must to open database connection.');
        }

        return self::$instance;
    }

}


/*
// Capsule Manager
$database = new Manager();
$database->addConnection([
    'driver'    => 'mysql',
    'database'  => 'janklod',
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'username'  => 'root',
    'password'  => '',
    'collation' => 'utf8_unicode_ci',
    'charset'   => 'utf8',
    'prefix'    => '',
    'engine'    => 'InnoDB', // MyISAM
    'options'   => [],
]);

$database->setAsGlobal();


// Will be available this callback
Manager::getInstance();
*/