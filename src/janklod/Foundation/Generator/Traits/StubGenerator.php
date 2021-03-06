<?php
namespace Jan\Foundation\Generator\Traits;


/**
 * Trait StubGenerator
 *
 * @package Jan\Foundation\Generator\Traits
 */
trait StubGenerator
{


    /** @var string  */
    protected $stubDirectory = __DIR__ . '/../stubs';



    /**
     * @param $name (filename of stub)
     *
     * @param $replacements
     * @return false|string|string[]
    */
    public function generateStub($name, $replacements)
    {
        return str_replace(
            array_keys($replacements),
            $replacements,
            file_get_contents(sprintf('%s/%s.stub', $this->stubDirectory, $name))
        );
    }
}
