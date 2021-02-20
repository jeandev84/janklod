<?php
namespace Jan\Component\Http;


use Jan\Component\Http\Bag\CookieBag;
use Jan\Component\Http\Bag\FileBag;
use Jan\Component\Http\Bag\HeaderBag;
use Jan\Component\Http\Bag\ParameterBag;
use Jan\Component\Http\Bag\ServerBag;
use Jan\Component\Http\Session\Session;


/**
 * Class Request
 * @package Jan\Component\Http
*/
class Request
{


    /**
     * Get params from request get $_GET
     *
     * @var ParameterBag
    */
    public $queryParams;



    /**
     * Get params from request post $_POST
     *
     * @var ParameterBag
    */
    public $request;



    /**
     * Get attributes
     * 
     * @var array
    */
    public $attributes = [];




    /**
     * Get parameters from cookies $_COOKIES
     * @var CookieBag
    */
    public $cookies;



    /**
     * Get parameters from request $_FILES
     *
     * @var FileBag
    */
    public $files;



    /**
     * server bag
     * 
     * @var ServerBag
    */
    public $server;

    


    /**
     * headers
     * 
     * @var HeaderBag
    */
    public $headers;


    

    /**
     * Parsed body
     * 
     * @var string
    */
    public $content;



    /**
     * Get availables languages
     * 
     * @var
    */
    public $languages;



    /**
     * Session
    */
    public $session;



    /**
     *  charset
    */
    public $charsets;



    /**
     * encodings
     * 
     * @var 
    */
    public $encodings;




    /**
     * @var 
    */
    public $acceptableContentTypes;



    /**
     * Default locale
     * @var string
    */
    public $locale;




    /**
     * Default local language
     * @var string
    */
    public $defaultLocale = 'en';

    

    /**
     * request uri
     * 
     * @var
    */
    protected $requestUri;



    /**
     * path info
     * 
     * @var  
    */
    protected $pathInfo;


    
    /**
     * Get base URL
     * 
     * @var string
    */
    protected $baseUrl;




    /**
     * Get base path
     * 
     * @var string
    */
    protected $basePath;




    /**
     * Request method
    */
    protected $method;



    /**
     * Format
    */
    protected $format = 'html';



    /**
     * Determine if host is valid
     * @var bool
    */
    private $isHostValid = true;



//  /**
//    * Determine if has forwaded valid
//    * @var bool
//  */
//  private $isForwadedValid = true;


    /**
     * Request constructor.
     * @param array $queryParams
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param string|null $content
    */
    public function __construct(
        array $queryParams = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        string $content = null
    )
    {
        $this->handle($queryParams, $request, $attributes, $cookies, $files, $server, $content);
    }



    /**
     * @param array $queryParams
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param string|null $content
    */
    public function handle(
        array $queryParams = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        string $content = null
    )
    {
        $this->queryParams = new ParameterBag($queryParams);
        $this->request     = new ParameterBag($request);
        $this->attributes  = new ParameterBag($attributes);
        $this->cookies     = new CookieBag($cookies);
        $this->files       = new FileBag($files);
        $this->server      = new ServerBag($server);
        $this->headers     = new HeaderBag($this->server->getHeaders());
        
        $this->content     = $content;
        $this->session     = new Session();
        $this->languages   = null;
        $this->charsets    = null;
        $this->encodings   = null;
        $this->acceptableContentTypes = null;
        $this->pathInfo    = null;
        $this->requestUri  = null;
        $this->baseUrl     = null;
        $this->basePath    = null;
        $this->method      = null;
        $this->format      = null;

        /*
        $this->baseUrl = $this->getScheme() . $this->getHost();
        $this->requestUri = $this->server->get('REQUEST_URI');
        $this->pathInfo = parse_url($this->requestUri, PHP_URL_PATH);
        $this->method = $this->getMethod();
        */
    }




    /**
     * @param array $queryParams
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param string|null $content
     * @return Request
    */
    public static function factory(
        array $queryParams = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        string $content = null
    ): Request
    {
        return new static($queryParams, $request, $attributes, $cookies, $files, $server, $content);
    }


    /**
     * @param string $uri
     * @param string $method
     * @param array $parameters
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param string|null $content
     * @return Request
    */
    public static function create(
        string $uri,
        string $method = 'GET',
        array $parameters = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        string $content = null
    ): Request
    {
         $server = array_replace(self::getDefaultServerConfig(), $server);

         $server['PATH_INFO'] = '';
         $server['REQUEST_METHOD'] = strtoupper($method);

         $urlComponents = parse_url($uri); // components
         /* $urlComponents = new Uri($uri); */
        
         $queryParams = [];
         $request = [];


         return static::factory($queryParams, $request, [], $cookies, $files, $server, $content);
    }


