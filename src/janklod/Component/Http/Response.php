<?php
namespace Jan\Component\Http;



/**
 * Class Response
 * @package Jan\Component\Http
 */
class Response implements ResponseInterface
{

    use StatusCode;

    const HTTP_OK = '200';
    const HTTP_BAD_REQUEST = '400';


    /**
     * @var string
     *
     * Example HTTP/1.0
    */
    protected $protocolVersion;


    /**
     * @var string
    */
    protected $content;



    /**
     * @var int
    */
    protected $status;


    /**
     * @var array
    */
    protected $headers = [];


    /**
     * Response constructor.
     *
     * @param string|null $content
     * @param int $status
     * @param array $headers
     */
    public function __construct(?string $content = null, int $status = 200, array $headers = [])
    {
        $this->setContent($content);
        $this->setStatus($status);
        $this->setHeaders($headers);
        $this->setProtocol('HTTP/1.0');
    }


    /**
     * Set protocol version
     *
     * @param string $protocolVersion
     * @return Response
    */
    public function setProtocol(string $protocolVersion): Response
    {
        $this->protocolVersion = $protocolVersion;

        return $this;
    }


    /**
     * Set content
     *
     * @param string $content
    */
    public function setContent($content)
    {
        $this->content = $content;
    }


    /**
     * Set status
     *
     * @param int $status
    */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }


    /**
     * Set headers
     *
     * @param array $key
     * @param null $value
     * @return Response
    */
    public function setHeaders($key, $value = null)
    {
        foreach ($this->parseHeaders($key, $value) as $key => $value)
        {
            $this->headers[$key] = $value;
        }
    }


    /**
     * Set protocol version
     *
     * @param string $protocolVersion
     * @return $this
    */
    public function withProtocol($protocolVersion): Response
    {
        $this->setProtocol($protocolVersion);

        return $this;
    }


    /**
     * Get protocol version
     *
     * @return string
    */
    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }


    /**
     * Set body
     *
     * @param string $content
     * @return Response
    */
    public function withBody($content): Response
    {
        $this->setContent($content);

        return $this;
    }


    /**
     * @return string
     */
    public function getBody(): string
    {
        return (string) $this->content;
    }


    /**
     * @param array $data
     * @return $this
    */
    public function withJson(array $data): Response
    {
        $content = \json_encode($data);
        $this->setHeaders(['Content-Type' => 'application/json']);
        $this->setContent($content);

        return $this;
    }


    /**
     * Set status code
     *
     * @param int $status
     * @return Response
     */
    public function withStatus($status): Response
    {
        $this->setStatus($status);

        return $this;
    }


    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }


    /**
     * Set Headers
     *
     * @param $key
     * @param null $value
     * @return Response
     */
    public function withHeaders($key, $value = null)
    {
        $this->setHeaders($key, $value);

        return $this;
    }



    /**
     * @return array
    */
    public function getHeaders()
    {
        return $this->headers;
    }



    /**
     * TODO Refactoring
     * @return mixed
    */
    public function sendHeaders()
    {
        // move this to other logic
        foreach ($this->headers as $key => $value)
        {
            header(is_numeric($key) ? $value : $key . ': ' . $value);
        }
    }



    /**
     * send headers to the server
     *
     * @return mixed
    */
    public function send()
    {
        if(headers_sent())
        {
            return $this;
        }

        /*
        if(php_sapi_name() == 'cli')
        {
            return false;
        }
        */

        $this->sendStatusMessage();
        $this->sendHeaders();
    }


    /**
     * show body
    */
    public function sendBody()
    {
        echo $this->content;
    }


    /**
     * @return $this
    */
    public function sendStatusMessage()
    {
        $message = $this->messages[$this->status] ?? '';

        /* http_response_code($this->status); */

        if($message)
        {
            $this->withHeaders(sprintf('%s %s %s', $this->protocolVersion, $this->status, $message));
        }

        return $this;
    }


    /**
     * @param $key
     * @param $value
     * @return array
    */
    protected function parseHeaders($key, $value = null): array
    {
        if(is_string($key) && ! $value)
        {
            return (array) $key;
        }

        return \is_array($key) ? $key : [$key => $value];
    }


    /**
     * For echo response object has string
     *
     * @return string
    */
    public function __toString()
    {
         return $this->getBody();
    }
}