# Application express
==================================================
```markdown
This framework used for quickly building web application
```

# Start to work with express application
```
use Jan\Express\Http\Request;
use Jan\Express\Http\Response;
use Jan\Express\App;

$config = [
  'basePath' => realpath(__DIR__.'/../'),
  'baseUrl'  =>  'http://localhost',
  'db' => [
      'driver' => 'mysql',
      'host'   => 'localhost',
      'database' => 'express',
      /* .... */
  ],
  'providers' => [
      // add your providers
  ],
  'middlewares' => [
      // add your middlewares    
  ],
  'facades' => [
      // add facades
  ],
  'aliases' => [
      // add class aliases
  ]
];


$app = App::express($config);


# REGISTER ROUTES
$app->get("/", function(Request $request, Response $response) {

      dump($request);

      return $response->withBody("Home page");
});


$app->get("/profile", function(Request $request, Response $response) {

    dump($request);

    $username = $request->queryParams->get('username');
    $region   = $request->queryParams->get('region');

    return $response->withBody('Привет ! '. $username . '. Ваш регион : '. $region);
});


$app->get("/user/{id}", function(Request $request, Response $response) {

    $id = $request->getAttribute('id');

    return $response->withBody('Profile user : '. $id);

})->where('id', '\d+');


$mode = 'prod' ? 1 : 0; // just for testing something

try {

    $app->run();

} catch (Exception $e) {

    if($e->getCode() == 404 && $mode === 'dev')
    {
        echo $e->getMessage();
    }

    exit('Something went wrong!');
}


dump($app->getRoutes());

?>

<a href="/">Home</a> |
<a href="/profile?username=Жан-Клод&region=Moscow">Profile</a>
```