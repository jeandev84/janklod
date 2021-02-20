<?php
namespace Jan\Component\Http;

use Jan\Component\Http\Helper\UrlEncoder;


/**
 * Class Uri
 * @package Jan\Component\Http
*/
class Uri
{

    /**
     * @var string
    */
    private $path;


    /**
     * Uri constructor.
     * @param string $path
    */
    public function __construct($path = '')
    {
         if(! $path)
         {
             $path = $_SERVER['REQUEST_URI'];
         }

         $this->path = parse_url(UrlEncoder::decode($path));
    }


    /**
     * @param int $code
     * @return array|false|int|string|null
    */
    public function getComponent(int $code)
    {
        return '';
    }


    /**
     * @return array|false|int|string|null
    */
    public function getPath()
    {
        return $this->getComponent(PHP_URL_PATH);
    }


    /**
     * @return array|false|int|string|null
    */
    public function getQuery()
    {
        return $this->getComponent(PHP_URL_QUERY);
    }



    /**
     * @return false|string
    */
    public function getBody()
    {
        return file_get_contents('php://input');
    }
}


/*
$url = 'http://username:password@hostname:9090/path?arg=value#anchor';

var_dump(parse_url($url));
var_dump(parse_url($url, PHP_URL_SCHEME));
var_dump(parse_url($url, PHP_URL_USER));
var_dump(parse_url($url, PHP_URL_PASS));
var_dump(parse_url($url, PHP_URL_HOST));
var_dump(parse_url($url, PHP_URL_PORT));
var_dump(parse_url($url, PHP_URL_PATH));
var_dump(parse_url($url, PHP_URL_QUERY));
var_dump(parse_url($url, PHP_URL_FRAGMENT));
*/