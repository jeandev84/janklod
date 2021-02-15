<?php
namespace Jan\Component\Http\Bag;


/**
 * Class HeaderBag
 * @package Jan\Component\Http\Bag
*/
class HeaderBag extends ParameterBag
{

     /**
      * HeaderBag constructor.
      * @param array $data
     */
     public function __construct(array $data)
     {
         parent::__construct($data);
     }
}