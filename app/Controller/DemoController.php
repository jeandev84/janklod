<?php
namespace App\Controller;

use App\Entity\User;
use App\Listeners\User\SendSignInEmail;
use Jan\Component\Event\Dispatcher;
use Jan\Component\Event\Contract\Event;
use App\Events\User\UserSignedIn;
use App\Listeners\User\UpdateLastSignInDate;
use Jan\Component\Http\Response;
use Jan\Foundation\Routing\Controller;



/**
 * Class DemoController
 * @package App\Controller
*/
class DemoController extends Controller
{

     /**
      * event dispatcher
     */
     public function index(): Response
     {
        # User Entity
         $user = new User();
         $user->setId(1);
         $user->setEmail('jeanyao@ymail.com');


         # Dispatcher object and add listeners for specific event
         $dispatcher = new Dispatcher();

         $dispatcher->addListener('UserSignedIn', new SendSignInEmail());
         $dispatcher->addListener('UserSignedIn', new UpdateLastSignInDate());


         $event = new UserSignedIn($user);
         $dispatcher->dispatch($event);

         return new Response('Dispatched', 200);
     }
}