<?php
namespace Jan\Component\Console\Output;


use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class ConsoleOutput
 * @package Jan\Component\Console\Output
*/
class ConsoleOutput implements OutputInterface
{

     /**
      * @param $message
      * @return mixed
     */
     public function write($message)
     {
         echo $message ."\n";
     }
}