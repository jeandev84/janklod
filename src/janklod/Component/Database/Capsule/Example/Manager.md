# CAPSULE 1
```markdown
<?php

$mysqlConfig = [
    'driver' => 'mysql',
    'database' => 'janklod',
    'host' => '127.0.0.1',
    'port' => '3306',
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


$connection = \Jan\Component\Database\Capsule\Manager::getInstance()->getPDO();

dump($connection);
$query = $connection->query('SELECT * FROM users', [], \App\Entity\User::class)
                    ->execute();

dump($query);
dump($query->getResult());
```