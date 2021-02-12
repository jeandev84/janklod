<?php
namespace Jan\Component\Database\Builder\Support;


use Jan\Component\Database\Contract\QueryBuilderInterface;


/**
 * Class SqlType
 * @package Jan\Component\Database\Builder\Support
*/
abstract class SqlType
{


      /**
       * @var string
      */
      protected $table;



      /**
        * @var string
      */
      protected $alias;



     /**
      * @var array
     */
     protected $attributes = [];




    /**
       * @param string $table
       * @param string $alias
      */
      public function setTable($table)
      {
           $this->table = $table;
      }


      /**
       * @param $alias
      */
      public function setAlias($alias)
      {
          $this->alias = $alias;
      }


      /**
       * @param array $attributes
      */
      public function setAttributes(array $attributes)
      {
           $this->attributes = $attributes;
      }


      /**
        * @return array
        * @throws \Exception
      */
      public function getAttributes()
      {
          if(! $this->attributes)
          {
              throw new \Exception('no attributes for sql type ('. get_class($this) .')');
          }

          return $this->attributes;
      }



      /**
        * @return array
        * @throws \Exception
      */
      public function getAttributesFields()
      {
          return array_keys($this->filteredAttributes());
      }


      /**
       * @return array
       * @throws \Exception
      */
      public function getAttributeValues()
      {
          return array_values($this->getAttributes());
      }


      /**
       * @return string
      */
      public function getTableSQL()
      {
          $table = sprintf('`%s`', $this->table);

          if($this->alias)
          {
              /* sprintf('%s AS %s', $table, $this->alias); */
              return sprintf('%s %s', $table, $this->alias);
          }

          return $table.' ';
      }



      /**
       * @return false
      */
      public function resetPreviousSQL()
      {
           return false;
      }


      /**
       * @param array $columns
       * @param string $default
       * @return string
      */
      public function buildSelectedColumns(array $columns)
      {
          $fields = [];

          foreach ($columns as $field)
          {
               $selectedWithAlias = sprintf('`%s`.`%s`', $this->alias, $field);
               $fields[] = $this->alias ? $selectedWithAlias : '`'. $field .'`';
          }

          return implode(', ', $fields);
      }


      /**
       * @param array $columns
       * @return string
      */
      protected function buildColumnAssignment(array $columns)
      {
          $fields = [];

          foreach ($columns as $column)
          {
              array_push($fields, sprintf("`%s` = :{$column}", $column));
          }

          return join(', ', $fields);
      }


      /**
       * @return false
      */
      public function isBaseSQL()
      {
            return false;
      }


      /**
       * @return false
      */
      public function isConditional()
      {
           return false;
      }


      /**
       * @return string
       * @throws \Exception
      */
      protected function setSQL()
      {
          return sprintf('SET %s',
              $this->buildColumnAssignment($this->getAttributesFields())
          );
      }



     /**
      * @return array
     */
     protected function filteredAttributes()
     {
         return array_filter($this->attributes, function ($key) {

             return ! is_numeric($key);

         }, ARRAY_FILTER_USE_KEY);
     }


     /**
       * @return string|null
     */
     abstract public function build(): ?string;



     /**
       * @return string
     */
     abstract public function getName(): string;
}