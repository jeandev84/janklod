<?php
namespace Jan\Foundation\Http;


use Exception;
use Jan\Component\Config\Config;
use Jan\Component\Http\Request;
use Jan\Component\Http\Response;
use Jan\Contract\Http\Kernel as HttpKernelContract;
use Jan\Foundation\Application;
use Jan\Foundation\Middleware\SessionStart;
use Jan\Foundation\Routing\Dispatcher\RouteDispatcher;


/**
 * Class Kernel
 *
 * TODO Refactoring (remove routeMiddlewares, and load from config)
 * @package Jan\Foundation\Http
*/
class Kernel implements HttpKernelContract
{

    /**
     * @var array
    */
    protected $middleware = [
        SessionStart::class
    ];



    /**
     * @var Application
     */
    protected $app;


    /**
     * Kernel constructor.
     * @param Application $app
     * @throws Exception
    */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    /**
     * @param Request $request
     * @return Response
     * @throws Exception
    */
    public function handle(Request $request): Response
    {
        $response = $this->getRouteDispatcher()->dispatch($request);
        $this->app->get('middleware')->handle($request);

        return $response;
    }


    /**
     * @return RouteDispatcher
     * @throws Exception
    */
    protected function getRouteDispatcher(): RouteDispatcher
    {
        $dispatcher = $this->app->get(RouteDispatcher::class);
        $config = $this->app->get(Config::class);

        $middlewares = array_merge($config->get('app.middlewares', []), $this->middleware);
        $dispatcher->middlewares($middlewares);

        return $dispatcher;
    }


    /**
     * @param Request $request
     * @param Response $response
     * @return mixed|void
     * @throws Exception
    */
    public function terminate(Request $request, Response $response)
    {
         $this->app->terminate($request, $response);
    }
}