<?php
namespace Jan\Component\Database\Builder\Support;


use Jan\Component\Database\Builder\Type\SetType;
use Jan\Component\Database\Builder\Type\ShowColumnType;
use Jan\Component\Database\Contract\SQLQueryBuilder;
use Jan\Component\Database\Builder\Builder;
use Jan\Component\Database\Builder\ExpressionBuilder;
use Jan\Component\Database\Builder\Type\DeleteType;
use Jan\Component\Database\Builder\Type\FromType;
use Jan\Component\Database\Builder\Type\GroupByType;
use Jan\Component\Database\Builder\Type\HavingType;
use Jan\Component\Database\Builder\Type\InsertType;
use Jan\Component\Database\Builder\Type\JoinType;
use Jan\Component\Database\Builder\Type\LimitType;
use Jan\Component\Database\Builder\Type\OrderByType;
use Jan\Component\Database\Builder\Type\SelectType;
use Jan\Component\Database\Builder\Type\UpdateType;
use Jan\Component\Database\Builder\Type\WhereType;


/**
 * Class AbstractQueryBuilder
 * @package Jan\Component\Database\Builder\Support
*/
abstract class AbstractQueryBuilder implements SQLQueryBuilder
{

    /**
     * @var array
    */
    protected $types = [];


    /**
     * @var array
    */
    protected $sql = [];



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
    protected $parameters = [];



    /**
     * @param string $table
     * @param string $alias
     * @return AbstractQueryBuilder
    */
    public function table(string $table, string $alias = ''): AbstractQueryBuilder
    {
        $this->table = $table;
        $this->alias = $alias;

        return $this;
    }


    /**
     * // TODO FIX (arguments, distrinct = false)
     * @param mixed ...$args
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function select(...$args): AbstractQueryBuilder
    {
        return $this->addSelect($args);
    }


    /**
     * @param mixed ...$args
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function selectDistinct(...$args): AbstractQueryBuilder
    {
        return $this->addSelect($args, true);
    }


    /**
     * @param $sql
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function addSelect($selects, $distinct = false): AbstractQueryBuilder
    {
        return $this->addSql(new SelectType($selects, $distinct));
    }



    /**
     * @param $table
     * @param string $alias
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function from($table, $alias = ''): AbstractQueryBuilder
    {
        return $this->addSql(new FromType($table, $alias));
    }



    /**
     * @param string $condition
     * @return AbstractQueryBuilder
    */
    public function where(string $condition): AbstractQueryBuilder
    {
         return $this->addWhereSQL(sprintf('WHERE %s', $condition));
    }



    /**
     * @param string $condition
     * @return AbstractQueryBuilder
    */
    public function andWhere(string $condition): AbstractQueryBuilder
    {
        return $this->addWhereSQL($condition, "AND");
    }


    /**
     * @param string $condition
     * @return AbstractQueryBuilder
    */
    public function orWhere(string $condition): AbstractQueryBuilder
    {
        return $this->addWhereSQL($condition, "OR");
    }


    /**
     * @param string $condition
     * @return AbstractQueryBuilder
    */
    public function notWhere(string $condition): AbstractQueryBuilder
    {
        return $this->andWhere("NOT ". $condition);
    }


    /**
     * @param string $queryExpr
     * @return $this
    */
    public function whereLike(string $queryExpr)
    {
        return $this->andWhere("LIKE ". $queryExpr);
    }


    /**
     * @param string $condition
     * @return AbstractQueryBuilder
    */
    public function whereBetween($first, $end): AbstractQueryBuilder
    {
         return $this->andWhere("BETWEEN $first AND $end");
    }


    /**
     * @param array $data
     * @return $this
    */
    public function whereIn(array $data)
    {
        return $this->andWhere("IN (". implode(', ', $data).")");
    }



    /**
     * @param array $data
     * @return $this
     */
    public function whereNotIn(array $data)
    {
        return $this->notWhere("IN (". implode(', ', $data).")");
    }


    /**
     * @param int $number
     * @param int $offset
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function limit(int $number, int $offset = 0): AbstractQueryBuilder
    {
         return $this->addSql(new LimitType($number, $offset));
    }


    /**
     * @param string|array $column
     * @param string $sort
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function orderBy($column, string $sort='asc'): AbstractQueryBuilder
    {
        return $this->addSql(new OrderByType($column, $sort));
    }


    /**
     * @param $column
     * @return AbstractQueryBuilder
    */
    public function groupBy($column): AbstractQueryBuilder
    {
        return $this->addSQL(new GroupByType($column));
    }


    /**
     * @param $condition
     * @return AbstractQueryBuilder
    */
    public function having($condition): AbstractQueryBuilder
    {
         return $this->addSql(new HavingType($condition));
    }


