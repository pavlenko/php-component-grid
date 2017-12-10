<?php

namespace PE\Component\Grid\DataSource;

abstract class AbstractDataSource implements DataSourceInterface
{
    /**
     * @var string[]
     */
    protected static $comparisons1char = ['>', '<'];

    /**
     * @var string[]
     */
    protected static $comparisons2char = ['>=', '<=', '==', '!=', '^=', '$=', '*='];

    /**
     * @var array
     */
    protected $criteria = [];

    /**
     * @var array
     */
    protected $orderBy = [];

    /**
     * @var null|int
     */
    protected $limit;

    /**
     * @var null|int
     */
    protected $offset;

    /**
     * @inheritDoc
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @inheritDoc
     */
    public function setCriteria(array $criteria)
    {
        $criteriaa = [
            'field1=>' => 'val1',
            'field1<=' => 'val2',
            //or
            ['field1', '>=', 'val']
        ];

        $conditions = [];

        foreach ($criteria as $field => $value) {
            if (is_numeric($field)) {
                if (!is_array($value)) {
                    continue;
                }

                list($field, $compare, $value) = array_pad(array_values($value), 3, '');

                $conditions[] = [$field, $compare, $value];
            } else {
                $compare = null;

                if (in_array($compare = substr($field, -2), static::$comparisons2char, true)) {
                    $field = substr($field, 0, -2);
                } else if (in_array($compare = substr($field, -1), static::$comparisons1char, true)) {
                    $field = substr($field, 0, -1);
                } else {
                    $compare = '==';
                }

                $conditions[] = [$field, $compare, $value];
            }
        }

        $conditions = array_filter($conditions, function($condition){
            return $condition[0] !== '' && $condition[1] !== '' && $condition[2] !== '';
        });

        $this->criteria = $conditions;
    }

    /**
     * @inheritDoc
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @inheritDoc
     */
    public function setOrderBy(array $orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @inheritDoc
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @inheritDoc
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @inheritDoc
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @inheritDoc
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
}