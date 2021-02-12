<?php
namespace Jan\Component\Console\Input\Support;


use Jan\Component\Console\Exception\InvalidArgumentException;
use RuntimeException;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Input\InputBag;


/**
 * Class Input
 * @package Jan\Component\Console\Input\Support
*/
abstract class Input implements InputInterface
{

       /**
        * @var array
       */
       protected $arguments = [];


       /**
        * @var array
       */
       protected $options = [];


       /**
        * @var InputBag
       */
       protected $inputBag;


       /**
        * Input constructor.
        * @param InputBag|null $inputBag
       */
       public function __construct(InputBag $inputBag = null)
       {
            if($inputBag instanceof InputBag)
            {
                $this->bind($inputBag);
            }
       }



       /**
        * @param InputBag $inputBag
       */
       public function bind(InputBag $inputBag)
       {
            $this->inputBag  = $inputBag;
            $this->parse();
            $this->validate();
       }


       /**
        * Validate parses params
        *
        * @return mixed
      */
       public function validate()
       {
            /* dump($this->inputBag->getArguments()); */
            /*
            $missingArguments = array_filter($this->inputBag->getArguments(), function ($key) {

                // dd($key);
                return ! \array_key_exists($key->getName(), $this->arguments);

            });

            if(!\count($missingArguments) > 0)
            {
                throw new RuntimeException(
                   sprintf('Not enough arguments (missing: "%s").', implode(',', $missingArguments))
                );
            }
            */
       }


       /**
        * Get argument
        *
        * @param string $name
        * @return string|void|null
        * @throws InvalidArgumentException
       */
       public function getArgument(string $name): ?string
       {
             if(! $this->inputBag->hasArgument($name))
             {
                throw new InvalidArgumentException(
                    sprintf('The "%s" argument does not exist.', $name)
                );
             }

             if(\array_key_exists($name, $this->arguments))
             {
                  return $this->arguments[$name];
             }

             return $this->inputBag->getArgument($name)->getDefault();
      }


    /**
     * @param string $name
     * @param $value
     * @throws InvalidArgumentException
    */
    public function setArgument(string $name, $value)
    {
         if(! $this->inputBag->hasArgument($name))
         {
               throw new InvalidArgumentException(
                   sprintf('The "%s" argument does not exist.', $name)
               );
         }

         $this->arguments[$name] = $value;
    }


    /**
     * @param $name
     * @return bool
    */
    public function hasArgument($name): bool
    {
        return $this->inputBag->hasArgument($name);
    }


    /**
     * Get arguments
     *
     * @return array
    */
    public function getArguments(): array
    {
        return $this->arguments;
    }


    /**
     * Get options
     *
     * @return array
    */
    public function getOptions(): array
    {
        return $this->options;
    }


    /**
     * @param string $name
     * @return string|void|null
     * @throws InvalidArgumentException
    */
    public function getOption(string $name): ?string
    {
        if(! $this->inputBag->hasOption($name))
        {
            throw new InvalidArgumentException(
                sprintf('The "%s" option does not exist.', $name)
            );
        }


        if(\array_key_exists($name, $this->options))
        {
            return $this->options[$name];
        }

        return $this->inputBag->getOption($name)->getDefault();
    }


    /**
     * @param string $name
     * @param $value
     * @throws InvalidArgumentException
    */
    public function setOption(string $name, $value)
    {
        if(! $this->inputBag->hasOption($name))
        {
            throw new InvalidArgumentException(
                sprintf('The "%s" option does not exist.', $name)
            );
        }

        $this->options[$name] = $value;
    }


    /**
     * @param string $name
     * @return bool
    */
    public function hasOption(string $name): bool
    {
        return $this->inputBag->hasOption($name);
    }


    /**
     * @param string $token
    */
    public function escapeToken(string $token)
    {
        //  regex for token
    }

    abstract protected function parse();
}