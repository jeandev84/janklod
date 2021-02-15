<?php
namespace Jan\Component\Http\Session\Contract;


/**
 * Interface SessionInterface
 * @package Jan\Component\Http\Session\Contract
 */
interface SessionInterface
{
     /**
      * Set session key
      *
      * @param $key
      * @param $value
      * @return mixed
     */
     public function set($key, $value);


     /**
      * Determine if the given key has in session
      *
      * @param $key
      * @return mixed
     */
     public function has($key);


     /**
      * Get item from session
      *
      * @param $key
      * @return mixed
     */
     public function get($key);


     /**
      * Forget key
      *
      * @param $key
      * @return mixed
     */
     public function remove($key);


     /**
      * clear all session
      *
      * @return mixed
     */
     public function flush();
}