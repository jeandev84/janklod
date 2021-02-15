<?php
namespace App\Events\User;


use App\Entity\User;
use Jan\Component\Event\Contract\Event;



/**
 * Class UserSignedIn
 * @package App\Events\User
 */
class UserSignedIn extends Event
{

    /** @var User  */
    private $user;


    /**
     * UserSignedIn constructor.
     *
     * @param User $user
    */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * @return User
    */
    public function getUser()
    {
        return $this->user;
    }
}