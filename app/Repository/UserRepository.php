<?php
namespace App\Repository;


use App\Entity\User;
use Jan\Component\Database\Contract\ManagerInterface;
use Jan\Component\Database\ORM\Repository\ServiceRepository;



/**
 * Class UserRepository
 * @package App\Repository
*/
class UserRepository extends ServiceRepository
{

     /**
      * UserRepository constructor.
      * @param ManagerInterface $manager
     */
     public function __construct(ManagerInterface $manager)
     {
         parent::__construct($manager, User::class);
     }
}