<?php
namespace Jan\Component\Service\Mailer;


use Jan\Component\Mailer\Contract\MailTransportInterface;



/**
 * Class MailerTransport
 * @package Jan\Component\Service\Mailer
*/
class MailerTransport implements MailTransportInterface
{

      /**
       * @var string
      */
      protected $host = 'http://smtp.mailtrap.io';


      /**
       * @var int
      */
      protected $port = 2525;



      /**
       * @var string
      */
      protected $username;



      /**
       * @var string
      */
      protected $password;


      /**
        * MailerTransport constructor.
        * @param string $host
        * @param string $port
      */
      public function __construct($host = '', $port = '')
      {
            if($host)
            {
                $this->setHost($host);
            }

            if($port)
            {
                $this->setPort($port);
            }
      }



      /**
       * @return string
      */
      public function getHost(): string
      {
          return $this->host;
      }



    /**
     * @param string $host
     * @return MailerTransport
    */
    public function setHost(string $host): MailerTransport
    {
        $this->host = $host;

        return $this;
    }



    /**
     * @return int
    */
    public function getPort(): int
    {
        return $this->port;
    }



    /**
     * @param int $port
     * @return MailerTransport
    */
    public function setPort(int $port): MailerTransport
    {
        $this->port = $port;

        return $this;
    }



    /**
     * @return string
    */
    public function getUsername(): string
    {
        return $this->username;
    }



    /**
     * @param string $username
     * @return MailerTransport
    */
    public function setUsername(string $username): MailerTransport
    {
        $this->username = $username;

        return $this;
    }


    /**
     * @return string
    */
    public function getPassword(): string
    {
        return $this->password;
    }


    /**
     * @param string $password
     * @return MailerTransport
    */
    public function setPassword(string $password): MailerTransport
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @return string
    */
    public function getBaseUrl(): string
    {
        return '';
    }
}