<?php
namespace Jan\Component\Database\Schema;


use Exception;


/**
 * Class Column
 * @package Jan\Component\Database\Schema
*/
class Column
{

      const TYPES = [
          'INT', 'VARCHAR', 'TEXT', 'TINYINT'
      ]; // 'DATETIME'


      /**
       * Column params
       * @var array
      */
      private $options = [
          'name'          => '',
          'type'          => '',
          'length'        => '',
          'default'       => '',
          'comments'      => [],
          'nullable'      => false,
          'autoincrement' => false,
          'index'         => 'primary',
          'collation'     => 'utf8_general_ci'
      ];
      
      
      /**
       * Column constructor.
       *
       * @param array $options
       * @throws Exception
      */
      public function __construct(array $options)
      {
          foreach ($options as $key => $value)
          {
              $this->setOption($key, $value);
          }
      }



      /**
       * Set nullable column
       *
       * @return $this
       * @throws Exception
      */
      public function nullable(): Column
      {
          return $this->setOption('nullable', true);
      }



      /**
       * add interphases
       * If $this->collation('utf8_unicode'),
       *
       * @param string $collation
       * @return self
      */
      public function collation($collation): Column
      {
          return $this->setOption('collation', $collation);
      }


    /**
     * @param string|array $comment
     * @return Column
    */
    public function comments($comment): Column
    {
        return $this->setOption('comments', $this->resolveComment($comment));
    }



    /**
     * Get column name
     *
     * @return string
    */
    public function getName(): ?string
    {
        return $this->getOption('name');
    }



    /**
     * @return mixed
    */
    public function getAutoincrement(): string
    {
        $autoincrement = $this->getOption('autoincrement');

        if($autoincrement === true)
        {
            return  'AUTO_INCREMENT';
        }

        return '';
    }


    /**
     * Get column type
     *
     * @return string
     *
     * TYPE(LENGTH)
    */
    public function getTypeAndLength(): string
    {
        $type = strtoupper(
            $this->getOption('type')
        );

        if(in_array($type, self::TYPES))
        {
             if($length = $this->getOption('length'))
             {
                 return sprintf('%s(%s)', $type, $this->getOption('length'));
             }

             return $type;
        }

        return $type;
    }


    /**
     * @return string
    */
    public function getDefaultValue(): string
    {
        $default = $this->getOption('default');

        if($this->isNullable() && ! $default)
        {
            return 'DEFAULT NULL';
        }

        if($default)
        {
            return sprintf('DEFAULT "%s"', $default);
        }

        return 'NOT NULL';
    }


    /**
     * @return bool
    */
    public function isNullable(): bool
    {
        return $this->getOption('nullable') === true;
    }


    /**
     * @param $key
     * @param $value
     * @return Column
     */
    protected function setOption($key, $value): Column
    {
        if(\array_key_exists($key, $this->options))
        {
            $this->options[$key] = $value;
        }

        return $this;
    }


    /**
     * @param $key
     * @return mixed|null
    */
    protected function getOption($key)
    {
        return $this->options[$key] ?? null;
    }


    /**
     * @param $comment
     * @return string
    */
    protected function resolveComment($comment): string
    {
        return (string) (is_array($comment) ? join(', ', $comment) : $comment);
    }
}