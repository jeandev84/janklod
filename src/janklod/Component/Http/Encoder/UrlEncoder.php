<?php
namespace Jan\Component\Http\Encoder;


/**
 * Class UrlEncoder
 * @package Jan\Component\Http\Encoder
*/
class UrlEncoder
{
     /**
      * @param $url
      * @return string
     */
     public static function encode($url)
     {
         return urlencode($url);
     }


     /**
      * @param $url
      * @return string
     */
     public static function decode($url)
     {
         return urldecode($url);
     }
}