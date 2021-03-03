<?php
namespace Jan\Component\Routing;




/**
 * Class RouteCollection
 *
 * @package Jan\Component\Routing
 */
class RouteCollection
{


    /**
     * @var bool
     */
    protected $isRouteGroup = false;



    /**
     * @var array
    */
    protected $groups = [];



    /**
     * @var array
     */
    protected $routes = [];



    /**
     * @var array
    */
    protected $resources = [];



    /**
     * @var array
    */
    protected $nameList = [];



//    /**
//     * @var array
//    */
//    protected $cruds = [];




    /**
     * @param Route $route
     * @return Route
    */
    public function add(Route $route): Route
    {
        $this->routes[] = $route;

        return $route;
    }




    /**
     * @param $controllerClass
     * @param $resourceContext
    */
    public function addResource($controllerClass, $resourceContext)
    {
         $this->resources[$controllerClass] = $resourceContext;
    }




    /**
     * @param $index
     * @param Route $route
    */
    public function addGroup($index, Route $route)
    {
        $this->groups[$index][] = $route;
    }



//    /**
//     * @param $entityClass
//     * @param $controllerClass
//    */
//    public function addCrud($entityClass, $controllerClass)
//    {
//        $this->cruds[$entityClass] = $controllerClass;
//    }



    /**
     * @return array
     */
    public function getNamedRoutes(): array
    {
        return Route::nameList();
    }



    /**
     * get route collection
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }



    /**
     * @return array
    */
    public function getGroups(): array
    {
        return $this->groups;
    }



    /**
     * @param string $index
     * @return array
    */
    public function getGroup(string $index): array
    {
        return $this->groups[$index] ?? [];
    }



    /**
     * @return array
     */
    public function getRoutesByMethod(): array
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
     * @param string $controllerClass
     * @return array|mixed
    */
    public function getResource(string $controllerClass): array
    {
        return $this->resources[$controllerClass] ?? [];
    }


//
//    /**
//     * @return array
//    */
//    public function getCrud(): array
//    {
//        return $this->cruds;
//    }
}