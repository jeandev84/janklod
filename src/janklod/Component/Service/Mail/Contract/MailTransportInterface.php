<?php
namespace Jan\Component\Service\Mail\Contract;


/**
 * Interface MailTransportInterface
 * @package Jan\Component\Service\Mailer\Contract
*/
interface MailTransportInterface
{

    /**
     * @return string
    */
    public function getHost();



    /**
     * @return string
    */
    public function getPort();



    /**
     * @return string
    */
    public function getUsername();


    /**
     * @return string
    */
    public function getPassword();
}