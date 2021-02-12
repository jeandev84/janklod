<?php
namespace App\Listeners\User;


use Jan\Component\Event\Contract\Event;
use Jan\Component\Event\Contract\Listener;


/**
 * Class UpdateLastSignInDate
 *
 * @package App\Listeners\User
 */
class UpdateLastSignInDate extends Listener
{

    /**
     * @param Event $event
     */
    public function handle(Event $event)
    {
        # echo 'Update record in database with ID of '. $event->user->id;
        echo '<div>Update record in database with ID of '. $event->getUser()->getId().
            '<strong> from '. __METHOD__.'</strong>
             </div>';
    }
}