<?php
namespace Jan\Component\Validation;


use Jan\Component\Validation\Contract\ValidationInterface;

/**
 * Class Validator
 * @package Jan\Component\Validation
*/
class Validator implements ValidationInterface
{

     /**
      * @var array
     */
     protected $errors = [];


     /**
      * @var array
     */
     protected $data  = [];


     /**
      * Validator constructor.
      * @param array $data
     */
     public function __construct(array $data = [])
     {
         $this->data = $data;
     }


     /**
      * @param $item
      * @return $this
     */
     public function add($item): Validator
     {
         $this->data[] = $item;

         return $this;
     }


     public function isEmail($type): Validator
     {
         return $this;
     }


     /**
      * @return bool
     */
     public function isValid(): bool
     {
         return empty($this->errors);
     }
}