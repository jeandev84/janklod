<?php

namespace Jan\Component\Http\Bag;


class ServerBag extends ParameterBag
{

     /**
      * @return array
     */
     public function getHeaders()
     {
         $headers = [];

         foreach ($this->data as $key => $value)
         {
              if(strpos($key, 'HTTP_') === 0)
              {
                  $headers[substr($key, 5)] = $value;

              } elseif (\in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH', 'CONTENT_MD5'], true)) {
                   $headers[$key] = $value;
              }
         }


         return $headers;
     }
}