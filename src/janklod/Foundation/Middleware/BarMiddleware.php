<?php
namespace Jan\Foundation\Middleware;


use Jan\Component\Http\Middleware\Contract\MiddlewareInterface;
use Jan\Component\Http\Request;


/**
 * Class BarMiddleware
 * @package Jan\Foundation\Middlewares
 */
class BarMiddleware implements MiddlewareInterface
{

    /**
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function __invoke(Request $request, callable $next)
    {
        //echo 'Bar:middleware, ';
        return $next($request);
    }
}