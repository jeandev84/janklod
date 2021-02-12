<?php
namespace Jan\Foundation\Routing\Dispatcher;


use Exception;
use Jan\Component\Container\Container;
use Jan\Component\Http\JsonResponse;
use Jan\Component\Http\Middleware\Middleware;
use Jan\Component\Http\Request;
use Jan\Component\Http\Response;
use Jan\Component\Routing\Route;
use Jan\Component\Routing\Router;
use Jan\Foundation\Exception\NotFoundException;
use Jan\Foundation\Routing\DefaultController;
use ReflectionException;


/**
 * Class RouteDispatcher
 *
 * @package Jan\Foundation\Routing\Dispatcher
*/
class RouteDispatcher
{


      /**
       * @var string
      */
      protected $namespace = ''; // 'App\\Http\\Controllers'


      /**
        * @var Router
      */
      protected $router;


      /**
       * @var Container
      */
      protected $app;



      /**
       * @var array
      */
      protected $middlewares = [];


      /**
       * @var Middleware
      */
      protected $middleware;


      /**
       * RouteDispatcher constructor.
       * @param Router $router
       * @param Container $app
       * @param Middleware $middleware
      */
      public function __construct(Container $app, Router $router, Middleware $middleware)
      {
           $this->app = $app;
           $this->router = $router;
           $this->middleware = $middleware;
      }


      /**
       * @param array $middlewares
       * @return $this
      */
      public function middlewares(array $middlewares): RouteDispatcher
      {
          $this->middlewares = $middlewares;

          return $this;
      }


      /**
       * @param string $namespace
      * @return RouteDispatcher
      */
     public function namespace(string $namespace): RouteDispatcher
     {
        $this->namespace = rtrim($namespace, '\\') .'\\';

        return $this;
     }


      /**
       * @param Request $request
       * @return mixed
       * @throws ReflectionException|NotFoundException
       * @throws Exception
      */
      public function dispatch(Request $request)
      {
          if(! $this->router->getRoutes())
          {
              return $this->app->call(DefaultController::class, [], "index");
          }

          $route = $this->router->match($request->getMethod(), $uri = $request->getPath());

          if(! $route instanceof Route) {

              // dd("Route ". $uri . " not found!");
              throw new NotFoundException('Route '. $uri .' not found!', 404);
          }

          $params = $route->getMatches();
          $target = $route->getTarget();

          $request->setAttributes([
             '_routeName'    => $route->getName(),
             '_routeHandler' => $target,
             '_routeParams'  => $params
          ]);

          $this->app->instance(Request::class, $request);
          $this->app->instance('_currentRoute', $route);

          $this->middleware->middlewares($this->resolveMiddlewares($route));

          $respond = $this->call($target, $params);

          return $this->process($respond);
      }



      /**
       * @param $respond
       * @return JsonResponse|Response
      */
      protected function process($respond)
      {
          if(is_null($respond))
          {
              return new Response(null, 200);
          }

          if($respond instanceof Response)
          {
              return $respond;
          }

          if(is_array($respond))
          {
              return new JsonResponse($respond, 200);
          }

          if(is_string($respond))
          {
              return new Response($respond, 200);
          }

          // TODO reflect if need to place this here
          return new Response(null, 200);
      }


      /**
       * @param Route $route
       * @return array
       * @throws Exception
      */
      protected function resolveMiddlewares(Route $route): array
      {
          $middlewares = array_merge($route->getMiddleware(), $this->middlewares);

          return $this->resolve($middlewares);
      }


      /**
       * @param array $classMaps
       * @return array
       * @throws Exception
      */
      protected function resolve(array $classMaps): array
      {
          $resolved = [];

          foreach ($classMaps as $classMap)
          {
              $resolved[] = $this->app->get($classMap);
          }

          return $resolved;
      }


      /**
       * @param $target
       * @param $params
       * @return mixed
       * @throws ReflectionException
       * @throws Exception
      */
      protected function call($target, $params = [])
      {
          if($target instanceof \Closure)
          {
              return $this->app->call($target, $params);
          }

          if(is_string($target) && stripos($target, "@") !== false)
          {
              list($controller, $action) = explode("@", $target);

              $controller = sprintf('%s%s', $this->namespace, $controller);

              return $this->app->call($controller, $params, $action);
          }
      }
}