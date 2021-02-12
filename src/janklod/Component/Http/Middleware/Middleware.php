<?php
namespace Jan\Component\Http\Middleware;


use Closure;
use Jan\Component\Http\Request;
use Jan\Component\Http\Middleware\Contract\MiddlewareInterface;



/**
 * Class Middleware stack
 *
 * Middleware is a face control between request and response
 * Request | Middleware | Response
 *
 * @package Jan\Component\Http\Middleware
 */
class Middleware
{

    /**
     * @var Closure
    */
    protected $start;




    /**
     * MiddlewareStack constructor.
    */
    public function __construct()
    {
        $this->start = function (Request $request) {
            return '';
        };
    }


    /**
     * @param MiddlewareInterface $middleware
     * @return Middleware
    */
    public function add(MiddlewareInterface $middleware): Middleware
    {
        $next = $this->start;

        $this->start = function (Request $request) use ($middleware, $next) {
            return $middleware->__invoke($request, $next);
        };

        return $this;
    }


    /**
     * @param array $middlewares
     * @return Middleware
    */
    public function middlewares(array $middlewares): Middleware
    {
        foreach ($middlewares as $middleware)
        {
            $this->add($middleware);
        }

        return $this;
    }



    /**
     * Run all middlewares
     * @param Request $request
     * @return mixed
    */
    public function handle(Request $request)
    {
        //dd($request);
        return call_user_func($this->start, $request);
    }
}

/*
$middleware = new Middleware();
$middleware->add(new AuthenticateMiddleware());
$middleware->add(new NoUserMiddleware());
$middleware->handle();
*/