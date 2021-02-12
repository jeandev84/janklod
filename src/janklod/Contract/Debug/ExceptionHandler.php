<?php
namespace Jan\Contract\Debug;


use Exception;


/**
 * Interface ExceptionHandler
 * @package Jan\Contract\Debug
*/
interface ExceptionHandler
{
    /**
     * @param Exception $e
     * @return mixed
    */
    public function logError(Exception $e);
}