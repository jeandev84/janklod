# Database Manager
```markdown
$database = new DatabaseManager();

$database->open([
    'driver'    => 'mysql',
    'database'  => 'janklod',
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'username'  => 'root',
    'password'  => '',
    'collation' => 'utf8_unicode_ci',
    'charset'   => 'utf8',
    'prefix'    => '',
    'engine'    => 'InnoDB', // MyISAM
    'options'   => [],
]);

$database->connection()->query('SELECT * FROM `users` WHERE id = :id', ['id' => 1]);


$database->close();

$database->connection()->query('SELECT * FROM `users` WHERE id = :id', ['id' => 1]);

```