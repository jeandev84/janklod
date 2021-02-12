<?php
namespace Jan\Component\Config\Loaders;

use Jan\Component\Config\Loaders\Contract\Loader;
use Exception;


/**
 * Class ArrayLoader
 *
 * @package Jan\Component\Config\Loaders
*/
class ArrayLoader implements Loader
{

    /**
     * @var array
    */
    protected $files;


    /**
     * ArrayLoader constructor.
     * @param array $files
    */
    public function __construct(array $files)
    {
         $this->files = $files;
    }


    /**
     * Parse method
     *
     * @return array
     * @throws Exception
    */
    public function parse()
    {
        $parsed = [];

        foreach ($this->files as $namespace => $path)
        {
            try {

                $parsed[$namespace] = @require $path;

            } catch (Exception $e) {

                   throw $e;
            }
        }

        return $parsed;
    }
}