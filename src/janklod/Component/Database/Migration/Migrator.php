<?php
namespace Jan\Component\Database\Migration;


use Exception;
use Jan\Component\Database\Schema\BluePrint;
use Jan\Component\Database\Schema\Schema;




/**
 * Class Migrator <<Version control>>
 *
 * @package Jan\Component\Database\Migration
*/
class Migrator
{

      /**
       * migration table version
       *
       * @var string
      */
      protected $migrationTable = 'migrations';



      /**
       * @var Schema
      */
      protected $schema;




     /**
      * @var array
     */
     protected $migrations = [];


     
     /**
      * @var array 
     */
     protected $migrationFiles = [];
     
     
     
     /**
      * @var array
     */
     protected $messages = [];




      /**
        * Migrator constructor.
        * @param Schema $schema
      */
      public function __construct(Schema $schema)
      {
          $this->schema = $schema;
      }



      /**
       * Set table name for versions migrations
       *
       * @param string $migrationTable
       * @return $this
      */
      public function setMigrationTable(string $migrationTable): Migrator
      {
           $this->migrationTable = $migrationTable;

           return $this;
      }


      /**
       * @param Migration $migration
       * @return Migrator
      */
      public function addMigration(Migration $migration): Migrator
      {
           $migration->schema($this->schema);
           $this->migrations[] = $migration;

           return $this;
      }

      
      
      /**
       * $migrations = glob("/Migrations/*.php")
       *
       * @param array $migrations
       * @return $this
      */
      public function setMigrations(array $migrations): Migrator
      {
            foreach ($migrations as $migration)
            {
                if($migration instanceof Migration)
                {
                     $this->addMigration($migration);
                }
            }

            return $this;
      }



      /**
       * @return array
      */
      public function getMigrations(): array
      {
          return $this->migrations;
      }



      /**
       * @return mixed
      */
      public function getOldMigrations()
      {
           // must to get results
           return $this->schema->getConnection()
                               ->query("SELECT `version` FROM {$this->migrationTable}")
                               ->execute()
                               ->getResult();
      }



      /**
       * @return array
      */
      public function getNewMigrations(): array
      {
          $newMigrations = [];

          foreach ($this->migrations as $migration)
          {
              if(! \in_array(\get_class($migration), $this->getOldMigrations()))
              {
                   $newMigrations[] = $migration;
              }
          }

          return $newMigrations;
      }


      /**
       * Install migration version table
       *
       * @throws Exception
      */
      public function install()
      {
          $this->schema->create($this->migrationTable, function (BluePrint $table) {
              $table->increments('id');
              $table->string('version');
              $table->datetime('executed_at');
          });

      }


     /**
      * Migrate table to the database
      *
      * @throws Exception
     */
     public function migrate()
     {
          $this->install();

          $this->doUpAction($this->migrations);
     }


     /**
      * @throws Exception
     */
     public function diff()
     {
         $this->install();

         $this->doUpAction($this->getNewMigrations());
     }



     public function update()
     {
           //
     }



     /**
      * @param array $migrations
     */
     public function doUpAction(array $migrations)
     {
         foreach ($migrations as $migration)
         {
             if(method_exists($migration, 'up'))
             {
                 $migration->up();

                 $this->schema->exec(
                     sprintf("INSERT INTO `%s` (version, executed_at) VALUES ('%s', '%s')",
                         $this->migrationTable,
                         $migration->getVersion(),
                         $migration->getExecutedAt()
                     )
                 );
             }
         }
     }

     /**
      * Drop all tables
     */
     public function rollback()
     {
        foreach ($this->migrations as $migration)
        {
            if(method_exists($migration, 'down'))
            {
                 $migration->down();
             }
         }

         $this->schema->truncate($this->migrationTable);
     }


     /**
      * @throws Exception
     */
     public function reset()
     {
          $this->rollback();
          $this->schema->dropIfExists($this->migrationTable);
          $this->removeMigrationFiles();
     }


     /**
      * @param Migration $migration
      * @throws \ReflectionException
     */
     public function removeMigrationFile(Migration $migration)
     {
           if(method_exists($migration, 'getFilename'))
           {
                unlink($migration->getFilename());
           }
     }



     /**
      * @param string $message
      * @return $this
     */
     public function addMessage(string $message)
     {
          $this->messages[] = $message;

          return $this;
     }


     /**
      * @return array
     */
     public function getMessages()
     {
         return $this->messages;
     }




     /**
      * Remove all migration files
     */
     public function removeMigrationFiles()
     {
         array_map('unlink', $this->getMigrationFiles());
     }


    /**
     * @return string
     * @throws \ReflectionException
    */
    public function getFilename(Migration $migration)
    {
         if(method_exists($migration, 'getFilename'))
         {
             return $migration->getFilename();
         }

         return $this->reflectedClass($migration)->getFileName();
    }


    /**
     * @return array
    */
    public function getMigrationFiles()
    {
        $migrationFiles = [];

        /** @var Migration $migration */
        foreach ($this->migrations as $migration)
        {
            $migrationFiles[] = $migration->getFilename();
        }

        return $migrationFiles;
    }



    /**
     * @param string $className
     * @return \ReflectionClass
     * @throws \ReflectionException
    */
    protected function reflectedClass(string $className)
    {
        try {

            return new \ReflectionClass($className);

        } catch (\ReflectionException $e) {
             throw $e;
        }
    }
}


/*

$database = new DatabaseManager();
$database->open([
    'driver'    => 'mysql',
    'database'  => 'default',
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'charset'   => 'utf8',
    'username'  => 'root',
    'password'  => 'secret',
    'collation' => 'utf8_unicode_ci',
    'options'   => [],
    'prefix'    => '',
    'engine'    => 'innoDB',
    'migrationTable' => '',
    'migration_dir' => ''
]);

$schema = new Schema($database);
$migrator = new Migrator($schema);


$migrator->setMigrations([
  new Version845464643(),
  new Version865464657(),
  new Version875464901(),
  new Version885464846(),
]);

$migrator->migrate();
$migrator->rollback();
*/
