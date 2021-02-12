<?php
namespace Jan\Component\Console\Command;


use Exception;
use Jan\Component\Console\Exception\InvalidArgumentException;
use Jan\Component\Console\Exception\LogicException;
use Jan\Component\Console\Input\Contract\InputInterface;
use Jan\Component\Console\Input\InputArgument;
use Jan\Component\Console\Input\InputBag;
use Jan\Component\Console\Input\InputOption;
use Jan\Component\Console\Output\Contract\OutputInterface;


/**
 * Class Command
 * @package Jan\Component\Console\Command
*/
class Command implements CommandInterface
{

    /**
     * @var string
    */
    protected $defaultName;


    /**
     * @var string
    */
    protected $name;


    /**
     * @var string
    */
    protected $description = '';


    /**
     * @var string
    */
    protected $help = '';


    /**
     * @var InputBag
    */
    protected $inputBag;


    /**
     * Command constructor.
     * @param string|null $name
     * @throws InvalidArgumentException
    */
    public function __construct(string $name = null)
    {
         $this->inputBag = new InputBag();

         if($name)
         {
             $this->setName($name);
         }

         $this->configure();
    }


    /**
     * @param $name
     *
     * @return Command
     * @throws InvalidArgumentException
    */
    public function setName($name): Command
    {
        $this->validateName($name);

        $this->name = $name;

        return $this;
    }


    /**
     * @return string
    */
    public function getName(): string
    {
        if($this->name)
        {
            // $this->validateName($this->name);

            return $this->name;
        }

        return $this->defaultName;
    }



    /**
     * @param string $description
     * @return Command
    */
    public function setDescription(string $description): Command
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return string
    */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * @param string $help
     * @return $this
    */
    public function setHelp(string $help): Command
    {
        $this->help = $help;

        return $this;
    }


    /**
     * @return string
    */
    public function getHelp(): string
    {
        return $this->help;
    }


    /**
     * @param string $name
     * @param string $description
     * @param null $default
     * @return Command
     * @throws LogicException
    */
    public function addArgument(string $name, string $description = '', $default = null): Command
    {
        $this->inputBag->addArgument(
            new InputArgument($name, $description, $default)
        );

        return $this;
    }


    /**
     * @return array
    */
    public function getArguments(): array
    {
        return $this->inputBag->getArguments();
    }


    /**
     * @param string $name
     * @param null $shortcut
     * @param string $description
     * @param null $default
     * @return Command
    */
    public function addOption(string $name, $shortcut = null, string $description = '', $default = null): Command
    {
        $this->inputBag->addOption(
            new InputOption($name, $shortcut, $description, $default)
        );

        return $this;
    }


    /**
     * @return array
    */
    public function getOptions(): array
    {
        return $this->inputBag->getOptions();
    }


    /**
     * @return InputBag
    */
    public function getInputBag(): InputBag
    {
        return $this->inputBag;
    }



    /**
     * Used for configuration command
    */
    public function configure() {}



    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws Exception
    */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        throw new Exception('Method execute must be execute!');
    }


    /**
     * @param string $name
     * @throws InvalidArgumentException
    */
    protected function validateName(string $name)
    {
        if(! preg_match('/^(\w+):(\w+)$/', $name))
        {
            throw new InvalidArgumentException(sprintf('Command name "%s" is invalid.', $name));
        }
    }
}