<?php
namespace Jan\Component\Http\Bag;



/**
 * Class CookieBag
 *
 * @package Jan\Component\Http\Cookie\Bag
*/
class CookieBag
{

      /**
       * @var array $data
      */
      protected $data = [];


      /**
       * Cookie constructor.
       * @param array $data
      */
      public function __construct(array $data = [])
      {
          if(! $data) {
              $data = $_COOKIE;
          }

          $this->data = $data;
      }



      /**
       * @param $name
       * @param $value
       * @param int $expire
       * @return CookieBag
      */
      public function write($name, $value, $expire = 3600)
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
      public function exists($name)
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