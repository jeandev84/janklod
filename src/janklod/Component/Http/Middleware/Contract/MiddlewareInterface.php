<?php
namespace Jan\Component\Http\Middleware\Contract;


use Jan\Component\Http\Request;
use Jan\Component\Http\RequestInterface;


/**
 * Class MiddlewareInterface < beetwen request and response >
 * @package Jan\Component\Http\Middleware\Contract
*/
interface MiddlewareInterface
{
     /**
      * @param Request $request
      * @param callable $next
     */
     public function __invoke(Request $request, callable $next);
}