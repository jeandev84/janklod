<?php
namespace Jan\Component\Http;


/**
 * Class RedirectResponse
 * @package Jan\Component\Http
*/
class RedirectResponse
{

    /**
     * @var string
    */
    protected $path;



    /**
     * @var int
    */
    protected $statusCode;



    /**
     * @var string
    */
    protected $message;



    /**
     * RedirectResponse constructor.
     * @param string $path
    */
    public function __construct(string $path)
    {
         $this->path = $path;
    }



    /**
     * @param int $code
     * @param string $message
    */
    public function setStatusCode(int $code, string $message)
    {
        $this->statusCode = $code;
        $this->message = $message;
    }



    /**
     * Send headers
    */
    public function send()
    {
         // set code and message
         http_response_code($this->statusCode);
         header('Location: '. $this->path);
         // echo $this->redirectTemplate();
         exit;
    }


    /**
     * @return string
    */
    protected function redirectTemplate()
    {
        return "<!DOCTYPE html>
                   <html>
                       <head>
                           <meta charset='UTF-8'>
                           <meta>
                       </head>
                       <body>
                          <h1>Redirect to {$this->path}</h1>
                       </body>
                   </html>
               ";
    }
}