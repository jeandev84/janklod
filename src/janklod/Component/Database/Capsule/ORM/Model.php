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


    const HAS_ONE   = 'hasOne'; // OneToOne
    const HAS_MANY  = 'hasMany'; // OneToMany
    const BELONG_TO = 'belongsTo'; // ManyToOne
    const BELONG_TO_MANY = 'belongsToMany'; // ManyToMany



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
     *
     * @var array
    */
    protected $hidden  = [];



    /**
     * OneToOne, ManyToOne, OneToMany, ManyToMany
     * @var array
    */
    protected $relations  = [];



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
     * @return array
    */
    public function getAttributes()
    {
         foreach ($this->hidden as $hidden)
         {
             $this->removeAttribute($hidden);
         }

         return $this->attributes;
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
     * OneToOne
     * @param $entityClass
     * @param $foreignKey
     * @param $localKey
     * @return Model
    */
    public function hasOne($entityClass, $foreignKey, $localKey)
    {
         $this->relations[self::HAS_ONE][] = compact('entityClass', 'foreignKey', 'localKey');

         return $this;
    }


    /**
     * ManyToMany
     * @param $entityClass
     * @param $localKey
     * @param $parentKey
     * @return Model
    */
    public function belongsTo($entityClass, $localKey, $parentKey)
    {
        $this->relations[self::BELONG_TO][] = compact('entityClass', 'localKey', 'parentKey');

        return $this;
    }



    /**
     * @return string
     * @throws ReflectionException
    */
    public function getTable(): string
    {
         if(! $this->table) {
             $this->table = $this->getTableDefaultName();
         }

         return $this->table;
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
     * @throws Exception
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
    protected static function hasAccessibleStatic($method): bool
    {
        return \in_array($method, self::$accessibleMethods);
    }


    /**
     * @return Query
     * @throws ReflectionException
    */
    protected function getQuery()
    {
        $query = new Query(Manager::getInstance(), $this);
        $query->entityClass(get_called_class());
        $query->primaryKey($this->primaryKey);
        $query->table($this->getTable());
        return $query;
    }
}