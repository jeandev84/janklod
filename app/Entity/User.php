<?php
namespace App\Entity;


use Jan\Component\Helper\Collection\ArrayCollection;

/**
 * Class User
 * @package App\Entity
*/
class User
{

      /**
       * Идентификация пользователя
       *
       * @var int
      */
      private $id;



      /**
       * Фамилия
       *
       * @var string
      */
      private $surname;


      /**
       * Имя
       * @var string
      */
      private $name;


      /**
       * Отчество
       *
       * @var string
      */
      private $patronymic;


      /**
       * Электронная почта
       *
       * @var string
      */
      private $email;



      /**
       * Пароль
       *
       * @var string
      */
      private $password;



      /**
       * Регион
       *
       * @var string
      */
      private $region;



      /**
       * @var string
      */
      private $hobbies;



      /**
       * @var string
      */
      private $sex;



      /**
       * OneToMany
       * @var Product[]
      */
      private $products = [];



      /**
       * User constructor.
      */
      public function __construct()
      {
          $this->products = new ArrayCollection();
      }


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
      public function getEmail(): string
      {
          return $this->email;
      }


      /**
       * @param string $email
       *
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
     public function getSurname(): string
     {
         return $this->surname;
     }



    /**
     * @param string $surname
     * @return User
    */
    public function setSurname(string $surname): User
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }



    /**
     * @param string $name
     * @return User
    */
    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return string
    */
    public function getPatronymic(): string
    {
        return $this->patronymic;
    }


    /**
     * @param string $patronymic
     * @return User
    */
    public function setPatronymic(string $patronymic): User
    {
        $this->patronymic = $patronymic;

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
    public function getRegion(): string
    {
        return $this->region;
    }


    /**
     * @param string $region
     * @return User
    */
    public function setRegion(string $region): User
    {
        $this->region = $region;

        return $this;
    }


    /**
     * @return string
    */
    public function getHobbies(): string
    {
        return $this->hobbies;
    }



    /**
     * @param string $hobbies
     * @return User
    */
    public function setHobbies(string $hobbies): User
    {
        $this->hobbies = $hobbies;

        return $this;
    }



    /**
     * @return string
    */
    public function getSex(): string
    {
        return $this->sex;
    }



    /**
     * @param string $sex
     * @return User
    */
    public function setSex(string $sex): User
    {
        $this->sex = $sex;

        return $this;
    }



    /**
     * @param Product $product
     * @return User
    */
    public function addProduct(Product $product): User
    {
         if(! $this->products->contains($product))
         {
              $this->products[] = $product;
              $product->setUser($this);
         }

         return $this;
    }



    /**
     * @param Product $product
    */
    public function removeProduct(Product $product)
    {
         // remove product
    }


    /**
     * @return Product[]|ArrayCollection
    */
    public function getProducts()
    {
        return $this->products;
    }
}