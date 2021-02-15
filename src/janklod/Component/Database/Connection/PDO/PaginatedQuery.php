<?php
namespace Jan\Component\Database\Connection\PDO;


use Jan\Component\Database\Contract\PaginatedQueryInterface;
use Jan\Component\Database\Contract\QueryInterface;



/**
 * class PaginatedQuery
 *
 * @package Jan\Component\Database\Connection\PDO
*/
class PaginatedQuery implements PaginatedQueryInterface
{

      /**
        * @var QueryInterface
      */
      protected $query;


      /**
       * @var int
      */
      protected $currentPage;




      /**
        * @var
      */
      protected $perPage;




      /**
       * @var array
      */
      protected $items = [];



      /**
       * @var int
      */
      protected $countItems;



      /**
       * @param QueryInterface $query
      */
      public function setQuery(QueryInterface $query)
      {
          $this->query = $query;
      }



      /**
       * @param int $currentPage
      */
      public function setCurrentPage(int $currentPage)
      {
          $this->currentPage = $currentPage;
      }


      /**
       * @param int $perPage
      */
      public function setPerPage(int $perPage)
      {
          $this->perPage = $perPage;
      }



      /**
       * PaginatedQuery constructor.
       * @param QueryInterface|null $query
       * @param int $currentPage
       * @param int $perPage
       * @return PaginatedQuery
      */
      public function paginate(QueryInterface $query, int $currentPage = 1, int $perPage = 3)
      {
           $instance = new static();
           $instance->setQuery($query);
           $instance->setCurrentPage($currentPage);
           $instance->setPerPage($perPage);
           return $instance;
      }



      /**
       * @return int
      */
      public function getCurrentPage(): int
      {
          return $this->currentPage;
      }




      /**
       * Get items
      */
      public function getItems(): array
      {
           if(! $this->items)
           {
                $currentPage = $this->getCurrentPage();
                $pages = $this->getTotalPages(); // dd($pages)

                if($currentPage > $pages)
                {
                    throw new \Exception('This page doest not exist!');
                }

                $offset = $this->perPage * ($currentPage - 1);

                $sql = $this->query->getSQL();
                $sql .= " LIMIT {$this->perPage} OFFSET $offset";

                $this->items = $this->query->setSQL($sql)
                                           ->execute()
                                           ->getResult();
           }

           return $this->items;
      }



      /**
       * @return false|float
      */
      public function getTotalPages()
      {
          $queryCount = 6;

          if(! $this->countItems)
          {
               $this->countItems = (int) $queryCount;
          }

          return ceil($this->countItems / $this->perPage);
      }



      /**
        * @return int|null
      */
      public function previousLink(): ?int
      {
          $currentPage = $this->getCurrentPage();

          if($currentPage <= 1)
          {
               return null;
          }


          if($currentPage > 2)
          {
              return ($currentPage - 1);
          }
      }



      /**
       * @return int|null
      */
      public function nextLink(): ?int
      {
          $currentPage = $this->getCurrentPage();

          if($currentPage >= $this->getTotalPages())
          {
               return null;
          }

          return $this->getCurrentPage() + 1;
      }
}