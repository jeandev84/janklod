<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;


/**
 * Class GroupByType
 * @package Jan\Component\Database\Builder\Type
*/
class GroupByType extends SqlType
{

     /**
      * @var string
     */
     private string $column;


     /**
      * GroupByType constructor.
      * @param string $column
     */
     public function __construct(string $column)
     {
          $this->column = $column;
     }


     /**
      * @return string|null
     */
     public function build(): ?string
     {
         return sprintf('GROUP BY %s', $this->column);
     }


    /**
     * @return string
    */
    public function getName(): string
    {
         return 'groupBy';
    }
}