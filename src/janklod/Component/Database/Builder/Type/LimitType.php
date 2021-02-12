<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;



/**
 * Class LimitType
 * @package Jan\Component\Database\Builder\Type
*/
class LimitType extends SqlType
{

    /**
     * @var string
    */
    protected $number;


    /**
     * @var string
    */
    protected $offset;


    /**
     * LimitType constructor.
     * @param int $start
     * @param int $offset
    */
    public function __construct(int $number, int $offset = 0)
    {
        $this->number  = $number;
        $this->offset = $offset;
    }


    /**
     * @return string|null
    */
    public function build(): ?string
    {
          $limit = sprintf('LIMIT %s', $this->number);

          if($this->offset)
          {
              $limit .= sprintf('%sOFFSET %s', ' ', $this->offset);
          }

          return $limit;
    }



    /**
     * @return string
    */
    public function getName(): string
    {
        return 'limit';
    }
}