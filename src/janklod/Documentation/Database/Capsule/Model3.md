# MODEL 3
```markdown
<?php

# CONNECTION
/*
$mysqlConfig = [
    'driver' => 'mysql',
    'database' => 'janklod',
    'host' => '127.0.0.1',
    'port' => '3306', // 5432
    'username' => 'root',
    'password' => '',
    'collation' => 'utf8_unicode_ci',
    'charset' => 'utf8',
    'prefix' => '', // jan_
    'engine' => 'InnoDB', // MyISAM
    'options' => [],
];


$capsule = new \Jan\Component\Database\Capsule\Manager();
$capsule->addConnection($mysqlConfig);
$capsule->setAsGlobal();



$pgsqlConfig = [
    'driver' => 'pgsql',
    'database' => 'janklod',
    'host' => '127.0.0.1',
    'port' => '5432', // 5432
    'username' => 'postgres',
    'password' => '123456',
    'collation' => 'utf8_unicode_ci',
    'charset' => 'utf8',
    'prefix' => '', // jan_
    'engine' => 'InnoDB', // MyISAM
    'options' => [],
];


$capsule = new \Jan\Component\Database\Capsule\Manager();
$capsule->addConnection($pgsqlConfig);
*/

/* ALTER DATABASE dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; */
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
    $capsule = new \Jan\Component\Database\Capsule\Manager();
    $capsule->addConnection($mysqlConfig);
    $capsule->setAsGlobal();
} catch (Exception $e) {
    throw $e;
}



$pdoConnection = \Jan\Component\Database\Capsule\Manager::getInstance()->getPDO();
$pdo = $pdoConnection->getConnection();

/* dump($pdoConnection, $pdo); */



# QUERY BUILDER
$queryBuilder = new \Jan\Component\Database\Builder\MysqlQueryBuilder($pdoConnection);

/*
$sql = $queryBuilder->table('users', 'u')->insert([
    'username' => 'Жан-Клод',// fix characters
    'password' => 'secret123',
    'role' => 'user'
])->getSQL();

dump($sql, $queryBuilder);
*/

/*
$queryBuilder->table('users', 'u')->insert([
    'username' => 'Jean-Claude2',
    'password' => 'secret123',
    'role' => 'user'
])->execute();


$queryBuilder->table('users')
             ->delete()
             ->where('id = :id')
             ->setParameter('id', 25)
             ->execute()
;


dd($queryBuilder->getSQL());
*/

$queryBuilder->table('users', 'u')->update([
    'username' => 'Jean',
    'password' => 'mot-de-passe',
    'role' => serialize('ROLE_ADMIN')
])
->where('id = :id')
->setParameter('id', 2)
->execute();


dd($queryBuilder->getSQL());
```