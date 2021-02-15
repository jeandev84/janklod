<?php
namespace Jan\Component\Service\Mailer;


/**
 * Class MailerAttachment
 * @package Jan\Component\Service\Mailer
*/
class MailerAttachment
{

    protected $filename;


    /**
     * SoftMailerAttachment constructor.
     * @param string $filename
    */
    public function __construct($filename = '')
    {
         $this->filename = $filename;
    }


    /**
     * @param $filename
     * @return $this
    */
    public function setFilename($filename)
    {
         $this->filename = $filename;

         return $this;
    }


    /**
     * @param $filename
     * @return static
    */
    public static function fromPath($filename)
    {
        $attachment = new static();
        $attachment->setFilename($filename);
        return $attachment;
    }
}