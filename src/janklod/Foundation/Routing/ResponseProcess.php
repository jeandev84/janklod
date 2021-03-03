<?php
namespace Jan\Foundation\Routing;


use Jan\Component\Http\JsonResponse;
use Jan\Component\Http\Response;

/**
 * Class ResponseProcess
 * @package Jan\Foundation\Routing
*/
class ResponseProcess
{

     /**
      * @var mixed
     */
     protected $respond;


     /**
      * ResponseProcess constructor.
      * @param $respond
     */
     public function __construct($respond)
     {
         $this->respond = $respond;
     }


     /**
      * @return JsonResponse|Response|mixed
     */
     public function response()
     {
         if(is_null($this->respond))
         {
             return new Response(null, 200);
         }

         if($this->respond instanceof Response)
         {
             return $this->respond;
         }

         if(is_array($this->respond))
         {
             return new JsonResponse($this->respond, 200);
         }

         if(is_string($this->respond))
         {
             return new Response($this->respond, 200);
         }

         // TODO reflect if need to place this here
         return new Response(null, 200);
     }
}