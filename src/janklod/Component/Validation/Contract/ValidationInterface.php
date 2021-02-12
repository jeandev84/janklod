<?php
namespace Jan\Component\Validation\Contract;


/**
 * Interface ValidationInterface
 * @package Jan\Component\Validation\Contract
*/
interface ValidationInterface
{
     /**
      * @return bool
     */
     public function isValid(): bool;
}