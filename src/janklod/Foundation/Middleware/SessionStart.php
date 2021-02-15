<?php
namespace Jan\Foundation\Middleware;


use Jan\Component\Http\Middleware\Contract\MiddlewareInterface;
use Jan\Component\Http\Request;


/**
 * Class SessionStart
 * @package Jan\Foundation\Middlewares
*/
class SessionStart implements MiddlewareInterface
{


    /**
     * @param Request $request
     * @param callable $next
     * @return mixed
    */
    public function __invoke(Request $request, callable $next)
    {
         echo "Session:started!<br>";
         return $next($request);
    }
}