    /**
     * Request factory
     *
     * @return Request
    */
    public static function createFromGlobals(): Request
    {
        $request =  static::factory($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);

        $requestMethod = strtoupper($request->getMethod());

        /* dump($requestMethod); */
        
        if($_POST) {
           $request->request = new ParameterBag($_POST);
        }
        
        if(\in_array($requestMethod, ['PUT', 'DELETE', 'PATCH'])) {
           
            parse_str($request->getContent(), $data);
            $request->request = new ParameterBag($data);
        }

        return $request;
    }


    

    /**
     * @return string|null
    */
    public function getContent(): ?string
    {
        if($this->content === null)
        {
           $this->content = file_get_contents('php://input');
        }
        
        return $this->content;
    }


    /**
     * @param string|null $content
     * @return Request
    */
    public function setContent(?string $content): Request
    {
         $this->content = $content;

         return $this;
    }


    /**
     * @param array $attributes
     * @return Request
    */
    public function setAttributes(array $attributes = []): Request
    {
        $this->attributes = $attributes;

        return $this;
    }


    /**
     * Get attribute
     * @param string $key
     * @return mixed
    */
    public function getAttribute(string $key)
    {
         return $this->attributes[$key] ?? null;
    }



    /**
     * @return array
    */
    public function getAttributes(): array
    {
        return $this->attributes;
    }


    
    
    /**
     * @return bool
    */
    public function isSecure(): bool
    {
         $https = $this->server->get('HTTPS');
         $port  = $this->server->get('SERVER_PORT');

         return $https == 'on' && $port == 443;
    }


    /**
     * @return bool
    */
    public function isXhr(): bool
    {
        return $this->server->get('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
    }


    /**
     * @param string $key
     * @return mixed|null
    */
    public function get(string $key)
    {
        return $this->queryParams->get($key, []);
    }


    /**
     * get param forced integer
     *
     * $page = $this->getInt('page', 1)
     * The same like : $page = (int) ($_GET['page'] ?? 1)
     *
     * @param string $name
     * @param int|null $default
     * @return int|null
     * @throws \Exception
    */
    public function getInt(string $name, int $default = null)
    {
         $param = $this->queryParams->get($name);

         if(! $this->queryParams->has($name))
         {
             return $default;
         }

         if(! filter_var($param, FILTER_VALIDATE_INT))
         {
             throw new \Exception(sprintf("This param [ %s ] in url must be integer", $name));
         }

         return (int) $this->queryParams->get($name);
    }


    /**
     * @param string $key
     * @return mixed|null
    */
    public function input(string $key)
    {
        return $this->request->get($key, []);
    }


    /**
     * @param string $key
     * @return array|mixed|null
    */
    public function post(string $key): ?array
    {
        if($this->isPost())
        {
            return $this->request->get($key, []);
        }
    }


    /**
     * @param string $key
    */
    public function put($key = '')
    {

    }


    /**
     * @return string
    */
    public function getScheme(): string
    {
        return $this->isSecure() ? 'https' : 'http:';
    }



    /**
     * @return mixed|null
    */
    public function getRequestUri()
    {
        return urldecode($this->server->get('REQUEST_URI'));
    }


    /**
     * @return mixed|null
    */
    public function getHost()
    {
        return $this->server->get('HTTP_HOST');
    }


    /**
     * @return array|false|int|string|null
    */
    public function getPath()
    {
       return parse_url($this->getRequestUri(), PHP_URL_PATH);
    }


    /**
     * @return array|false|int|string|null
    */
    public function getFragment()
    {
        // $parseUrl = $this->baseUrl. $this->requestUri. '#fragment';
        return parse_url($this->baseUrl, PHP_URL_FRAGMENT);
    }


    /**
     * @return array|false|int|string|null
     */
    public function getUser()
    {
        return parse_url($this->baseUrl, PHP_URL_USER);
    }


    /**
     * @return array|false|int|string|null
     */
    public function getPassword()
    {
        return parse_url($this->baseUrl, PHP_URL_PASS);
    }



    /**
     * @param string $method
     * @return $this
    */
    public function setMethod(string $method): Request
    {
        $this->server->set('REQUEST_METHOD', $method);

        return $this;
    }




    /**
     * @return string
    */
    public function getMethod(): string
    {
        return $this->server->get('REQUEST_METHOD', 'GET');
    }


    /**
     * @return bool
    */
    public function isGet(): bool
    {
        return $this->getMethod() === 'GET';
    }


    /**
     * @return bool
    */
    public function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }


