<?php

/**
 * This file is part of the desarrolla2/blog-bundle project.
 *
 * Copyright (c)
 * Daniel González <daniel@desarrolla2.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Search;

use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 *
 * Description of SearchInterface
 *
 * @author : Daniel González <daniel@desarrolla2.com>
 */
interface SearchInterface
{
    /**
     * @param  string $query
     * @param  int    $page
     * @return array
     */
    public function search($query, $page);

    /**
     * @param  Post   $post
     * @param  int    $limit
     * @return Post[]
     */
    public function related(Post $post, $limit = 3);

    /**
     * @return array
     */
    public function getItems();

    /**
     * @return PaginationInterface
     */
    public function getPagination();
}
