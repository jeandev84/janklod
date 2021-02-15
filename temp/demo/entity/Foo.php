<?php
namespace App\Entity;


/**
 * Class Foo
 * @package App\Entity
*/
class Foo
{

     /**
      * @var Format
     */
     protected $format;


     /**
      * Foo constructor.
      * @param Format $format
     */
     public function __construct(Format $format)
     {
          $this->format = $format;

          echo __CLASS__."<br>";
     }


     /**
      * @return string
     */
     public function textFormat()
     {
        return $this->format->printText();
     }
}