<?php
namespace Jan\Component\Dotenv;


use Exception;


/**
 * Class Dotenv (load environments data)
 * @package Jan\Component\Dotenv
*/
class Dotenv
{

    /**
     * @var string
    */
    protected $resource;


    /**
     * Env constructor.
     *
     * @param string $resource
    */
    public function __construct(string $resource)
    {
         $this->resource = rtrim($resource, '\\/');
    }


    /**
     * @param $resource
     * @return array|Dotenv
    */
    public static function create(string $resource)
    {
         return new static($resource);
    }


    /**
     * @param string $filename
     *
     * @return array|bool
     * @throws Exception
     */
    public function load($filename = '.env')
    {
        $environVariables = $this->getEnvironments($filename);

        if(! $environVariables)
        {
            return false;
        }

        $resolvedEnviron = [];

        foreach($environVariables as $env)
        {
            $env = trim(str_replace("\n", '', $env));

            if(preg_match('#^(.*)=(.*)$#', $env, $matches))
            {
                $matchedEnv = str_replace(' ', '', $matches[0]);
                $envStr = explode('#', $matchedEnv)[0];

                putenv($envStr);

                list($key, $value) = explode('=', $env);
                $resolvedEnviron[$key] = $value;
            }
        }

        return $resolvedEnviron;
    }


    /**
     * @param $filename
     * @return array
     * @throws Exception
    */
    public function getEnvironments(string $filename): array
    {
        $path = $this->resource . DIRECTORY_SEPARATOR. $filename;

        if(! file_exists($path))
        {
             return [];
        }

        return file($path);
    }
}



/*
try {

    Dotenv::create(__DIR__.'/../')->load();

} catch (Exception $e) {

    die($e->getMessage());
}

echo getenv('APP_NAME');
*/
