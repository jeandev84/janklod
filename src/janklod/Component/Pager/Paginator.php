<?php
namespace Jan\Component\Pager;



/**
 * Class Paginator
 * @package Jan\Component\Database\Pager
*/
class Paginator
{


    /**
     * @var int
    */
    protected $currentPage;




    /**
     * @var int
    */
    protected $perPage;




    /**
     * @var int
    */
    protected $countItems;




    /**
     * @var array
    */
    protected $items = [];




    /**
     * get current page number
     *
     * @return int
    */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }



    /**
     * Set current page number
     *
     * @param int $currentPage
     * @return Paginator
    */
    public function setCurrentPage(int $currentPage): Paginator
    {
        $this->currentPage = $currentPage;

        return $this;
    }



    /**
     * @return int
    */
    public function getPerPage(): int
    {
        return $this->perPage;
    }




    /**
     * @param mixed $perPage
     * @return Paginator
    */
    public function setPerPage($perPage): Paginator
    {
        $this->perPage = $perPage;

        return $this;
    }




    /**
     * @return array
    */
    public function getItems(): array
    {
        return $this->items;
    }



    /**
     * @param array $items
     * @return Paginator
    */
    public function setItems(array $items): Paginator
    {
        $this->items = $items;

        return $this;
    }


    /**
     * @return int
    */
    public function getTotalItemCount(): int
    {
        return $this->countItems;
    }



//    /**
//     * @return false|float
//    */
//    public function getItemNumberPerPage()
//    {
//        return $this->perPage;
//    }


    /**
     * @return false|float
    */
    public function getTotalPages()
    {
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

        return $currentPage + 1;
    }
}