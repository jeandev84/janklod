<?php
namespace Jan\Component\Database\Capsule\ORM;


use Exception;
use Jan\Component\Database\Capsule\Exception\AccessMethodException;
use Jan\Component\Database\Capsule\Manager;
use Jan\Component\Database\Capsule\Query;
use ReflectionException;
use Jan\Component\Database\EntityTrait;


/**
 * Class Model
 *
 * @package Jan\Component\Database\Capsule\ORM
*/
class Model implements \ArrayAccess
{

    use EntityTrait;


    /**
     * @var array
    */
    protected static $accessibleMethods = [];



    /**
     * @var string
    */
    protected $table;



    /**
     * @var string
    */
    protected $primaryKey = 'id';



    /**
     * @var array
    */
    protected $attributes = [];


    /**
     * @var array
    */
    protected $fillable = [];



    /**
     * @var string[]
    */
    protected $guarded = ['id'];


    /**
     * hide fields we want to show in API (for example)
     * @var array
    */
    protected $hidden  = [];



    /**
     * @param $column
     * @param $value
    */
    public function setAttribute($column, $value)
    {
        $this->attributes[$column] = $value;
    }



    /**
     * @param $column
     * @return bool
     */
    public function hasAttribute($column): bool
    {
        return isset($this->attributes[$column]);
    }



    /**
     * @param $column
    */
    public function removeAttribute($column)
    {
        if($this->hasAttribute($column))
        {
            unset($this->attributes[$column]);
        }
    }



    /**
     * @param $column
     * @return mixed
     * @throws Exception
    */
    public function getAttribute($column)
    {
        if(! $this->hasAttribute($column))
        {
             return null;
        }

        return $this->attributes[$column];
    }



    /**
     * Save data to the database
     * do action create or update table
    */
    public function save()
    {
         $assignedAttributes = $this->getAssignedAttributes();

         $id = (int) $this->getAttribute($this->primaryKey);

         if($id)
         {
              /* update attributes */
              $this->getQuery()->update($assignedAttributes, $id);

         }else{

              /* create attributes and get last inserted id */
              $lastId = $this->getQuery()->create($assignedAttributes);

              /* set last inserted id */
              $this->setAttribute($this->primaryKey, $lastId);
         }

         /* dd($this, $this->attributes); */
    }


    /**
     * @throws ReflectionException
    */
    protected function getAssignedAttributes()
    {
        $attributes = [];

        foreach ($this->getTableColumns() as $column)
        {
            if(! empty($this->fillable))
            {
                if(\in_array($column, $this->fillable))
                {
                    $attributes[$column] = $this->{$column};
                }
            } else {

                $attributes[$column] = $this->{$column};
            }
        }


        if(! empty($this->guarded))
        {
            foreach ($this->guarded as $guarded)
            {
                if(isset($attributes[$guarded]))
                {
                    unset($attributes[$guarded]);
                }
            }
        }


        return $attributes;
    }



    /**
     * @return array|mixed
     * @throws ReflectionException
    */
    protected function getTableColumns()
    {
        $columns = $this->getQuery()->tableColumns();

        if(! $columns)
        {
            throw new Exception('no columns mapped for table '. $this->getTable());
        }

        return $columns;
    }


    /**
     * @param $column
     * @param $value
    */
    public function __set($column, $value)
    {
        $this->setAttribute($column, $value);
    }



    /**
     * @param $column
     * @return mixed
     * @throws Exception
    */
    public function __get($column)
    {
        return $this->getAttribute($column);
    }




    /**
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws Exception
    */
    public static function __callStatic($method, $arguments)
    {
        $accessor = (new static())->getQuery();

        if(method_exists($accessor, $method))
        {
            return call_user_func_array([$accessor, $method], $arguments);
        }
    }




    /**
     * @return string
     * @throws ReflectionException
    */
    public function getTable(): string
    {
         if(! $this->table) {
             $this->table = $this->getTableDefaultName(get_called_class());
         }

         return $this->table;
    }


    /**
     * @throws ReflectionException
    */
    public function setProperties()
    {
         $this->getQuery()->assign($this, $this->attributes);
    }




    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->hasAttribute($offset);
    }


    /**
     * @param mixed $offset
     * @return mixed|void
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }


    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }



    /**
     * @param mixed $offset
    */
    public function offsetUnset($offset)
    {
        $this->removeAttribute($offset);
    }


    /**
     * @param $method
     * @return bool
    */
    protected static function hasAccessStatic($method): bool
    {
        return \in_array($method, self::$accessibleMethods);
    }


    /**
     * @return Query
     * @throws ReflectionException
    */
    protected function getQuery()
    {
        $query = new Query(Manager::getInstance(), get_called_class());
        $query->primaryKey($this->primaryKey);
        $query->table($this->getTable());

        return $query;
    }
}