<?php
namespace Jan\Component\Database\Canon\Contract;


/**
 * Interface UserInterface
 * @package Jan\Component\Database\Doctrine\Contract
*/
interface UserInterface
{

     /**
      * @param string $username
      * @return mixed
     */
     public function setUsername(string $username);



     /**
      * @param string $email
      * @return mixed
     */
     public function setEmail(string $email);



     /**
      * @param string $password
      * @return mixed
     */
     public function setPassword(string $password);



     /**
      * @param array $roles
      * @return mixed
     */
     public function setRoles(array $roles);
}