    /**
     * @param $baseUrl
     * @return $this
    */
    public function setBaseUrl($baseUrl): Request
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }


    /**
     * @return string
    */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }



    /**
     * @return string
    */
    public function url()
    {
        /* return implode([$this->getScheme() . '://', $this->getHost(), $this->getRequestUri()]); */
        return $this->baseUrl . $this->requestUri;
    }
    



    public function getContentOLD()
    {
        /*
        $method = 'GET';
        $data = $this->queryParams->all();
 
        if($this->getMethod() === 'POST')
        {
            $method = 'POST';
            $data = $this->request->all();     
        }
        
        $options = [
           'http' => [ // or https
               'method'  => $method,
               'content' => http_build_query($data)
           ]
        ];

        // Create a context stream with 
        // the specified options 
        $stream = stream_context_create($options); 
        
        return file_get_contents($this->getUrl(), false, $stream);
        */

        /* return file_get_contents($this->getUrl(), true); */
    }


    /**
     * @return mixed|null
     * @throws Exception\BagException
    */
    public function getDocumentRoot()
    {
        return $this->server->get('DOCUMENT_ROOT');
    }


    /**
     * @return mixed|null
     * @throws Exception\BagException
    */
    public function getPort()
    {
        return $this->server->get('SERVER_PORT');
    }


    /**
     * @return mixed|null
     * @throws Exception\BagException
    */
    public function getIpClient()
    {
        // must to had some verification
        return $this->server->get('REMOTE_ADDR');
    }


    /**
     * @return mixed|null
     * @throws Exception\BagException
    */
    public function getIpPort()
    {
        return $this->server->get('REMOTE_PORT');
    }



    /**
     * @return mixed|null
     * @throws Exception\BagException
    */
    public function getScriptName()
    {
        return $this->server->get('SCRIPT_NAME');
    }


    /**
     * @return mixed|null
     * @throws Exception\BagException
    */
    public function getProtocol()
    {
        return $this->server->get('SERVER_PROTOCOL');
    }


    /**
     * @return mixed|null
     * @throws Exception\BagException
   */
    public function getSoftWare()
    {
        return $this->server->get('SERVER_SOFTWARE');
    }



    /**
     * @return mixed|null
     * @throws Exception\BagException
    */
    public function getHeaders()
    {
        return $this->headers->all();
    }


    /**
     * @param $key
     * @return mixed|null
     * @throws Exception\BagException
    */
    public function getHeader($key)
    {
        return $this->headers->get($key);
    }


    /**
     * @return mixed|null
    */
    public function getQueryString()
    {
        return urldecode($this->server->get('QUERY_STRING'));
    }


    /**
     * @return mixed|null
     * @throws Exception\BagException
    */
    public function getUserAgent()
    {
        return $this->server->get('HTTP_USER_AGENT');
    }



    /**
     * @return array
    */
    protected static function getDefaultServerConfig()
    {
        return [
            'SERVER_NAME' => 'localhost',
            'SERVER_PORT' => 80,
            'HTTP_HOST'   => 'localhost',
            'HTTP_USER_AGENT' => 'Jan', // Framework
            'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'HTTP_ACCEPT_LANGUAGE' => 'en-us,en;q=0.5',
            'HTTP_ACCEPT_CHARSET' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'REMOTE_ADDR' => '127.0.0.1',
            'SCRIPT_NAME' => '',
            'SCRIPT_FILENAME' => '',
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'REQUEST_TIME' => time(),
        ];
    }

}


/*
protected function getPathOfUrl(string $url)
{
    /*
    $url = urldecode($url)
    if(strpos($url, '?') !== false)
    {
         // list($path, $qs) = explode('?', $url);
         return explode('?', $url)[0];
    }

    return parse_url(urldecode($url), PHP_URL_PATH);
}

function getUrlPath(string $url)
{
    $url = urldecode($url)

    if(stripos($url, '?') !== false)
    {
         // list($path, $qs) = explode('?', $url);
         return explode('?', $url)[0]; // Get Path
         return [$path, $qs];
    }

    return $url;

   // or return parse_url($url, PHP_URL_PATH);
}
*/