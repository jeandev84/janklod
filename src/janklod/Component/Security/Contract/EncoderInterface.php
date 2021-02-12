<?php
namespace Jan\Component\Security\Contract;


/**
 * Interface EncoderInterface
 * @package Jan\Component\Security\Contract
*/
interface EncoderInterface
{

      /**
       * @param $context
       * @return mixed
      */
      public function encode($context);


      /**
       * @param $plainContext
       * @return mixed
      */
      public function isPasswordValid($plainContext);
}