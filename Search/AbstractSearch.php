<?php

/*
 * This file is part of the BlogBundle package.
 *
 * Copyright (c) daniel@desarrolla2.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace Desarrolla2\Bundle\BlogBundle\Search;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;

/**
 * Class AbstractSearch
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */
abstract class AbstractSearch implements SearchInterface
{

    /**
     * @var int
     */
    protected $itemsPerPage = 12;

    /**
     * @var int
     */
    protected $maxSearchResults = 1000;

    /**
     * @var int
     */
    protected $limitRelated = 3;

    /**
     * @var PaginationInterface
     */
    protected $pagination;

    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * @var array
     */
    protected $items;

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param int $itemsPerPage
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @param int $maxSearchResults
     */
    public function setMaxSearchResults($maxSearchResults)
    {
        $this->maxSearchResults = $maxSearchResults;
    }
}
