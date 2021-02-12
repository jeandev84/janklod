<?php
namespace Jan\Component\Database\Schema;



use Closure;
use Exception;
use Jan\Component\Database\ConnectionTrait;
use Jan\Component\Database\Contract\ManagerInterface;




/**
 * Class Schema
 * @package Jan\Component\Database\Schema
*/
class Schema
{

    use ConnectionTrait;


    /**
     * Schema constructor.
     * @param ManagerInterface $manager
    */
    public function __construct(ManagerInterface $manager)
    {
          $this->setManager($manager);
    }


    /**
     * @param string $table
     * @param Closure $closure
     * @throws Exception
    */
    public function create(string $table, Closure $closure)
    {
        $table = $this->getTableName($table);

        $bluePrint = new BluePrint($table);

        $closure($bluePrint);

        $sql = sprintf("
           CREATE TABLE IF NOT EXISTS `%s` (%s) 
           ENGINE=%s DEFAULT CHARSET=%s
           COMMENT='Table with abuse reports' AUTO_INCREMENT=1;%s",
           $table,
           $bluePrint->buildDefaultColumnSql(),
           $this->getConfiguration()->getEngine(),
           $this->getConfiguration()->getCharset(),
           $bluePrint->buildAlteredColumnSql()
        );

//        dump($sql);
        $this->exec($sql);
    }


    /**
     * @param string $table
     * @throws Exception
    */
    public function drop(string $table)
    {
        $sql = sprintf(
            "DROP TABLE `%s`;",
            $this->getTableName($table)
        );

        $this->exec($sql);
    }


    /**
     * @param $table
     * @return void
     * @throws Exception
    */
    public function dropIfExists($table)
    {
        $sql = sprintf(
            "DROP TABLE IF EXISTS `%s`;",
            $this->getTableName($table)
        );

        $this->exec($sql);
    }


    /**
     * @param $table
     * @return void
     * @throws \Exception
    */
    public function truncate($table)
    {
        $sql = sprintf(
            "TRUNCATE TABLE `%s`;",
          $this->getTableName($table)
        );

        $this->exec($sql);
    }



    public function backup()
    {

    }



    public function export()
    {

    }



    /**
     * Import
    */
    public function import()
    {

    }



    /**
     * @param $sql
     * @return mixed
    */
    public function exec($sql)
    {
       return $this->getConnection()->exec($sql);
    }

    
    
    public function execute()
    {
             
    }
    
    

    /**
     * @param $table
     * @return string
     * @throws Exception
    */
    protected function getTableName($table): string
    {
        return $this->getConfiguration()->getTableName($table);
    }
}

/*
use Jan\Foundation\Facade\Database\Schema;

Schema::create('users', function (BluePrint $table) {
    $table->increments('id');
    $table->string('username');
    $table->string('password');
    $table->string('role');
});
*/