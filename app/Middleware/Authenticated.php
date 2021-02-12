<?php
namespace App\Middleware;


use Jan\Component\Http\Middleware\Contract\MiddlewareInterface;
use Jan\Component\Http\Request;

/**
 * Class Authenticated
 * @package App\Middleware
*/
class Authenticated implements MiddlewareInterface
{

    public function __invoke(Request $request, callable $next)
    {
        echo "Authenticated:user<br>";
        return $next($request);
    }
}