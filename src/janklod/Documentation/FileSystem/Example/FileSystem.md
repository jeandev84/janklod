# FILESYSTEM
```markdown 

$filesystem = new \Jan\Component\FileSystem\FileSystem(
    realpath(__DIR__.'/../')
);

$filename = 'database/migrations/create_users_table_202012160148.php';
$filesystem->make($filename);

dump($filesystem->load('config/app.php'));
^ array:2 [▼
  "project" => "Ecommerce"
  "db" => array:8 [▼
    "driver" => "mysql"
    "host" => "127.0.0.1"
    "database" => "ecommerce"
    "username" => "root"
    "password" => "secret"
    "options" => []
    "charset" => "utf8"
    "prefix" => ""
  ]
]

echo $filesystem->read($filename);
$filesystem->write($filename, "Приходи сегодня!");
echo $filesystem->read($filename);

--------------------------------------------------------------------------

$filesystem = new \Jan\Component\FileSystem\FileSystem(
    realpath(__DIR__.'/../')
);

$filesystem->mkdir('tests');
$filename = 'database/migrations/create_users_table_202012160148.php';
$filesystem->make($filename);
$filesystem->make('.env');
$filesystem->make('.env.local');

dump($filesystem->load('config/app.php'));
echo $filesystem->read($filename);
echo "<br/>";
$filesystem->write($filename, "Приходи сегодня!");
echo $filesystem->read($filename);
echo "<br/>";
echo $filesystem->extension($filename);
echo "<br/>";
```
