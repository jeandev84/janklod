<?php
namespace Jan\Foundation\Middleware;


use Jan\Component\Http\Middleware\Contract\MiddlewareInterface;
use Jan\Component\Http\Request;


/**
 * Class Authenticated
 * @package Jan\Foundation\Middlewares
 */
class FooMiddleware implements MiddlewareInterface
{

    /**
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function __invoke(Request $request, callable $next)
    {
        // echo 'Foo:middleware, ';
        return $next($request);
    }
}