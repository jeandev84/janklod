<?php
namespace Jan\Component\Database;


use Exception;
use Jan\Component\Database\Contract\ConfigurationInterface;


/**
 * Class Configuration
 *
 * @package Jan\Component\Database
*/
class Configuration
{

    const KEY_DRIVER    = 'driver';
    const KEY_HOST      = 'host';
    const KEY_DATABASE  = 'database';
    const KEY_PORT      = 'port';
    const KEY_CHARSET   = 'charset';
    const KEY_USERNAME  = 'username';
    const KEY_PASSWORD  = 'password';
    const KEY_COLLATION = 'collation';
    const KEY_OPTIONS   = 'options';
    const KEY_PREFIX    = 'prefix';
    const KEY_ENGINE    = 'engine';


    /**
     * @var array
    */
    private $params = [
        self::KEY_DRIVER     => 'mysql',
        self::KEY_DATABASE   => 'default',
        self::KEY_HOST       => '127.0.0.1',
        self::KEY_PORT       => '3306',
        self::KEY_CHARSET    => 'utf8',
        self::KEY_USERNAME   => 'root',
        self::KEY_PASSWORD   => 'secret',
        self::KEY_COLLATION  => 'utf8_unicode_ci',
        self::KEY_OPTIONS    => [],
        self::KEY_PREFIX     => '',
        self::KEY_ENGINE     => 'InnoDB', // InnoDB or MyISAM
    ];



    /**
     * Configuration constructor.
     *
     * @param array $params
     * @throws Exception
    */
    public function __construct(array $params)
    {
        foreach ($params as $key => $value)
        {
            if(! $this->isValidParam($key))
            {
                throw new Exception("Invalid database configuration key param : ". $key);
            }

            $this->params[$key] = $value;
        }
    }


    /**
     * @param $key
     * @param null $default
     * @return mixed|null
    */
    public function get($key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }



    /**
     * @return mixed|null
    */
    public function getDriverName()
    {
        return $this->get(self::KEY_DRIVER);
    }



    /**
     * @return mixed|null
    */
    public function getHost()
    {
        return $this->get(self::KEY_HOST);
    }



    /**
     * @return mixed|null
    */
    public function getDatabase()
    {
        return $this->get(self::KEY_DATABASE);
    }


    /**
     * @return mixed|null
    */
    public function getPort()
    {
        return $this->get(self::KEY_PORT);
    }


    /**
     * @return mixed|null
    */
    public function getCharset()
    {
        return $this->get(self::KEY_CHARSET);
    }


    /**
     * @return mixed|null
    */
    public function getUsername()
    {
        return $this->get(self::KEY_USERNAME);
    }


    /**
     * @return mixed|null
     */
    public function getPassword()
    {
        return $this->get(self::KEY_PASSWORD);
    }


    /**
     * @return mixed|null
    */
    public function getOptions()
    {
        return $this->get(self::KEY_OPTIONS);
    }


    /**
     * @return mixed|null
    */
    public function getCollation()
    {
        return $this->get(self::KEY_COLLATION);
    }


    /**
     * @return mixed|null
    */
    public function getPrefix()
    {
        return $this->get(self::KEY_PREFIX);
    }


    /**
     * @return mixed|null
    */
    public function getTableName($table)
    {
        return  $this->get(self::KEY_PREFIX). $table;
    }


    /**
     * @return mixed|null
    */
    public function getEngine()
    {
        return $this->get(self::KEY_ENGINE);
    }



    /**
     * @param string $key
     * @return bool
    */
    protected function isValidParam(string $key): bool
    {
        return \array_key_exists($key, $this->params);
    }
}