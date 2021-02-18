<?php
namespace Jan\Component\Routing;


use Closure;
use Exception;
use Jan\Component\Routing\Contract\RouterInterface;
use Jan\Component\Routing\Exception\RouterException;
use Jan\Component\Routing\Traits\UrlGeneratorTrait;


/**
 * Class Router
 * @package Jan\Component\Routing
*/
class Router implements RouterInterface
{

    use UrlGeneratorTrait;

    const KEY_OPTION_PARAM_PATH_PREFIX  = 'path.prefix';
    const KEY_OPTION_PARAM_NAMESPACE    = 'namespace';
    const KEY_OPTION_PARAM_NAME_PREFIX  = 'name.prefix';

    const OPTION_PARAM_PATH_PREFIX      = 'prefix';
    const OPTION_PARAM_NAMESPACE        = 'namespace';
    const OPTION_PARAM_MIDDLEWARE       = 'middleware';
    const OPTION_PARAM_NAME_PREFIX      = 'name';



    /**
     * @var RouteCollection
    */
    protected $routeCollection;



    /**
     * route patterns
     *
     * @var array
    */
    protected $patterns = [];




    /**
     * @var array
    */
    protected $options = [];



    /**
     * @var array
    */
    protected $resources = [];


    /**
     * Router constructor.
     *
     * @param RouteCollection|null $routeCollection
     */
    public function __construct(RouteCollection $routeCollection = null)
    {
         if(! $routeCollection) {
             $routeCollection = new RouteCollection();
         }

         $this->routeCollection = $routeCollection;
    }




    /**
     * set routes
     *
     * @param array $routes
     * @return Router
    */
    public function setRoutes(array $routes): Router
    {
        /** @var Route $route */
        foreach ($routes as $route)
        {
            $this->add($route);
        }

        return $this;
    }


    /**
     * @param Route $route
     * @return Router
    */
    public function add(Route $route): Router
    {
         $this->routeCollection->add($route);

         return $this;
    }



    /**
     * get route collection
     *
     * @return array
    */
    public function getRoutes(): array
    {
        return $this->routeCollection->getRoutes();
    }


    /**
     * @return array
    */
    public function getGroupRoutes(): array
    {
         $routes = [];

         foreach ($this->getRoutes() as $route)
         {
             /** @var Route $route */
             $routes[$route->getMethodsToString()][] = $route;
         }

         return $routes;
    }



    /**
     * @return array
    */
    public function getResources(): array
    {
        return $this->resources;
    }



    /**
     * @param string $controller
     * @return array|mixed
    */
    public function getResource(string $controller): array
    {
        return $this->resources[$controller] ?? [];
    }



    /**
     * @param array|string $methods
     * @param string $path
     * @param $target
     * @param string|null $name
     * @return Route
    */
    public function map($methods, string $path, $target, string $name = null): Route
    {
        /* resolve given params */
        $methods    = $this->resolveMethods($methods);
        $path       = $this->resolvePath($path);
        $target     = $this->resolveTarget($target);
        $middleware = $this->getOption(static::OPTION_PARAM_MIDDLEWARE, []);
        $prefixName = $this->getOption(static::OPTION_PARAM_NAME_PREFIX, '');


        /* create new instance of route */
        $route = new Route($methods, $path, $target, $prefixName);


        /* set middleware */
        $route->middleware($middleware);


        /* set options */
        $route->addOptions($this->routeOptionParameters());


        /* set name */
        if($name) {
            $route->name($name);
        }


        /* set globals patterns */
        $route->where($this->patterns);


        /* add route */
        $this->add($route);


        /* return current route */
        return $route;
    }



    /**
     * @param string $requestMethod
     * @param string $requestUri
     * @return Route|bool
    */
    public function match(string $requestMethod, string $requestUri)
    {
        foreach ($this->getRoutes() as $route)
        {
            if($route->match($requestMethod, $requestUri))
            {
                return $route;
            }
        }

        return false;
    }



