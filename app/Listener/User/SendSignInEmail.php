<?php
namespace App\Listeners\User;


use Jan\Component\Event\Contract\Event;
use Jan\Component\Event\Contract\Listener;


/**
 * Class SendSignInEmail
 *
 * @package App\Listeners\User
 */
class SendSignInEmail extends Listener
{
    /**
     * SendSigninEmail constructor.
     */
    /* public function __construct(SomeClassInject $classInject) { } */


    /**
     * @param Event $event
     */
    public function handle(Event $event)
    {
        # echo 'Send sign in email to '. $event->user->email;
        echo '<div>Send sign in email to '. $event->getUser()->getEmail() .
            '<strong> from '. __METHOD__.'</strong>
             </div>';
    }
}