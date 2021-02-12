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



try {
    $capsule = new \Jan\Component\Database\Capsule\Manager();
    $capsule->addConnection($mysqlConfig);
    $capsule->setAsGlobal();
} catch (Exception $e) {
    throw $e;
}

try {
    $capsule->setAsGlobal();
} catch (Exception $e) {
}


$pdoConnection = \Jan\Component\Database\Capsule\Manager::getInstance()->getPDO();
$pdo = $pdoConnection->getConnection();

/* dump($pdoConnection, $pdo); */



# QUERY BUILDER
$queryBuilder = new \Jan\Component\Database\ORM\Builder\MysqlQueryBuilder($pdoConnection);

$sql1 = $queryBuilder->table('users', 'u')
                     ->select('name', 'surname', 'region')
                     //->from('bar', 'b')
                     //->where('id = :id')
                     //->where('NOT foo = :foo')
                     ->andWhere('region = :region')
                     ->andWhere('patronymic = :patronymic')
                     ->andWhere('region = :region')
                     ->orWhere('surname = :surname')
                     ->notWhere('test = :test')
                     ->setParameters([
                         'id' => 1,
                         'foo' => 'foo',
                         'region' => 'Москва',
                         'patronymic' => 'Яо',
                         'surname' => 'Яо'
                     ])
                     ->orderBy('name', 'desc')
                     ->groupBy('id')
                     ->getSQL();

dump($queryBuilder);
echo $sql1;


$sql0 = $queryBuilder->table('foo', 'f')
                     ->select('id', 'column1', 'column2', 'user_id')
                     ->join('users', 'foo.user_id = users.id')
                     ->where('id = :id')
                     ->setParameter('username', 'Николай')
                     ->getSQL();

dump($queryBuilder);
echo $sql0;




$sql2 = $queryBuilder->table('products', 'p')->insert([
    'title' => 'Product 1',
    'description' => 'This is a popular product',
    'price' => '30 RUB',
])->getSQL();

dump($queryBuilder);
echo $sql2;


$sql3 = $queryBuilder->table('test', 't')->delete('foo')
                     ->where('id = :id')
                     ->setParameter('id', 1)
                     ->getSQL();

$sql3 = $queryBuilder->delete('foo')
                     ->where('id = :id')
                     ->setParameter('id', 1)
                     ->getSQL();



dump($queryBuilder);
echo $sql3;


$paginatedQuery = new \Jan\Component\Database\Connection\PDO\PaginatedQuery();

$query = new \Jan\Component\Database\Connection\PDO\Query($pdo);

$query->setSQL('SELECT * FROM users');

$pagination = $paginatedQuery->paginate(
    $query, (int) (isset($_GET['page']) ? $_GET['page'] : 1),
    3
);


echo "<br>";
echo "Pagination";
dd($pagination->getItems());
