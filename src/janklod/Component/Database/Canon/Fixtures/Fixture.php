<?php
namespace Jan\Component\Database\Canon\Fixtures;


use Jan\Component\Database\Contract\EntityManagerInterface;


/**
 * Class Fixture
 * @package Jan\Component\Database\Fixture
*/
abstract class Fixture
{
     /**
      * @param EntityManagerInterface $manager
      * @return mixed
     */
     abstract function load(EntityManagerInterface $manager);
}