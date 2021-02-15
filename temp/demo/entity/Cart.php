<?php
namespace App\Entity;


/**
 * Class Cart
 * @package App\Entity
*/
class Cart
{

     public function __construct()
     {
          echo __CLASS__."<br>";
     }

     public function add($id)
     {
          return 'add to cart';
     }

     public function remove($id)
     {
         return 'remove item form cart';
     }
}