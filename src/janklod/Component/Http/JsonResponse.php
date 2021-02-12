<?php
namespace Jan\Component\Http;



/**
 * Class JsonResponse
 * @package Jan\Component\Http
*/
class JsonResponse extends Response
{
    /**
     * @var string[]
    */
    protected $headers = [
        'Content-Type' => 'application/json'
    ];


    /**
     * JsonResponse constructor.
     * @param $data
     * @param int $status
     * @param array $headers
    */
    public function __construct($data, int $status = 200, array $headers = [])
    {
        $headers = array_merge($this->headers, $headers);

        parent::__construct(json_encode($data), $status, $headers);
    }
}