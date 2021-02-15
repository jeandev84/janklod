<?php
namespace Jan\Component\Service\Mailer;


/**
 * Class MailerMessage
 * @package Jan\Component\Service\Mailer
 */
class MailerMessage
{

    /**
     * @var string|array
    */
    protected $to = 'demo@gmail.com';



    /**
     * @var string
    */
    protected $from = 'nobody@gmail.com';



    /**
     * @var string
    */
    protected $cc = 'test@gmail.com';



    /**
     * @var string
    */
    protected $bcc = 'test@gmail.com';




    /**
     * @var string
    */
    protected $subject = 'test subject';



    /**
     * @var string
    */
    protected $body = 'some message';


    /**
     * @var string
    */
    protected $replyTo = 'no-reply@gmail.com';



    /**
     * @var string[]
    */
    protected $contentType = 'text/html';



    /**
     * @var string
    */
    protected $charset = 'UTF-8'; // iso-8859-1



    /**
     * @var string
    */
    protected $mimeVersion = '1.0';


    /**
     * @var
    */
    protected $attachment = 'demo.zip';


    /**
     * @var array
    */
    protected $params = [];



    /**
     * @return string
    */
    public function getTo(): string
    {
        return $this->to;
    }


    /**
     * @param string|array $to
     * @return MailerMessage
    */
    public function setTo($to): MailerMessage
    {
        $to = \is_array($to) ? implode(',', $to) : (string) $to;
        $this->to = $to;

        return $this;
    }


    /**
     * @return string
    */
    public function getFrom(): string
    {
        return $this->from;
    }



    /**
     * @param string $from
     * @return MailerMessage
    */
    public function setFrom(string $from): MailerMessage
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return string|null
    */
    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }



    /**
     * @param string $replyTo
     * @return MailerMessage
    */
    public function setReplyTo(string $replyTo): MailerMessage
    {
        $this->replyTo = $replyTo;

        return $this;
    }



    /**
     * @return string|null
    */
    public function getCc(): ?string
    {
        return $this->cc;
    }


    /**
     * @param string $cc
     * @return MailerMessage
    */
    public function setCc(string $cc): MailerMessage
    {
        $this->cc = $cc;

        return $this;
    }



    /**
     * @return string|null
    */
    public function getBcc(): ?string
    {
        return $this->bcc;
    }


    /**
     * @param string $bcc
     * @return MailerMessage
    */
    public function setBcc(string $bcc): MailerMessage
    {
        $this->bcc = $bcc;

        return $this;
    }



    /**
     * @return string
    */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return MailerMessage
     */
    public function setSubject(string $subject): MailerMessage
    {
        $this->subject = $subject;

        return $this;
    }



    /**
     * @return string
    */
    public function getBody(): string
    {
        return $this->body;
    }



    /**
     * @param string $body
     * @return MailerMessage
     */
    public function setBody(string $body): MailerMessage
    {
        $this->body = $body;

        return $this;
    }


    /**
     * @return string[]
    */
    public function getContentType()
    {
        return $this->contentType;
    }


    /**
     * @param string $contentType
     * @return MailerMessage
    */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }



    /**
     * @return string
    */
    public function getCharset(): string
    {
        return $this->charset;
    }



    /**
     * @param string $charset
     * @return MailerMessage
    */
    public function setCharset(string $charset): MailerMessage
    {
        $this->charset = $charset;

        return $this;
    }



    /**
     * @return string
    */
    public function getMimeVersion(): string
    {
        return $this->mimeVersion;
    }



    /**
     * @param string $mimeVersion
     * @return MailerMessage
    */
    public function setMimeVersion(string $mimeVersion): MailerMessage
    {
        $this->mimeVersion = $mimeVersion;

        return $this;
    }


    /**
     * @return string
    */
    public function getParams()
    {
        if(! $this->params)
        {
            return '';
        }

        return implode($this->params);
    }


    /**
     * @param array $params
     * @return MailerMessage
    */
    public function setParams(array $params): MailerMessage
    {
        $this->params = $params;

        return $this;
    }


    /**
     * @return string
    */
    public function getHeaders()
    {
        $headers[] = 'MIME-Version: '. $this->getMimeVersion();
        $headers[] = sprintf('Content-type: %s; charset=%s',
            $this->getContentType(),
            $this->getCharset()
        );

        $headers[] = 'To: '. $this->getTo();
        $headers[] = sprintf('From: %s <%s>',
                     $this->getFrom(),
                     $this->getFrom()
        );
        $headers[] = sprintf('Reply-To: %s <%s>',
            $this->getReplyTo(),
            $this->getReplyTo()
        );
        $headers[] = 'Cc: '. $this->getCc();
        $headers[] = 'Bcc: '. $this->getBcc();

        return implode("\r\n", $headers);
    }

    /**
     * @return mixed
     */
    public function getAttach()
    {
        return $this->attachment;
    }


    /**
     * @param MailerAttachment $attachment
     * @return MailerMessage
    */
    public function attach(MailerAttachment $attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

}