    /**
     * @param string $path
     * @param $target
     * @param string|null $name
     * @return Route
    */
    public function get(string $path, $target, string $name = null): Route
    {
        return $this->map(['GET'], $path, $target, $name);
    }


    /**
     * @param string $path
     * @param $target
     * @param string|null $name
     * @return Route
     */
    public function post(string $path, $target, string $name = null): Route
    {
        return $this->map(['POST'], $path, $target, $name);
    }


    /**
     * @param string $path
     * @param $target
     * @param string|null $name
     * @return Route
    */
    public function put(string $path, $target, string $name = null): Route
    {
        return $this->map(['PUT'], $path, $target, $name);
    }


    /**
     * @param string $path
     * @param $target
     * @param string|null $name
     * @return Route
    */
    public function delete(string $path, $target, string $name = null): Route
    {
        return $this->map(['DELETE'], $path, $target, $name);
    }


    /**
     * @param Closure $routeCallback
     * @param array $options
    */
    public function group(Closure $routeCallback, array $options = [])
    {
         if($options)
         {
             $this->setOptions($options);
         }

         $routeCallback($this);

         $this->flushOptions();
    }


    /**
     * @param string $path
     * @param string $controller
     * @return Router
    */
    public function resource(string $path, string $controller): Router
    {
         $prefixName = trim($path, '/') . '.';

         $resources = [
             'GET' => [
                ['', 'index', 'list'],
                ['{id}', 'show', 'show'],
                ['{id}/restore', 'restore', 'restore'],
             ],
             'GET|POST' => [
                ['new', 'edit', 'new'],
                ['{id}/edit', 'edit', 'edit'],
             ],
             'DELETE' => [
                ['{id}/delete', 'delete', 'delete'],
             ]
         ];


         $resourceActions = ['index', 'show', 'restore', 'new', 'edit', 'delete'];

         foreach ($resources as $methods => $routes)
         {
             foreach ($routes as $routeItems)
             {
                 list($pathSuffix, $action, $name) = $routeItems;
                 $this->map($methods, $path. '/'. $pathSuffix, $controller .'@'. $action, $prefixName.$name);
             }
         }

         $this->resources[$controller] = $resourceActions;

         return $this;
    }



    /**
     * @param $name
     * @param $regex
     * @return Router
     *
     * Example:
     * $router = new Router();
     * $router->pattern('id', '[0-9]+');
     * $router->pattern(['id' => '[0-9]+']);
    */
    public function pattern($name, $regex = null): Router
    {
        $patterns = is_array($name) ? $name : [$name => $regex];

        $this->patterns = array_merge($this->patterns, $patterns);

        return $this;
    }


    /**
     * @param string $name
     * @return $this
    */
    public function name(string $name): Router
    {
        $this->setOptions(compact('name'));

        return $this;
    }


    /**
     * @param array $middleware
     * @return $this
     */
    public function middleware(array $middleware): Router
    {
        $this->setOptions(compact('middleware'));

        return $this;
    }


    /**
     * @param $prefix
     * @return Router
    */
    public function prefix($prefix): Router
    {
        $this->setOptions(compact('prefix'));

        return $this;
    }


    /**
     * @param $namespace
     * @return Router
     */
    public function namespace($namespace): Router
    {
        $this->setOptions(compact('namespace'));

        return $this;
    }


    /**
     * @param Closure|null $closure
     * @param array $options
     * @return Router
     */
    public function api(Closure $closure = null, array $options = []): Router
    {
         $options = [
             self::OPTION_PARAM_PATH_PREFIX => $options[self::OPTION_PARAM_PATH_PREFIX] ?? 'api'
         ];

         if(! $closure)
         {
             $this->setOptions($options);

             return $this;
         }

         // api/posts/list   GET     read
         // api/post/{id}    GET     show
         // api/post/create  POST    create
         // api/post/{id}    PUT     update
         // api/post/{id}    DELETE  delete

         $this->group($closure, $options);
    }



