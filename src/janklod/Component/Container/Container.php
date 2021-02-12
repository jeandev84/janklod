<?php
declare(strict_types=1);

namespace Jan\Component\Container;


use Closure;
use Exception;
use Jan\Component\Container\Contract\ContainerInterface;
use Jan\Component\Container\Contract\UsableContainer;
use Jan\Component\Container\Exception\BindingResolutionException;
use Jan\Component\Container\Facade\Facade;
use Jan\Component\Container\ServiceProvider\Contract\BootableServiceProvider;
use Jan\Component\Container\ServiceProvider\ServiceProvider;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;


/**
 * Class Container
 *
 * DependencyInjection
 * @package Jan\Component\Container
*/
class Container implements \ArrayAccess, ContainerInterface
{

    /**
     * @var Container
    */
    protected static $instance;


    /**
     * @var array
     */
    protected $resolved = [];


    /**
     * @var array
    */
    protected $bindings = [];



    /**
     * @var array
    */
    protected $instances = [];



    /**
     * @var array
    */
    protected $aliases = [];



    /**
     * @var array
    */
    protected $serviceProviders = [];



    /**
     * @var array
    */
    protected $facades = [];



    /**
     * @param string $abstract
     * @param null $concrete
     * @param bool $shared
     * @return Container
    */
    public function bind(string $abstract, $concrete = null, bool $shared = false): Container
    {
        if(is_null($concrete))
        {
            $concrete = $abstract;
        }

        $this->bindings[$abstract] = compact('concrete', 'shared');

        return $this;
    }



    /**
     * @param $abstract
     * @return bool
    */
    public function resolved($abstract): bool
    {
        return isset($this->resolved[$abstract]);
    }


    /**
     * @param $abstract
     * @return mixed
    */
    public function getResolved($abstract)
    {
        return $this->resolved[$abstract];
    }


    /**
     * Determine if the given param is bind
     *
     * @param string $id
     * @return bool
    */
    public function bound(string $id): bool
    {
        return isset($this->bindings[$id])
               || isset($this->instances[$id])
               || $this->isAlias($id);
    }


    /**
     * Determine if the given param is alias
     *
     * @param $abstract
     * @return bool
    */
    public function isAlias($abstract): bool
    {
        return isset($this->aliases[$abstract]);
    }


    /**
     * Bind singleton param
     *
     * @param $abstract
     * @param $concrete
    */
    public function singleton($abstract, $concrete = null)
    {
        $this->bind($abstract, $concrete, true);
    }


    /**
     * set aliases
     *
     * @param $abstract [ name of alias ]
     * @param $alias
     * @return Container
    */
    public function alias($abstract, $alias): Container
    {
         /*
         if(isset($this->aliases[$abstract]))
         {
              throw new BindingResolutionException("This alias [$abstract] already taken!");
         }
         */

         $this->aliases[$abstract] = $alias;

         return $this;
    }


    /**
     * Create new instance of object wit given params
     *
     * @param $abstract
     * @param array $parameters
     * @return BindingResolutionException|mixed|object
     * @throws BindingResolutionException
     * @throws ReflectionException
    */
    public function make($abstract, $parameters = [])
    {
        return $this->resolve($abstract, $parameters);
    }


    /**
     * make factory
     *
     * @param $abstract
     * @return BindingResolutionException|mixed|object
     * @throws BindingResolutionException
     * @throws ReflectionException
    */
    public function factory($abstract)
    {
        return $this->make($abstract);
    }


    /**
     * Add facade
     *
     * @param Facade|string $facade
     * @return Container
     * @throws Exception
    */
    public function registerFacade($facade)
    {
        if(\is_string($facade))
        {
            $facadeObject = $this->get($facade);
        }

        if(! $facadeObject instanceof Facade)
        {
            throw new Exception('Cannot map this facade : '. get_class($facade));
        }

        // $this->callAction($facade, "setContainer", [$this]);
        call_user_func([$facadeObject, "setContainer"], $this);
        $this->facades[] = $facadeObject;
        return $this;
    }



    /**
     * Determine if the given param is singleton
     *
     * @param $abstract
     * @return bool
    */
    public function isShared($abstract): bool
    {
        return isset($this->instances[$abstract]) || $this->onlyShared($abstract);
    }


    /**
     * @param $abstract
     * @param $instance
     * @return Container
    */
    public function instance($abstract, $instance): Container
    {
        $this->instances[$abstract] = $instance;

        return $this;
    }




    /**
     * Get alias
     *
     * @param $abstract
     * @return mixed
    */
    public function getAlias($abstract)
    {
        if($this->isAlias($abstract))
        {
            return $this->aliases[$abstract];
        }

        return $abstract;
    }


