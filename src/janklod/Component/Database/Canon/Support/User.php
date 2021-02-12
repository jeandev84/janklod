<?php
namespace Jan\Component\Database\Canon\Support;


use Jan\Component\Database\Canon\Contract\UserInterface;


/**
 * class User ( user contract )
 *
 * @package Jan\Component\Database\Canon\Support
*/
abstract class User implements UserInterface
{

    /**
     * @var string
    */
    protected $id;



    /**
     * @var string
    */
    protected $username;



    /**
     * @var string
    */
    protected $email;



    /**
     * @var string
    */
    protected $password;



    /**
     * @var string
    */
    protected $plainPassword;



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
    public function getUsername(): string
    {
        return $this->username;
    }



    /**
     * @param string $username
     * @return User
    */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
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
     * @return User
    */
    public function setEmail(string $email): User
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
     * @return User
    */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }



    /**
     * @return string
    */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }



    /**
     * @param string $plainPassword
     * @return User
    */
    public function setPlainPassword(string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;

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
     * @return User
    */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }



    /**
     * @param $role
     * @return bool
    */
    public function hasRole($role): bool
    {
         return \in_array($role, $this->getRoles());
    }


    // salt, confirm_password, token, credentials ...
}