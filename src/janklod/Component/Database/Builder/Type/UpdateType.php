<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;


/**
 * Class UpdateType
 * @package Jan\Component\Database\Builder\Type
*/
class UpdateType extends SqlType
{
     /**
      * UpdateType constructor.
      *
      * @param array $attributes
     */
     public function __construct(array $attributes = [])
     {
         $this->setAttributes($attributes);
     }


     /**
      * @return string|null
     */
     public function build(): ?string
     {
         $sql = sprintf('UPDATE %s', $this->getTableSQL());

         if($this->attributes)
         {
              $sql .= sprintf('%s%s', ' ',
                  $this->setSQL()
              );
         }

         return $sql;
     }


     /**
      * @return bool
     */
     public function resetPreviousSQL(): bool
     {
          return true;
     }


     /**
      * @return string
     */
     public function getName(): string
     {
        return 'update';
     }


    /**
     * @return bool
    */
    public function isBaseSQL()
    {
        return true;
    }
}