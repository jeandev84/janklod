<?php

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


dd(__FILE__, __LINE__);