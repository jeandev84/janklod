<?php
namespace Jan\Component\Security\Encoder;


/**
 * Class Encoder
 * @package Jan\Component\Security\Encoder
*/
class Encoder
{

       /**
        * @param $password
        * @return false|string|null
       */
       public function encodePassword($password)
       {
            return new PasswordEncoder($password);
       }
}