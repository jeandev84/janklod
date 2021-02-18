<?php
namespace Jan\Component\Service\Mail\Header;


use Jan\Component\Service\Mail\Contract\HeaderBuilderInterface;

/**
 * Class MimePart
 * @package Jan\Component\Service\Mailer\Header
*/
class MimePart implements HeaderBuilderInterface
{

     /**
      * @var string
     */
     protected $contentType = 'text/html';


     /**
      * @var string
     */
     protected $charset = 'UTF-8';



     /**
      * MimePart constructor.
      * @param $contentType
      * @param $charset
     */
     public function __construct($contentType, $charset)
     {
         $this->contentType = $contentType;
         $this->charset = $charset;
     }


     /**
       * string
     */
     public function build()
     {
        // TODO: Implement build() method.
     }
}