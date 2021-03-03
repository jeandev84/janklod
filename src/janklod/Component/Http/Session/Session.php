<?php
namespace Jan\Component\Http\Session;


use Jan\Component\Http\Session\Contract\SessionInterface;


/**
 * Class Session
 * @package Jan\Component\Http\Session
*/
class Session implements SessionInterface
{

      /**
        * Session constructor.
      */
      public function __construct()
      {
           if(session_status() === PHP_SESSION_NONE && ! headers_sent()) {
                session_start();
           }
      }


      /**
       * Save session to the file
       *
       * @param $filename
      */
      public function storage($filename)
      {

      }



      /**
       * Set item to session
       *
       * @param $key
       * @param $value
       * @return $this
      */
      public function write($key, $value): Session
      {
           $_SESSION[$key] = $value;

           return $this;
      }


      /**
       * Determine if key exist in $_SESSION data
       *
       * @param $key
       * @return bool
      */
      public function exists($key): bool
      {
          return \array_key_exists($key, $_SESSION);
      }



      /**
       * Read key value from $_SESSION
       *
       * @param $key
       * @return mixed
      */
      public function read($key)
      {
          return $_SESSION[$key] ?? null;
      }


      /**
       * Delete session item
       *
       * @param $key
      */
      public function remove($key)
      {
          if($this->has($key))
          {
              unset($_SESSION[$key]);
          }
      }



      /**
       * Get all items from $_SESSION
       *
       * @return array
      */
      public function all(): array
      {
           return $_SESSION;
      }


      /**
       * @return mixed
      */
      public function flush()
      {
          foreach (array_keys($_SESSION) as $key)
          {
              $this->remove($key);
          }
      }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        // TODO: Implement set() method.
    }

    /**
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }
}