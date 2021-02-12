<?php
namespace Jan\Foundation;


use Exception;
use Jan\Component\Container\Container;
use Jan\Component\Container\Contract\ContainerInterface;
use Jan\Component\Database\Database;
use Jan\Component\Dotenv\Dotenv;
use Jan\Component\Http\Request;
use Jan\Component\Http\Response;
use Jan\Component\Routing\Router;
use Jan\Foundation\Provider\AppServiceProvider;
use Jan\Foundation\Provider\AssetServiceProvider;
use Jan\Foundation\Provider\ConfigurationServiceProvider;
use Jan\Foundation\Provider\ConsoleServiceProvider;
use Jan\Foundation\Provider\DatabaseServiceProvider;
use Jan\Foundation\Provider\FileSystemServiceProvider;
use Jan\Foundation\Provider\MiddlewareServiceProvider;
use Jan\Foundation\Provider\RouteServiceProvider;
use Jan\Foundation\Provider\ViewServiceProvider;




/**
 * Class Application
 *
 * @package Jan\Foundation
*/
class Application extends Container
{


      /**
        * @var string
      */
      protected $name = 'JKFramework';


      /**
       * version of application
       *
       * @var string
      */
      protected $version = '1.0';



      /**
       * @var string
      */
      protected $basePath;



      /**
       * Application constructor.
       * @param string $basePath
       * @throws Exception
      */
      public function __construct(string $basePath = '')
      {
            if($basePath)
            {
                 $this->setBasePath($basePath);
            }

           // register base bindings
           $this->registerBaseBindings();


           // register services providers
           $this->registerBaseServiceProviders();
      }



      /**
       * @param string $basePath
       * @return $this
      */
      public function setBasePath(string $basePath): Application
      {
           $this->basePath = rtrim($basePath, '\\/');

           $this->instance('path', $this->basePath);

           return $this;
      }


      /**
       * @return string
      */
      public function getBasePath(): string
      {
          return $this->basePath;
      }


      /**
       * Register base bindings
       *
       * @return void
       * @throws Exception
      */
      public function registerBaseBindings()
      {
          // bindings
          static::setInstance($this);
          $this->instance(Container::class, $this);
          $this->instance(ContainerInterface::class, $this);
          $this->instance('app', $this);

          // load environments
          $this->loadEnvironments();

          // Load helpers
          $this->loadHelpers();
      }



      /**
       * Register core container aliases
       *
       * @return void
      */
      public function registerCoreContainerAliases()
      {
            //TODO implements
      }


      /**
        * Terminate application
        *
        * @param Request $request
        * @param Response $response
        * @throws Exception
      */
      public function terminate(Request $request, Response $response)
      {
           // show content
           $response->sendBody();

           // dump($this->get('_currentRoute'));


           /*
            echo $response->getBody();
            echo "<p>----------- DEBUG ----------------------------------------</p>";
            echo "micro: 0.09865775 , path : / , name : home , controller : ";
           */

           // TODO affiche log debug Route
           // Debug

           // Close Database
           // dd($this->get(Manager::class)->getConnection());

           // dump($this->get('db'));
           // Database::open();
           /*
           dump(Database::connection());
           Database::close();
           dump(Database::connection());
           */
          // dump($this->get('db'));

          // dump($this->get(Router::class)->getRoutesByMethod());
          // dd($this);
      }


      /**
       * Register base service providers
       *
       * @return void
       * @throws Exception
      */
      protected function registerBaseServiceProviders()
      {
          // register base service providers
          $this->registerProviders([
            FileSystemServiceProvider::class,
            ConfigurationServiceProvider::class,
            AppServiceProvider::class,
            DatabaseServiceProvider::class,
            ConsoleServiceProvider::class,
            MiddlewareServiceProvider::class,
            RouteServiceProvider::class,
            AssetServiceProvider::class,
            ViewServiceProvider::class
          ]);
    }



     /**
       * Load Helpers
     */
     protected function loadHelpers()
     {
         require realpath(__DIR__.'/helpers.php');
     }


    /**
     * @throws Exception|Exception
    */
    protected function loadEnvironments()
    {
        try {

            $dotenv = Dotenv::create($this->get('path'));

            $devEnvirons = $dotenv->load('.env.local');

            $environs =  $devEnvirons ?: $dotenv->load('.env');

            /*
            $env = 'form config(dev/prod)';
            $env === 'dev' ? $dotenv->load('.env.local') : $dotenv->load('.env');
            */

        } catch (Exception $e) {

            /* exit($e->getMessage()); */
            throw $e;
        }
    }

}