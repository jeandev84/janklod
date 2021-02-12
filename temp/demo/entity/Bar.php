<?php
namespace App\Entity;


/**
 * Class Bar
 * @package App\Entity
*/
class Bar
{
    public function __construct(Cart $cart, Format $format, $id = 1)
    {
        echo __CLASS__. "<br>";
    }
}