<?php
namespace Jan\Component\Security\Encoder;


/**
 * Class PasswordEncoder
 * @package Jan\Component\Security\Encoder
*/
class PasswordEncoder
{

     /**
      * @var false|string|null
     */
     protected $password;


     /**
      * PasswordEncoder constructor.
      * @param string $password
      * @param string $algo
     */
     public function __construct(string $password, string $algo = '')
     {
         $this->password = password_hash($password, $algo);
     }
}