    /**
     * Get bindings params
     *
     * @return array
    */
    public function getBindings(): array
    {
        return $this->bindings;
    }


    /**
     * @param $abstract
     * @return mixed
    */
    public function getConcrete($abstract)
    {
        if (isset($this->bindings[$abstract]))
        {
            return $this->bindings[$abstract]['concrete'];
        }

        return $abstract;
    }


    /**
     * @return array
    */
    public function getInstances(): array
    {
        return $this->instances;
    }


    /**
     * @param string $id
     * @return Closure|false|mixed
     * @throws Exception
    */
    public function get(string $id)
    {
        try {

           return $this->resolve($id);

        } catch (Exception $e) {

             if($this->has($id))
             {
                 throw $e;
             }

             throw new Exception('Entry '. $id .' not found', $e->getCode(), $e);
        }
    }


    /**
     * @param Closure|string $abstract
     * @param array $params
     * @param string|null $method
     * @return mixed
     * @throws ReflectionException
    */
    public function call($abstract, array $params = [], ?string $method = null)
    {
         if($abstract instanceof Closure)
         {
             return $this->closure($abstract, $params);
         }

         if(is_string($abstract) && ! is_null($method))
         {
             return $this->callAction($abstract, $method, $params);
         }

         return false;
    }


    /**
     * @param $abstract
     * @param string $method
     * @param array $params
     * @return false|mixed
     * @throws ReflectionException
     * @throws Exception
    */
    public function callAction($abstract, $method, $params = [], $methodBefore = "setContainer")
    {
        $objectClass = $this->get($abstract);

        $reflectedMethod = new ReflectionMethod($abstract, $method);
        $arguments = $this->resolveDependencies($reflectedMethod->getParameters(), $params);

        if(! method_exists($objectClass, $method))
        {
            throw new Exception(sprintf('Cannot call class %s and method %s', $abstract, $method));
        }

        if(method_exists($objectClass, $methodBefore))
        {
             call_user_func([$objectClass, $methodBefore], $this);
        }

        return call_user_func_array([$objectClass, $method], $arguments);
    }



    /**
     * @param $abstract
     * @param string $method
     * @param array $params
     * @return false|mixed
     * @throws Exception
    */
    public function calls($abstract, $methods = [])
    {
         foreach ($methods as $method)
         {
              $this->callAction($abstract, $method);
         }
    }


