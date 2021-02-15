<?php
namespace Jan\Contract\Http;


use Jan\Component\Http\Request;
use Jan\Component\Http\Response;


/**
 * Interface Kernel
 *
 * @package Jan\Contract\Http
*/
interface Kernel
{

    /**
     * @param Request $request
     * @return Response
    */
    public function handle(Request $request): Response;


    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
    */
    public function terminate(Request $request, Response $response);
}