    /**
     * Generate URL
     *
     * @param string $name
     * @param array $params
     * @return mixed
     * @throws Exception
    */
    public function generate(string $name, array $params = []): string
    {
        $path = RouteCollection::generate($name, $params);

        if(! $path)
        {
            throw new RouterException(
                sprintf('name (%s) is not valid for generate path ', $name)
            );
        }

        return $this->generateUrl($path);
    }



    /**
     * @param array $options
    */
    protected function setOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }


    /**
     * remove all options options
     *
     * @return void
    */
    protected function flushOptions()
    {
         $this->options = [];
    }




    /**
     * resolve methods
     *
     * @param $methods
     * @return array
    */
    protected function resolveMethods($methods): array
    {
        if(is_string($methods))
        {
            $methods = explode('|', $methods);
        }

        return (array) $methods;
    }



    /**
     * Resolve route path
     *
     * @param string $path
     * @return string
    */
    protected function resolvePath(string $path): string
    {
        if($prefix = $this->getOption(static::OPTION_PARAM_PATH_PREFIX))
        {
            $path = rtrim($prefix, '/') . '/'. ltrim($path, '/');
        }

        return $path;
    }


    /**
     * Resolve handle
     *
     * @param $target
     * @return string
    */
    protected function resolveTarget($target): string
    {
        if(\is_string($target) && $namespace = $this->getOption(static::OPTION_PARAM_NAMESPACE))
        {
            $target = rtrim($namespace, '\\') .'\\' . $target;
        }

        return $target;
    }


    /**
     * @param $name
     * @return string
    */
    protected function resolveName($name): string
    {
        if($prefixed = $this->getOption(static::OPTION_PARAM_NAME_PREFIX))
        {
            return $prefixed . $name;
        }

        return $name;
    }


    /**
     * Get option by given param
     *
     * @param $key
     * @param null $default
     * @return mixed|void|null
    */
    protected function getOption($key, $default = null)
    {
        foreach (array_keys($this->options) as $indexOption)
        {
            if(! $this->isValidOption($indexOption))
            {
                 $this->abortIf(
                     sprintf('%s is not available this param', $indexOption)
                 );
            }
        }

        return $this->options[$key] ?? $default;
    }


    /**
     * @param $key
    */
    protected function removeOption($key)
    {
        unset($this->options[$key]);
    }


    /**
     * @param string $message
    */
    protected function abortIf($message = 'not valid!')
    {
        return (function() use ($message) {
            throw new \RuntimeException($message);
        })();
    }


    /**
     * @param $indexOption
     * @return bool
    */
    protected function isValidOption($indexOption): bool
    {
        return \in_array($indexOption, $this->getAllowedOptionParams());
    }


    /**
     * @return string[]
    */
    protected function getAllowedOptionParams(): array
    {
        return [
            self::OPTION_PARAM_PATH_PREFIX,
            self::OPTION_PARAM_NAMESPACE,
            self::OPTION_PARAM_MIDDLEWARE,
            self::OPTION_PARAM_NAME_PREFIX
        ];
    }

    /**
     * @return string[]
    */
    protected function routeOptionParameters(): array
    {
        return $this->resolvedRouteOptionParameters([
            self::KEY_OPTION_PARAM_PATH_PREFIX => $this->getOption(self::OPTION_PARAM_PATH_PREFIX),
            self::KEY_OPTION_PARAM_NAME_PREFIX => $this->getOption(self::OPTION_PARAM_NAME_PREFIX),
            self::KEY_OPTION_PARAM_NAMESPACE   => $this->getOption(self::OPTION_PARAM_NAMESPACE)
        ]);
    }



    /**
     * @param array $routeOptions
     * @return array
    */
    protected function resolvedRouteOptionParameters(array $routeOptions): array
    {
        $parameters = [];

        foreach ($routeOptions as $key => $value)
        {
            $parameters[$key] = (string) $value;
        }

        return $parameters;
    }
    
}