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
class Router  extends RouteCollection implements RouterInterface
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
     * @var bool
    */
    protected $isRouteGroup = false;




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
     * Router constructor.
     * @param
    */
    public function __construct(string $baseUrl = '')
    {
         if ($baseUrl) {
             $this->setBaseURL($baseUrl);
         }
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
             parent::add($route);
        }
    }



    /**
     * @param Route $route
     * @return Route
    */
    public function add(Route $route): Route
    {
         if($this->isRouteGroup === true) {
             if($prefix = $this->getOption(static::OPTION_PARAM_PATH_PREFIX)) {
                 $this->addGroup($prefix, $route);
             }
         }

         return parent::add($route);
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
        $middleware = $this->getMiddlewares();
        $prefixName = $this->getPrefixName();


        $route = new Route($methods, $path, $target);
        $route->where($this->patterns);
        $route->setPrefixName($prefixName);
        $route->middleware($middleware);
        $route->addOptions($this->routeOptions());

        if($name) {
            $route->name($name);
        }

        return $this->add($route);
    }
    

    /**
     * @param string $requestMethod
     * @param string $requestUri
     * @return Route|bool
    */
    public function match(string $requestMethod, string $requestUri)
    {
        foreach ($this->getRoutes() as $route) {

            /** @var Route $route */
            if($route instanceof Route) {
                if($route->match($requestMethod, $requestUri)) {
                    return $route;
                }
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
     * @param string $path
     * @param $target
     * @param string|null $name
     * @return Route
    */
    public function any(string $path, $target, string $name = null): Route
    {
        return $this->map('GET|POST|PUT|DELETE', $path, $target, $name);
    }



    /**
     * @param Closure $routeCallback
     * @param array $options
    */
    public function group(Closure $routeCallback, array $options = [])
    {
         if(! isset($options[self::OPTION_PARAM_PATH_PREFIX])) {
             $options[self::OPTION_PARAM_PATH_PREFIX] = '/';
         }

         if($options) {
             $this->setOptions($options);
         }

         $this->isRouteGroup = true;
         $routeCallback($this);
         $this->flushOptions();
    }



    /**
     * @param string $pathPrefix
     * @param string $controllerClass
     * @return Router
    */
    public function resource(string $pathPrefix, string $controllerClass): Router
    {
        $resourceItems = [];
        $resourceComponents = RouteStorage::makeResourceComponents($pathPrefix, $controllerClass);

        $templateDir = $this->resolvePath($pathPrefix);

        foreach ($resourceComponents as $components) {

            list($methods, $path, $action, $name) = $components;
            $this->map($methods, $path , $controllerClass .'@'.  $action, $name);
            $resourceItems['resources'][$action]  = $templateDir . '/'. $action. '.php';
        }

        $resourceItems['partials'][] = $templateDir . '/_form.php';
        $resourceItems['resource'] = $templateDir;

        $this->addResource($this->resolveTarget($controllerClass), $resourceItems);

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
         if(! isset($options[self::OPTION_PARAM_PATH_PREFIX]))
         {
             $options[self::OPTION_PARAM_PATH_PREFIX] = 'api';
         }

         /*
         $options = [
             self::OPTION_PARAM_PATH_PREFIX => $options[self::OPTION_PARAM_PATH_PREFIX] ?? 'api'
         ];
         */

         if(! $closure)
         {
             $this->setOptions($options);

             return $this;
         }

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
        $path = Route::generate($name, $params);

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
        if(is_string($methods)) {
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
        if($prefix = $this->getPrefixPath()) {
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
        if(\is_string($target) && $namespace = $this->getNamespace()) {
            $target = rtrim(ucfirst($namespace), '\\') .'\\' . $target;
        }

        return $target;
    }


    /**
     * @param $name
     * @return string
    */
    protected function resolveName($name): string
    {
        if($prefixed = $this->getPrefixName()) {
            return $prefixed . $name;
        }

        return $name;
    }



    /**
     * @return mixed|void|null
    */
    protected function getPrefixPath()
    {
        return $this->getOption(static::OPTION_PARAM_PATH_PREFIX);
    }



    /**
     * @return mixed|void|null
    */
    protected function getNamespace()
    {
        return $this->getOption(static::OPTION_PARAM_NAMESPACE);
    }


    /**
     * @return mixed|void|null
     */
    protected function getMiddlewares()
    {
        return $this->getOption(static::OPTION_PARAM_MIDDLEWARE, []);
    }



    /**
     * @return mixed|void|null
    */
    protected function getPrefixName()
    {
        return $this->getOption(static::OPTION_PARAM_NAME_PREFIX, '');
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
            if(! $this->isValidOption($indexOption)) {
                 $this->abortIf(
                     sprintf('(%s) is not available this param', $indexOption)
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
     * @param int $code
    */
    protected function abortIf($message = 'not valid!', $code = 404)
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
        return \in_array($indexOption, $this->getAvailableOptionParams());
    }



    /**
     * @return array
    */
    protected function getGroupOptions(): array
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
    protected function getAvailableOptionParams(): array
    {
        return [
            self::OPTION_PARAM_PATH_PREFIX,
            self::OPTION_PARAM_NAMESPACE,
            self::OPTION_PARAM_MIDDLEWARE,
            self::OPTION_PARAM_NAME_PREFIX
        ];
    }


    /**
     * @return array
    */
    protected function getRouteOptions(): array
    {
        return [
            self::KEY_OPTION_PARAM_PATH_PREFIX => $this->getOption(self::OPTION_PARAM_PATH_PREFIX),
            self::KEY_OPTION_PARAM_NAME_PREFIX => $this->getOption(self::OPTION_PARAM_NAME_PREFIX),
            self::KEY_OPTION_PARAM_NAMESPACE   => $this->getOption(self::OPTION_PARAM_NAMESPACE)
        ];
    }
    
    

    /**
     * @return string[]
    */
    protected function routeOptions(): array
    {
        $parameters = [];

        foreach ($this->getRouteOptions() as $key => $value)
        {
            $parameters[$key] = (string) $value;
        }

        return $parameters;
    }
}