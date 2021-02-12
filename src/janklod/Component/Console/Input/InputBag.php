<?php
namespace Jan\Component\Console\Input;


use Jan\Component\Console\Exception\LogicException;

/**
 * Class InputBag
 * @package Jan\Component\Console\Input
*/
class InputBag
{

    /**
     * @var array
    */
    private $arguments = [];


    /**
     * @var array
    */
    private $options = [];


    /**
     * InputBag constructor.
     * @param array $items
     * @throws LogicException
    */
    public function __construct(array $items = [])
    {
          $this->setItems($items);
    }


    /**
     * @param array $items
     * @throws LogicException
    */
    public function setItems(array $items)
    {
         $arguments = [];
         $options   = [];

         foreach ($items as $item)
         {
             if($item instanceof InputOption)
             {
                 $options[] = $item;
             }

             if($item instanceof InputArgument)
             {
                 $arguments[] = $item;
             }
         }

         $this->setArguments($arguments);
         $this->setOptions($options);
    }


    /**
     * @param array|null $arguments
     * @throws LogicException
    */
    public function setArguments(?array $arguments = [])
    {
         $this->addArguments($arguments);
    }


    /**
     * @param array $arguments
     * @throws LogicException
    */
    public function addArguments(array $arguments = [])
    {
        if($arguments)
        {
            foreach ($arguments as $argument) {
                $this->addArgument($argument); // InputArgument
            }
        }
    }


    /**
     * @param InputArgument $argument
     * @return InputBag
     * @throws LogicException
    */
    public function addArgument(InputArgument $argument): InputBag
    {
        if($this->hasArgument($argument->getName()))
        {
             throw new LogicException(
                 sprintf('An argument with name "%s" already exists.', $argument->getName())
             );
        }

        $this->arguments[$argument->getName()] = $argument;

        return $this;
    }


    /**
     * @param $name
     * @return bool
    */
    public function hasArgument($name): bool
    {
         return \array_key_exists($name, $this->arguments);
    }


    /**
     * @return array
    */
    public function getArguments(): array
    {
        return $this->arguments;
    }


    /**
     * @param $name
     * @param $value
    */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }



    /**
     * @param array $options
    */
    public function setOptions(array $options = [])
    {
       if($options)
       {
           foreach ($options as $option)
           {
               $this->addOption($option);
           }
       }
    }


    /**
     * @param InputOption $option
     * @return InputBag
    */
    public function addOption(InputOption $option): InputBag
    {
        $this->options[$option->getName()] = $option;

        return $this;
    }


    /**
     * @param $name
     * @return bool
    */
    public function hasOption($name): bool
    {
        return \array_key_exists($name, $this->options);
    }


    /**
     * @param string $name
     * @return InputArgument|null
    */
    public function getArgument(string $name): ?InputArgument
    {
        return $this->arguments[$name] ?? null;
    }


    /**
     * @param string $name
     * @return InputOption|null
    */
    public function getOption(string $name): ?InputOption
    {
        return $this->options[$name] ?? null;
    }


    /**
     * @return array
    */
    public function getOptions(): array
    {
        return $this->options;
    }
}