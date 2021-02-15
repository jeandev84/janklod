<?php

/*
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



$pdoConnection = \Jan\Component\Database\Capsule\Manager::getInstance()->getPDO();
dump($pdoConnection);
$query = $pdoConnection->query('SELECT * FROM users', [], \App\Entity\User::class)
                      ->execute();
dump($query);
dump($query->getResult());



$database = \Jan\Component\Database\Capsule\Manager::getInstance();

dump($database);
$query1 = $database->query('SELECT * FROM users', [], \App\Entity\User::class)
                  ->execute();


dump($query1);
dump($query1->getResult());
//dump($query1->getFirstRecord());
//dump($query1->getOneRecord());

$query2 = $database->query('SELECT * FROM users WHERE id = ?', [2], \App\Entity\User::class)
                   ->execute();

dump($query2);
//dump($query2->getResults());
dump($query2->getFirstRecord());
//dump($query2->getOneRecord());

dump(\Jan\Component\Database\Capsule\Manager::getInstance());
\App\Entity\Product::findAll();
\App\Entity\Product::find(1);
\App\Entity\Product::where('id', 3, '>');
*/


//\App\Model\User::findAll();



/*
// Transport settings
$transport = new \Jan\Component\Service\Mailer\MailerTransport();
$transport->setHost('stmp.mailtrap.io')
          ->setPort(5252)
          ->setUsername('test')
          ->setPassword('secret');


// Mailer settings
$mailer = new \Jan\Component\Service\Mailer\Mailer($transport);


// Message settings
$message = new \Jan\Component\Service\Mailer\MailerMessage();
$message->setFrom('test@gmail.com')
        ->setTo('jeanyao@ymail.com')
        ->setBody('Тестовое сообщение!');


// Send Message
$mailer->send($message);

dd($mailer);
*/

$queryBuilder = new \Jan\Component\Database\ORM\Builder\QueryBuilder();

$queryBuilder->select('id', 'name', 'price', 'description')
             ->from('products', 'p')
             ->orderBy('p.id', 'desc');
             //->orderByDesc('u.id');


dump($queryBuilder->getSQL());
dump($queryBuilder);

$queryBuilder->table('users', 'u')->update([
    'name' => 'Жан-Клод',
    'surname' => 'Яо',
    'address' => 'Головинское шоссе д 8 к 2а',
    'region' => 'Москва'
]);


dump($queryBuilder->getSQL());
dd($queryBuilder);