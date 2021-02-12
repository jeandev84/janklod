<?php
namespace Jan\Component\Database\Contract;


/**
 * Interface EntityRepositoryInterface
 *
 * @package Jan\Component\Database\Contract
*/
interface EntityRepositoryInterface
{
     public function find($id);
     public function findBy($criteria);
     public function findOne($criteria);
}