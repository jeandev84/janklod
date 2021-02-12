<?php
namespace Jan\Component\Database\Builder\Type;


use Jan\Component\Database\Builder\Support\SqlType;


/**
 * Class JoinType
 * @package Jan\Component\Database\Builder\Type
*/
class JoinType extends SqlType
{


    /**
     * @var string
    */
    protected $joinTable;


    /**
     * @var string
    */
    protected $condition;


    /**
     * @var string
    */
    protected $type;



    /**
     * JoinType constructor.
     * @param string $joinTable
     * @param string $condition
     * @param string $type
    */
    public function __construct(string $joinTable, string $condition, string $type = 'INNER')
    {
        $this->joinTable = $joinTable;
        $this->condition = $condition;
        $this->type = $type;
    }



    /**
     * @return string|null
    */
    public function build(): ?string
    {
        return sprintf('%s JOIN %s ON %s',
            $this->type,
            $this->joinTable,
            $this->condition
        );
    }



    /**
     * @return string
    */
    public function getName(): string
    {
        return 'join';
    }
}