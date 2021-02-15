<?php
namespace Jan\Component\Database\Migration;


use Jan\Component\Database\Migration\Contract\Migratable;
use Jan\Component\Database\Schema\Schema;


/**
 * Class Migration
 * @package Jan\Component\Database\Migration
*/
abstract class Migration implements Migratable
{


    /**
     * @var Schema
    */
    protected $schema;



    /**
     * @var string
    */
    protected $version;


    /**
     * @var string
    */
    protected $executedAt;


    /**
     * @var string
    */
    protected $filename;


    /**
     * @param $version
    */
    public function setVersion($version)
    {
         $this->version = $version;
    }


    /**
     * @return string
    */
    public function getVersion()
    {
        return $this->version;
    }



    /**
     * @param $executedAt
    */
    public function setExecutedAt($executedAt)
    {
         $this->executedAt = $executedAt;
    }


    /**
     * @return string
    */
    public function getExecutedAt()
    {
        return $this->executedAt;
    }


    /**
     * @param $filename
    */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }


    /**
     * @return string
    */
    public function getFilename()
    {
        return $this->filename;
    }


    /**
     * @param Schema $schema
    */
    public function schema(Schema $schema)
    {
        $this->schema = $schema;
    }



    /**
     * @param string $sql
     * @throws \Exception
    */
    public function addSql(string $sql)
    {
         $this->schema->execSQL($sql);
    }



    /**
     * @return mixed
    */
    abstract public function up();


    /**
     * @return mixed
    */
    abstract public function down();
}