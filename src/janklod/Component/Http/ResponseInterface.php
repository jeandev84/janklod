<?php
namespace Jan\Component\Http;


/**
 * Interface ResponseInterface
 * @package Jan\Component\Http
*/
interface ResponseInterface
{

     /**
      * Set body
      *
      * @param $content
      * @return mixed
     */
     public function withBody($content);



     /**
      * Set status code
      *
      * @param int $status
      * @return mixed
     */
     public function withStatus($status);



     /**
      * Set headers
      *
      * @param $headers
      * @return mixed
     */
     public function withHeaders($headers);


     /**
      * @param $version
      * @return mixed
     */
     public function withProtocol($version);



     /**
      * Send headers
      *
      * @return mixed
     */
     public function send();

}