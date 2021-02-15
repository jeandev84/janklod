<?php
namespace Jan\Foundation\Generator;


use Jan\Component\FileSystem\FileSystem;


/**
 * class StubGenerator
 *
 * @package Jan\Foundation\Generator
*/
class StubGenerator
{

    /**
     * @var string
    */
    protected $stubDirectory = __DIR__ . '/../stubs';



    /**
     * @var FileSystem
    */
    protected $fileSystem;



    /**
     * StubGenerator constructor.
     * @param FileSystem $fileSystem
    */
    public function __construct(FileSystem $fileSystem)
    {
          // $fileSystem->setRoot($this->stubDirectory);
          $this->fileSystem = $fileSystem;
    }


    /**
     * @param $stubDirectory
     * @return $this
    */
    public function setStubDirectory($stubDirectory): StubGenerator
    {
         $this->stubDirectory = $stubDirectory;

         $this->fileSystem->setRoot($this->stubDirectory);

         return $this;
    }



    /**
     * @param $name
     * @param $replacements
     * @return string|string[]
    */
    public function generateStub($name, $replacements)
    {
        return $this->fileSystem->replace($name, $replacements);
    }

//    /**
//     * @param $name (filename of stub)
//     *
//     * @param $replacements
//     * @return false|string|string[]
//    */
//    public function generateStub($name, $replacements)
//    {
//        return str_replace(
//            array_keys($replacements),
//            $replacements,
//            file_get_contents(sprintf('%s/%s.stub', $this->stubDirectory, $name))
//        );
//    }
}