    /**
     * @param $column
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function orderByDesc($column): AbstractQueryBuilder
    {
        return $this->orderBy($column, 'desc');
    }

    

    /**
     * @param string $table
     * @param string $condition
     * @param string $type
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function join(string $joinTable, string $condition, string $type = 'INNER'): AbstractQueryBuilder
    {
        return $this->registerSQLManyParts(new JoinType($joinTable, $condition, $type));
    }


    /**
     * @param string $table
     * @param string $condition
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function leftJoin(string $table, string $condition): AbstractQueryBuilder
    {
        return $this->join($table, $condition, 'LEFT');
    }



    /**
     * @param string $table
     * @param string $condition
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function rightJoin(string $table, string $condition): AbstractQueryBuilder
    {
        return $this->join($table, $condition, 'RIGHT');
    }


    /**
     * @param string $table
     * @param string $condition
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function fullJoin(string $table, string $condition): AbstractQueryBuilder
    {
        return $this->join($table, $condition, 'FULL OUTER');
    }



    /**
     * @param array $attributes
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function insert(array $attributes = []): AbstractQueryBuilder
    {
          $qb =  $this->addSql(new InsertType($attributes));
          $this->setParameters($attributes);

          return $qb;
    }



    /**
     * @param array $attributes
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function update(array $attributes = []): AbstractQueryBuilder
    {
        $qb = $this->addSql(new UpdateType($attributes));
        $this->setParameters($attributes);

        return $qb;
    }



    /**
     * @param array $attributes
     * @return $this
    */
    public function set(array $attributes): AbstractQueryBuilder
    {
         return $this->addSql(new SetType($attributes));
    }




    /**
     * @param string $table
     * @return AbstractQueryBuilder
     * @throws \Exception
    */
    public function delete(string $table = ''): AbstractQueryBuilder
    {
        return $this->addSql(new DeleteType(), $table);
    }


    /**
     * @param string $table
     * @return $this
    */
    public function showColumns($table = '')
    {
        return $this->addSql(new ShowColumnType(), $table);
    }

    /**
     * @param $key
     * @param $value
     * @return SQLQueryBuilder
    */
    public function setParameter($key, $value): SQLQueryBuilder
    {
        $this->parameters[$key] = $value;

        return $this;
    }


    /**
     * @param array $parameters
     * @return SQLQueryBuilder
    */
    public function setParameters(array $parameters): SQLQueryBuilder
    {
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }


    /**
     * @return array
    */
    public function getParameters()
    {
        return $this->parameters;
    }


    /**
     * @return array
    */
    public function getValues(): array
    {
         return array_values($this->parameters);
    }


    /**
     * @return ExpressionBuilder
    */
    public function expr(): ExpressionBuilder
    {
        return new ExpressionBuilder($this);
    }



    /**
     * @return string
    */
    public function getSQL(): string
    {
         $start = '';
         $sqlParts   = [];

          /** @var SqlType $type */
         foreach ($this->types as $type)
         {
              if($type->isBaseSQL())
              {
                   $start = $type->build();
              }

              $sqlParts[] = $this->mapOtherSQLParts($type);
         }

         return  $start . join(' ', $sqlParts);
    }


    /**
     * @return array
    */
    public function getSQLParts()
    {
        return array_values($this->sql);
    }



    /**
     * @return mixed|void
    */
    public function flush()
    {
        $this->sql = [];
        $this->types = [];
        $this->parameters = [];
    }


    /**
     * @param SqlType $sqlType
     * @param string $table
     * @param string $alias
     * @return AbstractQueryBuilder
    */
    public function addSql(SqlType $sqlType, string $table = '', string $alias = ''): AbstractQueryBuilder
    {
        if(true === $sqlType->resetPreviousSQL()) {
            $this->flush();
        }

        if($table) {
            $this->table = $table;
        }

        if($alias) {
            $this->alias = $alias;
        }

        $sqlType->setTable($this->table);
        $sqlType->setAlias($this->alias);

        return $this->registerSQLOnePart($sqlType);
    }


    /**
     * @param WhereType $whereType
     * @return AbstractQueryBuilder
    */
    protected function addWhereSQL($condition, $operator = ''): AbstractQueryBuilder
    {
         $whereType = new WhereType();
         $operator = strtoupper($operator);

         if($operator)
         {
              $condition = "{$operator} {$condition}";
         }

         if(empty($this->sql[$whereType->getName()]) && $operator)
         {
              $condition = str_replace($operator, "WHERE", $condition);
         }

         $whereType->setCondition($condition);

         return $this->registerSQLManyParts($whereType);
    }

    
    
    /**
     * @param $name
     * @return SqlType
     * @throws \Exception
    */
    protected function retrieveSQLParts($name): SqlType
    {
         if(! $this->sql[$name])
         {
              throw new \Exception('Unavailable name ('. $name .') SQL.');
         }

         return $this->sql[$name];
    }



    /**
     * @param SqlType $type
     * @return string|null
    */
    protected function mapOtherSQLParts(SqlType $type)
    {
        $isOther = ! $type->isBaseSQL() && ! $type->isConditional();

        if($type->isConditional() || $isOther)
        {
             return $type->build();
        }

        return '';
    }



    /**
     * @param SqlType $sqlType
     * @return $this
    */
    protected function registerSQLManyParts(SqlType $sqlType)
    {
        $this->sql[$sqlType->getName()][] = $sqlType->build();

        return $this->addSQLType($sqlType);
    }


    /**
     * @param SqlType $sqlType
     * @return $this
    */
    protected function registerSQLOnePart(SqlType $sqlType)
    {
        $this->sql[$sqlType->getName()] = $sqlType->build();

        return $this->addSQLType($sqlType);
    }


    /**
     * @param SqlType $sqlType
     * @return $this
    */
    protected function addSQLType(SqlType $sqlType)
    {
        $this->types[] = $sqlType;

        return $this;
    }
}