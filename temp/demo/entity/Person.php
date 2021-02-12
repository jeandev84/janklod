<?php
namespace App\Entity;


/**
 * Class Person
 * @package App\Entity
*/
class Person
{

     /**
      * @var string
     */
     protected $firstname;


     /**
      * @var string
     */
     protected $surname;


     /**
      * @var string
     */
     protected $patronymic;


     /**
      * @var Address
     */
     protected $address;


     /**
      * Person constructor.
      * @param Address $address
     */
     public function __construct(Address $address)
     {
          $this->address = $address;
     }


     /**
      * @return array
     */
     public function getContents()
     {
         return [

         ];
     }
}