<?php
namespace App\Model;


use Jan\Component\Database\Capsule\ORM\Model;


/**
 * Class User
 * @package App\Model
*/
class User extends Model
{

    /**
     * @var string
    */
    protected $table = 'users';



    /**
     * @var string[]
    */
    protected $guarded = ['id', '_token'];



    /**
     * @var array
    */
    protected $hidden = ['password'];
}