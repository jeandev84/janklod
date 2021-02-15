<?php
namespace Jan\Express;


use Closure;
use Exception;
use Jan\Component\Container\Container;
use Jan\Component\Http\Middleware\Contract\MiddlewareInterface;
use Jan\Component\Http\Middleware\Middleware;
use Jan\Component\Http\Request;
use Jan\Component\Http\Response;
use Jan\Component\Routing\Route;
use Jan\Component\Routing\Router;


/**
 * Class App
 * @package Jan\Express
*/
class App
{

       /**
         * @var string
       */
       protected $name = 'JanExpress';


       /**
        * @var array
       */
       protected $config = [];


       /**
        * @var array
       */
       protected $middlewares = [];


       /**
        * @var Container
       */
       protected $container;



       /**
        * @var Router
       */
       protected $router;


       /**
        * @var Middleware
       */
       protected $middlewareStack;


       /**
        * @var App
       */
       protected static $instance;


       /**
         * App constructor.
         * @param array $config
       */
       private function __construct(array $config = [])
       {
            if($config)
            {
                $this->config = $config;
            }

            $this->container = Container::getInstance();
            $this->router = new Router();
            $this->middlewareStack = new Middleware();
       }


       /**
        * @return Container
       */
       public function getContainer()
       {
           return $this->container;
       }


       /**
        * @return Middleware
       */
       public function getMiddlewareStack()
       {
            return $this->middlewareStack;
       }


       /**
        * @param array $config
        * @return App
      */
      public static function express(array $config = []): App
      {
            if(! static::$instance)
            {
                static::$instance = new static($config);
            }

            return static::$instance;
       }


      /**
        * @param MiddlewareInterface|string $middleware
        * @return App
        * @throws Exception
      */
       public function middleware($middleware): App
       {
           /*
            if(is_string($middleware))
            {
                $middleware = $this->container->get($middleware);
            }

            if($middleware instanceof MiddlewareInterface)
            {
                $this->middlewares[] = $middleware;
            }
           */

           $this->middlewares[] = $middleware;

            return $this;
       }


       /**
         * @param string $methods
         * @param string $path
         * @param Closure $callback
         * @return Route
       */
       public function map(string $methods, string $path, Closure $callback): Route
       {
           return $this->router->map($methods, $path, $callback);
       }


       /**
        * @return void
        * @throws Exception
       */
       public function run()
       {
            $this->getContainer()->registerProviders(['Data from config file']);

            $request  = Request::createFromGlobals();
            $response = new Response();

            if(! $this->process($request, $response))
            {
                throw new Exception(sprintf('Page not found (%s)', $request->getRequestUri()), 404);
            }
       }




      /**
        * @param array $classMaps
        * @return array
        * @throws Exception
      */
      public function resolve(array $classMaps): array
      {
           $resolved = [];

           foreach ($classMaps as $classMap)
           {
               $resolved[] = $this->getContainer()->get($classMap);
           }

           return $resolved;
       }


       /**
        * @param Exception $e
       */
       public function errorLog(Exception $e)
       {
            // TODO some logic here
       }


       /**
         * @return array
       */
       public function getRoutes(): array
       {
           return $this->router->getRoutes();
       }


       /**
         * @param $path
         * @param Closure $handler
         * @return Route
        */
        public function get($path, Closure $handler): Route
        {
            return $this->map('GET', $path, $handler);
        }


        /**
         * @param $path
         * @param Closure $handler
         * @return Route
        */
        public function post($path, Closure $handler): Route
        {
             return $this->map('POST', $path, $handler);
        }


        /**
         * @param $path
         * @param Closure $handler
         * @return Route
        */
        public function put($path, Closure $handler): Route
        {
            return $this->map('PUT', $path, $handler);
        }


       /**
        * @param $path
        * @param Closure $handler
        * @return Route
       */
       public function delete($path, Closure $handler): Route
       {
            return $this->map('DELETE', $path, $handler);
       }


      /**
       * @param Request $request
       * @param Response $response
       * @return bool
       * @throws Exception
      */
      protected function process(Request $request, Response $response): bool
      {
          if($route = $this->router->match($request->getMethod(), $request->getRequestUri()))
          {
              $callback = $route->getTarget();
              $request->setAttributes([
                  'params' => $route->getMatches(),
                  'name'   => $route->getName()
              ]);

              $middlewares = array_merge($route->getMiddleware(), $this->middlewares);
              $this->middlewareStack->middlewares($this->resolve($middlewares));
              $this->middlewareStack->handle($request);

              $response->send();
              echo $callback($request, $response);
              return true;
          }

          return false;
       }


       /**
        * @param $key
        * @param $options
        * @return bool|null
       */
       protected function validateOption($key, $options): ?bool
       {
           return isset($options[$key]) ?? null;
       }
}
