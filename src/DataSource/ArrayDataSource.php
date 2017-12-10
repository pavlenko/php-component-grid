<?php

namespace PE\Component\Grid\DataSource;

class ArrayDataSource extends AbstractDataSource
{
    /**
     * Original data
     *
     * @var array
     */
    protected $data = [];

    /**
     * Filtered data
     *
     * @var array
     */
    protected $filtered = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return current($this->filtered);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        next($this->filtered);
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return key($this->filtered);
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return key($this->filtered) !== null;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->filter();
        return reset($this->filtered);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        $this->filter();
        return count($this->filtered);
    }

    protected function filter()
    {
        $criteria = $this->getCriteria();
        $orderBy  = $this->getOrderBy();
        $limit    = $this->getLimit();
        $offset   = $this->getOffset();

        $data = array_filter($this->data, function($item) use ($criteria) {
            if (!is_array($item)) {
                // If item is not an array - cannot filter, just bypass
                return true;
            }

            foreach ($criteria as $condition) {
                list($field, $compare, $value) = $condition;

                if (!array_key_exists($field, $item)) {
                    // Ignore un-existing keys
                    continue;
                }

                // @codeCoverageIgnoreStart
                $leave = true;
                switch ($compare) {
                    case '>':
                        $leave = $item[$field] > $value;
                        break;
                    case '<':
                        $leave = $item[$field] < $value;
                        break;
                    case '>=':
                        $leave = $item[$field] >= $value;
                        break;
                    case '<=':
                        $leave = $item[$field] <= $value;
                        break;
                    case '==':
                        $leave = $item[$field] == $value;
                        break;
                    case '!=':
                        $leave = $item[$field] != $value;
                        break;
                    case '^=':
                        $leave = 0 === stripos($item[$field], $value);
                        break;
                    case '$=':
                        $leave = substr($item[$field], -strlen($value)) === $value;
                        break;
                    case '*=':
                        $leave = false === stripos($item[$field], $value);
                        break;
                }
                // @codeCoverageIgnoreEnd

                if (!$leave) {
                    return false;
                }
            }

            return true;
        });

        if (count($orderBy) === 1) {
            $key = key($orderBy);
            $dir = strtoupper(current($orderBy));

            uasort($data, function ($a, $b) use ($key, $dir) {
                $a = array_key_exists($key, $a) ? $a[$key] : null;
                $b = array_key_exists($key, $b) ? $b[$key] : null;

                // @codeCoverageIgnoreStart
                if ($a === $b) {
                    return 0;
                }
                // @codeCoverageIgnoreEnd

                $result = ($a > $b) ? -1 : 1;

                if ($dir === 'ASC') {
                    $result = -$result;
                }

                return $result;
            });
        }

        // Apply limit & offset
        $data = array_slice($data, $offset ?: 0, $limit, true);

        $this->filtered = $data;
    }
}