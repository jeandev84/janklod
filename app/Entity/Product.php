<?php
namespace App\Entity;



/**
 * Class User
 * @package App\Entity
 */
class Product
{

    /**
     * Идентификация пользователя
     *
     * @var int
     */
    private $id;



    /**
     * @var string
    */
    private $title;



    /**
     * @var string
    */
    private $description;



    /**
     * @var string
    */
    private $brochure;



    /**
     * ManyToOne
     * @var User
    */
    private $user;



    /**
     * @return int
    */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
    */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * @param string $title
     * @return Product
    */
    public function setTitle(string $title): Product
    {
        $this->title = $title;

        return $this;
    }


    /**
     * @return string
    */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * @param string $description
     * @return Product
    */
    public function setDescription(string $description): Product
    {
        $this->description = $description;

        return $this;
    }



    /**
     * @return string
    */
    public function getBrochure(): string
    {
        return $this->brochure;
    }



    /**
     * @param string $brochure
     * @return Product
    */
    public function setBrochure(string $brochure): Product
    {
        $this->brochure = $brochure;

        return $this;
    }


    /**
     * @param User $user
    */
    public function setUser(User $user)
    {
         $this->user = $user;
    }


    /**
     * @return User
    */
    public function getUser(): User
    {
        return $this->user;
    }
}