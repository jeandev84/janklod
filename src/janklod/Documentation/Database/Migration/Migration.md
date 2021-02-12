# MIGRATIONS (Install, Migrate, Rollback, Reset, Diff, Update)
```markdown
/* ALTER DATABASE dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; */

use Jan\Component\Database\Capsule\Manager;
use Jan\Component\Database\Migration\Migration;

$mysqlConfig = [
    'driver' => 'mysql',
    'database' => 'janklod',
    'host' => '127.0.0.1',
    'port' => '3306', // 5432
    'username' => 'root',
    'password' => '',
    //'collation' => 'utf8mb4_unicode_ci', // utf8_general_ci
    //'charset' => 'utf8mb4', // utf8
    'prefix' => '', // jan_
    'engine' => 'InnoDB', // MyISAM
    'options' => [],
];



try {
    $capsule = new Manager();
    $capsule->addConnection($mysqlConfig);
    $capsule->setAsGlobal();

    /*
    $pdoConnection = Manager::getInstance()->getPDO();
    $pdo = $pdoConnection->getConnection();
    */

} catch (Exception $e) {
    throw $e;
}



# MIGRATOR

$schema = new Jan\Component\Database\Schema\Schema(Manager::getInstance());
dump($schema);

$migrator = new \Jan\Component\Database\Migration\Migrator($schema);
dump($migrator);


$fileSystem = new \Jan\Component\FileSystem\FileSystem(
    realpath(__DIR__.'/../../')
);


/* dump($fileSystem->resources('app/Migration/*.php')); */

/**
 * @param \Jan\Component\FileSystem\FileSystem $fileSystem
*/
function migrationLoad(\Jan\Component\FileSystem\FileSystem $fileSystem)
{
    $resources = $fileSystem->resources('app/Migration/*.php');

    if($resources)
    {
        $migrations = [];

        /*
        $datetime = new DateTime();
        $format = $datetime->format('Y-m-d H:i:s'); or date('Y-m-d H:i:s')
        */

        foreach ($resources as $resource)
        {
            $filename = $fileSystem->info($resource)['filename'];
            $migrationClass = 'App\\Migration\\'. $filename;
            /** @var Migration $migrationObj */
            $migrationObj = new $migrationClass();
            $migrationObj->setVersion($filename);
            $migrationObj->setFilename($resource);
            $migrationObj->setExecutedAt(date('Y-m-d H:i:s'));
            $migrations[] = $migrationObj;
        }

        return $migrations;
    }
}


if($migrations = migrationLoad($fileSystem))
{
    $migrator->setMigrations($migrations);
    /* dd($migrator->getMigrations()); */

       # MIGRATION (INSTALL, MIGRATE, ROLLBACK, RESET) OK!!!
      $migrator->install();
      // $migrator->migrate();
      // $migrator->rollback();
      // $migrator->reset();
}


dd($migrator->getOldMigrations(), $migrator->getNewMigrations());

```