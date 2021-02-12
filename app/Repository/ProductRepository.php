<?php
namespace App\Repository;


use App\Entity\Product;
use Jan\Component\Database\Contract\ManagerInterface;
use Jan\Component\Database\ORM\Repository\ServiceRepository;

/**
 * Class ProductRepository
 * @package App\Repository
*/
class ProductRepository extends ServiceRepository
{

      /**
       * ProductRepository constructor.
       * @param ManagerInterface $manager
      */
      public function __construct(ManagerInterface $manager)
      {
            parent::__construct($manager, Product::class);
      }
}