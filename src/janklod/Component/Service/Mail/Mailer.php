<?php
namespace Jan\Component\Service\Mail;


use Jan\Component\Service\Mail\Contract\MailTransportInterface;


/**
 * Class Mailer
 * @package Jan\Component\Service\Mailer
*/
class Mailer
{

     /**
      * @var MailTransportInterface
     */
     protected $transport;


     /**
      * Mailer constructor.
      * @param MailTransportInterface|null $transport
     */
     public function __construct(MailTransportInterface $transport = null)
     {
           if($transport)
           {
               $this->setTransport($transport);
           }
     }


     /**
      * @param MailTransportInterface $transport
      * @return $this
     */
     public function setTransport(MailTransportInterface $transport)
     {
          $this->transport = $transport;

          return $this;
     }


     /**
      * @param MailerMessage $message
      * @return bool
     */
     public function send(MailerMessage $message)
     {
         // set mail transport


         // send mail to user
         $status = mail(
             $message->getTo(),
             $message->getSubject(),
             $message->getBody(),
             $message->getHeaders(),
             $message->getParams()
         );

         $errorMessage = null;
         $errorLast = [];

         if(! $status)
         {
             if($errorLast = error_get_last())
             {
                 $errorMessage = $errorLast['message'];
                 dd($errorMessage);
             }

             dump('message no sent', 'false');
             return false;
         }

         dump('message sent', 'true');
         return true;
     }
}