<?php
namespace Jan\Component\Console\Input;


use Jan\Component\Console\Exception\InvalidArgumentException;
use Jan\Component\Console\Exception\LogicException;
use Jan\Component\Console\Input\Support\Input;


/**
 * Class ArgvInput
 * @package Jan\Component\Console\Input
*/
class ArgvInput extends Input
{

        /**
         * @var string
        */
        protected $compile;


        /**
          * @var array|mixed
        */
        protected $parseArgv;


        /**
         * @var string
        */
        protected $firstArgument;


       /**
         * InputArgv constructor.
         *
         * @param array $parseArgv
         * @param InputBag|null $inputBag
       */
       public function __construct(array $parseArgv = [], InputBag $inputBag = null)
       {
            if(! $parseArgv)
            {
                $parseArgv = $_SERVER['argv'] ?? [];
            }

            if(! $inputBag)
            {
                $inputBag = new InputBag();
            }

            $this->parseArgv = $parseArgv;
            $this->compile = $this->getParse(0);
            $this->firstArgument = $this->getParse(1);

            unset($this->parseArgv[0], $this->parseArgv[1]);
       }


       /**
        * Get name of file compiled
        *
        * @return mixed|string
       */
       public function compile()
       {
           return $this->compile;
       }


       /**
        * Get first argument
        *
        * @return string
       */
       public function getFirstArgument(): string
       {
          return $this->firstArgument;
       }


       /**
        * Set parses
        *
        * @param array $parseArgv
       */
       protected function setParses(array $parseArgv)
       {
             $this->parseArgv = $parseArgv;
       }


       /**
        * Parse arguments and options
       */
       protected function parse()
       {
           $arguments = [];
           $options   = [];

           // php console make:addition a0 -a1=2 -b1=4 -h --table=users --depth
           // php console make:addition a0 -a1=2 -b1=4 -h --table=users --depth
           foreach ($this->parseArgv as $item)
           {
               if(preg_match('/^(.*)=(.*)$/', $item, $matches))
               {
                    //$tokenName = $matches[1];
                    //$tokenValue = $matches[2];
                    list($tokenName, $tokenValue) = explode('=', $matches, 2);

                    if(preg_match('/^-(\w+)$/', $tokenName))
                    {
                        $arguments[$tokenName] = $tokenValue;
                    }

                   if(preg_match('/^--(\w+)$/', $tokenName))
                   {
                       $options[$tokenName] = $tokenValue;
                   }

               }else{
                   $arguments[] = $item;
               }
           }

           $this->setArguments($arguments);
           $this->setOptions($options);
       }


      /**
       * @param array $arguments
       */
      protected function setArguments(array $arguments)
      {

      }


      /**
       * @param array $options
      */
      protected function setOptions(array $options)
      {

      }



      /**
       * @param $index
       * @param string $default
       * @return mixed|string
      */
      private function getParse($index, $default = '')
      {
          return $this->parseArgv[$index] ?? $default;
      }
}