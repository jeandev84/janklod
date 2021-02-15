<?php
namespace Jan\Foundation\Exception;


use Throwable;

/**
 * Class NotFoundRoute
 * @package Jan\Foundation\Exception
*/
class NotFoundException extends \Exception
{
   public function __construct($message = "", $code = 0, Throwable $previous = null)
   {
       parent::__construct($message, $code, $previous);
   }
}