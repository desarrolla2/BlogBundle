<?php
/**
 * This file is part of the desarrolla2/blog-bundle project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Search;

use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\Pagination\PaginationInterface;

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
