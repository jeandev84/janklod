<?php
namespace Jan\Foundation\Form;


/**
 * Class OptionResolver
 * @package Jan\Foundation\Form
*/
class OptionResolver
{

     /**
      * @var array
     */
     protected $options = [];


     /**
      * @param array $options
     */
     public function setDefaults(array $options)
     {
         $this->options = $options;
     }
}