    /**
     * @param array $providers
     * @throws Exception
    */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider)
        {
            $this->addProvider($provider);
        }
    }


    /**
     * @param ServiceProvider|string $provider
     * @return Container
     * @throws Exception
    */
    public function addProvider($provider): Container
    {
        $provider = $this->resolvedServiceProvider($provider);

        $provider->setContainer($this);

        if(! \in_array($provider, $this->serviceProviders))
        {
            if($this->isBooted($provider))
            {
                $this->bootServiceProvider($provider);
            }

            $provider->register();

            $this->serviceProviders[] = $provider;
        }

        return $this;
    }


    /**
     * run bootable service provider
     *
     * @param ServiceProvider $provider
    */
    protected function bootServiceProvider(ServiceProvider $provider)
    {
        if(method_exists($provider, 'boot'))
        {
            $provider->boot();
        }
    }


    /**
     * @param ServiceProvider $provider
     * @return bool
    */
    protected function isBooted(ServiceProvider $provider): bool
    {
        $implements = class_implements($provider);

        return isset($implements[BootableServiceProvider::class]);
    }


    /**
     * @param $provider
     * @return ServiceProvider|null
     * @throws Exception
    */
    protected function resolvedServiceProvider($provider): ?ServiceProvider
    {
        if(\is_string($provider))
        {
            $provider = $this->get($provider);
        }

        if(! $provider instanceof ServiceProvider)
        {
            throw new Exception("Provider must be instance of ServiceProvider!");
        }

        return $provider;
    }



    /**
     * @param string $abstract
     * @param array $params
     * @return BindingResolutionException|mixed|object
     * @throws BindingResolutionException
     * @throws ReflectionException
    */
    protected function resolve(string $abstract, array $params = [])
    {
         // get alias
         $abstract = $this->getAlias($abstract);

         // get concrete
         $concrete = $this->getConcrete($abstract);

         if($this->buildable($concrete))
         {
             $concrete = $this->build($concrete, $params);
         }

         // get singleton or instantiated abstract
         if($this->isShared($abstract))
         {
             return $this->resolveInstance($abstract, $concrete);
         }

         $this->resolved[$abstract] = true;

         return $concrete;
    }


    /**
     * @param $concrete
     * @param array $withParams
     * @return BindingResolutionException|object
     * @throws BindingResolutionException|ReflectionException
     */
      protected function build($concrete, array $withParams = [])
      {
            if($concrete instanceof Closure)
            {
                return $this->closure($concrete, $withParams);
            }

            return $this->makeInstance($concrete, $withParams);
      }


     /**
      * Get shared abstract
      *
      * @param $abstract
      * @param $concrete
      * @return mixed
     */
     protected function resolveInstance($abstract, $concrete)
     {
        if(! isset($this->instances[$abstract]))
        {
            $this->instances[$abstract] = $concrete;
        }

        return $this->instances[$abstract];
     }


    /**
     * resolve dependencies
     * @param array $dependencies
     * @param array $withParams
     * @return array
     * @throws Exception
   */
    protected function resolveDependencies(array $dependencies, array $withParams = []): array
    {
        $resolvedDependencies = [];

        foreach ($dependencies as $parameter)
        {
             $dependency = $parameter->getClass();

             if($parameter->isOptional()) { continue; }
             if($parameter->isArray()) { continue; }

             if(is_null($dependency))
             {
                 if ($parameter->isDefaultValueAvailable()) {

                     $resolvedDependencies[] = $parameter->getDefaultValue();

                 } else {

                     if (array_key_exists($parameter->getName(), $withParams)) {
                         $resolvedDependencies[] = $withParams[$parameter->getName()];
                     } else {
                         $resolvedDependencies = array_merge($resolvedDependencies, $withParams);
                     }
                 }

             } else {

                 $resolvedDependencies[] = $this->get($dependency->getName());
             }
        }

        return $resolvedDependencies;
    }



    /**
     * @param $concrete
     * @return bool
    */
    protected function buildable($concrete): bool
    {
        return $concrete instanceof Closure || (is_string($concrete) && class_exists($concrete));
    }


    /**
     * @param $concrete
     * @param array $withParams
     * @return BindingResolutionException|object
     * @throws BindingResolutionException
     * @throws ReflectionException
     * @throws Exception
     */
    protected function makeInstance($concrete, array $withParams = [])
    {
        try {

            $reflector = new ReflectionClass($concrete);

        } catch (ReflectionException $e) {

            throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
        }

        if(! $reflector->isInstantiable())
        {
            return new BindingResolutionException('not instantiable!');
        }

        $constructor = $reflector->getConstructor();

        if(is_null($constructor))
        {
            return $reflector->newInstance();
        }

        $dependencies = $this->resolveDependencies($constructor->getParameters(), $withParams);

        return $reflector->newInstanceArgs($dependencies);
    }


    /**
     * @param callable $concrete
     * @param array $withParams
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
    */
    protected function closure(callable $concrete, array $withParams = [])
    {
        try {

            $reflectedFunction = new ReflectionFunction($concrete);

        } catch (ReflectionException $e) {

            throw $e;
        }

        $dependencyParams = $this->resolveDependencies($reflectedFunction->getParameters(), $withParams);

        return $concrete(...$dependencyParams);
    }


    /**
     * @param $abstract
     * @return bool
    */
    protected function onlyShared($abstract): bool
    {
        return isset($this->bindings[$abstract]['shared']) && $this->bindings[$abstract]['shared'] === true;
    }


    /**
     * Determine
     * @param string $id
     * @return mixed|void
    */
    public function has(string $id): bool
    {
        return $this->bound($id);
    }


    /**
     * Flush the container of all bindings and resolved instances.
     *
     * @return void
    */
    public function flush()
    {
        $this->aliases = [];
        $this->resolved = [];
        $this->bindings = [];
        $this->instances = [];
    }


    /**
     * @return Container
     */
    public static function getInstance(): Container
    {
        if(! static::$instance)
        {
            static::$instance = new static();
        }

        return static::$instance;
    }


    /**
     * @param ContainerInterface|null $container
     * @return ContainerInterface
     */
    public static function setInstance(ContainerInterface $container = null): ?ContainerInterface
    {
        return static::$instance = $container;
    }


    /**
     * @param mixed $id
     * @return bool
    */
    public function offsetExists($id): bool
    {
         return $this->has($id);
    }


    /**
     * @param mixed $id
     * @return mixed
     * @throws Exception
    */
    public function offsetGet($id)
    {
         return $this->get($id);
    }


    /**
     * @param mixed $id
     * @param mixed $value
    */
    public function offsetSet($id, $value)
    {
         $this->bind($id, $value);
    }


    /**
     * @param mixed $id
    */
    public function offsetUnset($id)
    {
        unset(
            $this->bindings[$id],
            $this->instances[$id],
            $this->resolved[$id]
        );
    }


    /**
     * @param $name
     * @return array|bool|mixed|object|string|null
    */
    public function __get($name)
    {
        return $this[$name];
    }


    /**
     * @param $name
     * @param $value
    */
    public function __set($name, $value)
    {
        $this[$name] = $value;
    }
}