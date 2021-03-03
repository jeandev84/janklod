<?php
namespace Jan\Component\Http\Helper;


/**
 * Class UrlEncoder
 *
 * @package Jan\Component\Http\Helper
*/
class UrlEncoder
{
     /**
      * @param $url
      * @return string
     */
     public static function encode($url): string
     {
         return urlencode($url);
     }


     /**
      * @param $url
      * @return string
     */
     public static function decode($url): string
     {
         return urldecode($url);
     }
}