# CAPSULE ELOQUENT
```markdown 
$config = [
    'driver' => 'mysql',
    'database' => 'janklod',
    'host' => '127.0.0.1',
    'port' => '3306',
    'username' => 'root',
    'password' => '',
    'collation' => 'utf8_unicode_ci',
    'charset' => 'utf8',
    'prefix' => '',
    'engine' => 'InnoDB', // MyISAM
    'options' => [],
];


$capsule = new \Jan\Component\Database\Capsule\Manager();
$capsule->addConnection($config);
$capsule->setAsGlobal();



\App\Entity\Product::findAll();
\App\Entity\Product::find(1);
\App\Entity\Product::where('id', 3, '>')->get();
\App\Entity\Product::where('id', 3, '>')->first();
\App\Entity\Product::where('id', 3, '>')->one();
```