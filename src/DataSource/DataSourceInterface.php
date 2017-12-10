<?php

namespace PE\Component\Grid\DataSource;

use PE\Component\Grid\Iterator\IteratorInterface;

interface DataSourceInterface extends IteratorInterface
{
    /**
     * @return array
     */
    public function getCriteria();

    /**
     * Set filter criteria
     *
     * All conditions joined with AND (OR must not used)
     *
     * Required format (must be normalized to):
     * ['field', 'compare', 'value']
     *
     * Possible conditions:
     * >  - value greater than
     * >= - value greater than or equals
     * <  - value lower than
     * <= - value lower than or equals
     * == - value equals
     * != - value not equals
     * ^= - value begins
     * $= - value ends
     * *= - value contains
     *
     * @param array $criteria
     */
    public function setCriteria(array $criteria);

    /**
     * @return array
     */
    public function getOrderBy();

    /**
     * @param array $orderBy
     */
    public function setOrderBy(array $orderBy);

    /**
     * @return null|int
     */
    public function getLimit();

    /**
     * @param null|int $limit
     */
    public function setLimit($limit);

    /**
     * @return null|int
     */
    public function getOffset();

    /**
     * @param null|int $offset
     */
    public function setOffset($offset);
}