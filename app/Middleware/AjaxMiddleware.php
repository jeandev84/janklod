<?php
namespace App\Middleware;


use Jan\Component\Http\Middleware\Contract\MiddlewareInterface;
use Jan\Component\Http\Request;

/**
 * Class AjaxMiddleware
 * @package App\Middleware
*/
class AjaxMiddleware implements MiddlewareInterface
{

    public function __invoke(Request $request, callable $next)
    {
         echo "AjaxMiddleware<br>";
         return $next($request);
    }
}