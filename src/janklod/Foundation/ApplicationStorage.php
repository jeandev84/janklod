<?php
namespace Jan\Foundation;


use Jan\Foundation\Provider\AppServiceProvider;
use Jan\Foundation\Provider\AssetServiceProvider;
use Jan\Foundation\Provider\ConfigurationServiceProvider;
use Jan\Foundation\Provider\ConsoleServiceProvider;
use Jan\Foundation\Provider\DatabaseServiceProvider;
use Jan\Foundation\Provider\FileSystemServiceProvider;
use Jan\Foundation\Provider\MiddlewareServiceProvider;
use Jan\Foundation\Provider\RouteServiceProvider;
use Jan\Foundation\Provider\ViewServiceProvider;


/**
 * Class ApplicationStorage
 * @package Jan\Foundation
*/
class ApplicationStorage
{

     /**
      * @return string[]
     */
     public static function providers()
     {
         return [
             FileSystemServiceProvider::class,
             ConfigurationServiceProvider::class,
             AppServiceProvider::class,
             DatabaseServiceProvider::class,
             ConsoleServiceProvider::class,
             MiddlewareServiceProvider::class,
             RouteServiceProvider::class,
             AssetServiceProvider::class,
             ViewServiceProvider::class
         ];
     }


     /**
      * @return array
     */
     public static function facades()
     {
          return [];
     }


     /**
      * @return array
     */
     public static function aliases()
     {
         return [];
     }
}