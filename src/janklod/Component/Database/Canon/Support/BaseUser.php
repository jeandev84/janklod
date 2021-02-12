<?php
namespace Jan\Component\Database\Canon\Support;


/**
 * class BaseUser
 *
 * @package Jan\Component\Database\Doctrine\Support
*/
abstract class BaseUser
{

    /**
     * @var string
    */
    protected $id;



    /**
     * @var string
    */
    protected $email;



    /**
     * @var string
    */
    protected $password;



    /**
     * @var array
    */
    protected $roles = [];




    /**
     * @return string
    */
    public function getId(): string
    {
        return $this->id;
    }



    /**
     * @return string
    */
    public function getEmail(): string
    {
        return $this->email;
    }



    /**
     * @param string $email
     * @return BaseUser
    */
    public function setEmail(string $email): BaseUser
    {
        $this->email = $email;

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
     * @return BaseUser
    */
    public function setPassword(string $password): BaseUser
    {
        $this->password = $password;

        return $this;
    }




    /**
     * @return array
    */
    public function getRoles(): array
    {
        return $this->roles;
    }



    /**
     * @param array $roles
     * @return BaseUser
    */
    public function setRoles(array $roles): BaseUser
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @param $role
     * @return bool
    */
    public function hasRole($role)
    {
         return \in_array($role, $this->roles);
    }
}