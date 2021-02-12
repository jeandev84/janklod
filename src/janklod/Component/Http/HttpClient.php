<?php
namespace Jan\Component\Http;


/**
 * Class HttpClient
 * @package Jan\Component\Http
*/
class HttpClient
{

     /**
      * client configuration
      *
      * @var array
     */
     protected $params = [];


     /**
      * @var string
     */
     protected $baseUrl;


     /**
      * Client constructor.
     */
     public function __construct()
     {
     }


    /**
     * @param $method
     * @param $url
     * @param array $options
     * @return Response
     */
     public function request($method, $url, $options = []): Response
     {
          $request = Request::create($url, $method);

          $content = file_get_contents($url);
          $response = new Response();
          $response->withBody($content);

          return $response;
     }


     /**
      * @param $uri
      * @param array $options
      * @return Response
     */
     public function get($uri, $options = []): Response
     {
        return $this->request('GET', $uri, $options);
     }

    /**
     * @param $uri
     * @param array $options
     * @return Response
     */
    public function post($uri, $options = []): Response
    {
        return $this->request('POST', $uri, $options);
    }


    /**
     * @param $key
     * @return mixed|null
    */
    protected function getParam($key)
    {
        return $this->params[$key] ?? null;
    }
}


# Example
$client = new HttpClient();

$response = $client->request('GET', 'http://localhost:8000', [
    'headers' => []
]);

$content = $response->getBody();