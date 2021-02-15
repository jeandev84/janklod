# MODEL 2
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



$pdoConnection = \Jan\Component\Database\Capsule\Manager::getInstance()->getPDO();
$pdo = $pdoConnection->getConnection();

/* dump($pdoConnection, $pdo); */



# QUERY BUILDER
$queryBuilder = new \Jan\Component\Database\Builder\MysqlQueryBuilder($pdoConnection);

/*
$results = $queryBuilder->table('users', 'u')
                        ->select()
                        ->getQuery()
                        ->getResult();
*/

/*
$results = \App\Model\User::findAll();
dd($results);
*/

$user = new \App\Model\User();

/*
$user->username = 'Alex';
$user->password = 'alex123';
$user->role = 'admin';

dd($user);
*/

$users = \App\Model\User::select()->orderByDesc('id')->get();
dump($users);


$users = \App\Model\User::findAll();
dump($users);


$user1 = \App\Model\User::find(1);
dump($user1);


$user2 = \App\Model\User::where('id', '2')->limit(1)->get();
$user3 = \App\Model\User::where('id', '3')->one();
$user4 = \App\Model\User::where('id', '4')->first();


echo 'GET USER';
dump($user2, $user3, $user4);


$userDoe = \App\Model\User::select('username', 'password')
         ->where('id = :id')
         ->setParameter('id', 6)
         ->get();


dd($userDoe);


/*
$user = new \App\Model\User();

$user->id = 6;
$user->username = 'Жан-Клод';
$user->password = 'qwerty123';
$user->role = 'superadmin';

dd($user);
*/


/*
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
*/
```