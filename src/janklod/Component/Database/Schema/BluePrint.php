<?php
namespace Jan\Component\Database\Schema;


use Exception;

/**
 * Class BluePrint
 * @package Jan\Component\Database\Schema
*/
class BluePrint
{

    const __COLUMN_SPACE__    = ' ';
    const KEY_DEFAULT_COLUMN  = 'default';
    const KEY_ADD_COLUMN      = 'add';
    const KEY_MODIFIED_COLUMN = 'modified';
    const KEY_DROP_COLUMN     = 'drop';


    /**
     * @var string
    */
    private $table;


    /**
     * @var string
    */
    private $primary = '';



    /**
     * @var array
    */
    private $columns = [];



    /**
     * BluePrint constructor.
     * @param string|null $table
    */
    public function __construct(string $table = null)
    {
         if($table)
         {
             $this->setTable($table);
         }
    }


    /**
     * @param string $table
    */
    public function setTable(string $table)
    {
        $this->table = $table;
    }



    /**
     * @param $name
     * @param $type
     * @param int $length
     * @param null $default
     * @param bool $autoincrement
     * @return Column
     * @throws Exception
    */
    public function addDefaultColumn($name, $type, $length = 11, $default = null, $autoincrement = false): Column
    {
        $column = new Column(
           compact('name', 'type', 'length', 'default', 'autoincrement')
        );

        if($autoincrement)
        {
           $this->primary = $name;
        }

        return $this->columns[self::KEY_DEFAULT_COLUMN][] = $column;
    }


    /**
     * Alter column
     *
     * @param $name
     * @param $type
     * @param int $length
     * @return Column
     * @throws Exception
    */
    public function addColumn($name, $type, $length = 11): Column
    {
       $column = new Column(
           compact('name', 'type', 'length')
       );

       return $this->columns[self::KEY_ADD_COLUMN][] = $column;
    }


    /**
     * Drop column
     *
     * @param $name
     * @return Column
     * @throws Exception
    */
    public function dropColumn($name): Column
    {
        $column = new Column(compact('name'));

        return $this->columns[self::KEY_DROP_COLUMN][] = $column;
    }


    /**
     * Drop column
     *
     * @param $name
     * @param $type
     * @param int $length
     * @return Column
     * @throws Exception
    */
    public function modifyColumn($name, $type, $length = 11): Column
    {
        $column = new Column(compact('name', 'type', 'length'));

        return $this->columns[self::KEY_MODIFIED_COLUMN][] = $column;
    }



    /**
     * @return bool|string
   */
   public function getPrimary()
   {
       return $this->primary;
   }


   /**
     * @param $name
     * @return Column
     * @throws Exception
   */
   public function increments($name): Column
   {
       return $this->addDefaultColumn($name, 'INT', 11, null, true);
   }


   /**
     * @param $name
     * @param int $length
     * @return Column
     * @throws Exception
   */
   public function integer($name, $length = 11): Column
   {
       return $this->addDefaultColumn($name, 'INT', $length);
   }


   /**
     * @param $name
     * @param int $length
     * @return Column
     * @throws Exception
   */
   public function string($name, $length = 255): Column
   {
       return $this->addDefaultColumn($name, 'VARCHAR', $length);
   }


   /**
     * @param $name
     * @return Column
     * @throws Exception
   */
   public function boolean($name): Column
   {
       return $this->addDefaultColumn($name, 'TINYINT', 1, 0);
   }


   /**
     * @param $name
     * @return Column
     * @throws Exception
   */
   public function text($name): Column
   {
       return $this->addDefaultColumn($name, 'TEXT', false);
   }


   /**
     * @param $name
     * @return Column
     * @throws Exception
   */
   public function datetime($name): Column
   {
       return $this->addDefaultColumn($name, 'DATETIME', false);
   }


   /**
     * @throws Exception
   */
   public function timestamps()
   {
        $this->datetime('created_at');
        $this->datetime('updated_at');
   }


   /**
     * @return array
   */
   public function columns(): array
   {
       return $this->columns;
   }


   /**
     * @param bool $status
     * @throws Exception
   */
   public function softDeletes(bool $status = false)
   {
       if($status)
       {
           $this->boolean('deleted_at');
       }
   }


   /**
    * @return string
   */
   public function buildDefaultColumnSql(): string
   {
      $sql = [];
      $nbrColumns = count($this->columns[self::KEY_DEFAULT_COLUMN]);
      $i = 0;

      if(! empty($this->columns[self::KEY_DEFAULT_COLUMN]))
      {
          /** @var Column $column */
          foreach ($this->columns[self::KEY_DEFAULT_COLUMN] as $column)
          {
              $sql[] = '`'. $column->getName() . '`'. self::__COLUMN_SPACE__;
              $sql[] = $column->getTypeAndLength() . self::__COLUMN_SPACE__;
              $sql[] = $column->getDefaultValue();

              if($autoinc = $column->getAutoincrement())
              {
                  $sql[] = self::__COLUMN_SPACE__;
              }

              $sql[] = $autoinc;

              ++$i;

              if($i < $nbrColumns)
              {
                  $sql[] = ', ';
              }
          }

          if($primaryKey = $this->getPrimary())
          {
              $sql[] = sprintf(', PRIMARY KEY(`%s`)', $primaryKey);
          }
      }

      return  implode($sql);
   }


   /**
     * @return string
   */
   public function  buildAddColumnSql(): string
   {
       $sql = [];

       /** @var Column $column */
       if(! empty($this->columns[self::KEY_ADD_COLUMN]))
       {
           foreach ($this->columns[self::KEY_ADD_COLUMN] as $column)
           {
               $sql[] = sprintf('ALTER TABLE %s ADD COLUMN %s %s;',
                   $this->table,
                   $column->getName(),
                   $column->getTypeAndLength()
               );
           }

       }

       return join($sql);
   }


   /**
     * @return string
   */
   public function buildDropColumnSql(): string
   {
       $sql = [];

       /** @var Column $column */
      if(! empty($this->columns[self::KEY_DROP_COLUMN]))
      {
          foreach ($this->columns[self::KEY_DROP_COLUMN] as $column)
          {
              $sql[] = sprintf('ALTER TABLE %s DROP COLUMN %s;',
                  $this->table,
                  $column->getName()
              );
          }

      }
       return join($sql);
   }


    /**
     * @return string
    */
    public function buildModifyColumnSql(): string
    {
        $sql = [];

        /** @var Column $column */
        if(! empty($this->columns[self::KEY_MODIFIED_COLUMN]))
        {
            foreach ($this->columns[self::KEY_MODIFIED_COLUMN] as $column)
            {
                $sql[] = sprintf('ALTER TABLE %s MODIFY COLUMN %s %s;',
                    $this->table,
                    $column->getName(),
                    $column->getTypeAndLength()
                );
            }
        }

        return join($sql);
    }


   /**
    * Build altered column sql
    *
    * @return string
   */
   public function buildAlteredColumnSql(): string
   {
       return join([
           $this->buildAddColumnSql(),
           $this->buildModifyColumnSql(),
           $this->buildDropColumnSql()
       ]);
   }


    /**
     * @return string
    */
    public function truncateSQL($table)
    {
         return '';
    }
}