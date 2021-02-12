<?php
namespace Jan\Foundation\Routing;

use Jan\Component\Http\Response;




/**
 * Базовый контроллер для REST API
 *
 * Class RestController
 * @package App\Controller\Api
 */
class RestController extends Controller
{

    /**
     * @var string[]
    */
    protected $headers = [
        'Content-Type' => 'application/json'
    ];


    /**
     * HTTP status code - 200 (OK) by default
     *
     * @var int
    */
    protected $statusCode = 200;



    /**
     * Gets the value of statusCode
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


    /**
     * Set the value of statusCode
     *
     * @param int|null $statusCode
     * @return RestController
     */
    public function setStatusCode(?int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }


    /**
     * Returns a JSON response
     *
     * @param $data
     * @param array $headers
     * @return Response
     */
    public function respond($data, $headers = [])
    {
        return new Response($data, $this->getStatusCode(), $this->appendHeaders($headers));
    }


    /**
     * Sets an error message and returns a JSON response
     *
     * @param $errors
     * @param array $headers
     * @return Response
     */
    public function respondWithErrors($errors, $headers = [])
    {
        $data = [
            'errors' => $errors
        ];

        return $this->respond($data, $this->appendHeaders($headers));
    }


    /**
     * Returns a 401 Unauthorized http response
     *
     * @param string $message
     * @return Response
     */
    public function respondUnauthorized($message = 'Not authorized!')
    {
        return $this->setStatusCode(401)->respondWithErrors($message);
    }


    /**
     * @param array $headers
     * @return array
     */
    private function appendHeaders(array $headers)
    {
        return array_merge($this->headers, $headers);
    }
}
