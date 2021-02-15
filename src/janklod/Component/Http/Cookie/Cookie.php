<?php
namespace Jan\Component\Http\Cookie;


/**
 * Class Cookie
 * @package Jan\Component\Http\Cookie
*/
class Cookie
{

      /**
       * @var array $data
      */
      protected $data = [];

      


      /**
       * Cookie constructor.
       * @param array $cookies
      */
      public function __construct(array $cookies = [])
      {
          if(! $cookies)
          {
              $cookies = $_COOKIE;
          }

          $this->data = $cookies;
      }


      /**
       * @param $name
       * @param $value
       * @param int $expire
       * @return Cookie
      */
      public function set($name, $value, $expire = 3600)
      { 
          /* setcookie($name, $value, time() + $expire); */
          /* 
             setcookie(name, value, expire, path, domain, secure, httpOnly)
             setcookie($name, $value, $expire, '/', '/', true, true); 
          */

          return $this;
      }


      /**
       * @param $name
       * @return bool
      */
      public function has($name)
      {
           return \array_key_exists($name, $this->data);
      }



      /**
       * @param $name
       * @return mixed|null
      */
      public function get(string $name)
      {
          return $this->data[$name] ?? null;
      }


      /**
       * @return array
      */
      public function all()
      {
          return $this->data;
      }
}