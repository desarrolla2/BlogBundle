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

namespace Desarrolla2\Bundle\BlogBundle\Event;

use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Symfony\Component\EventDispatcher\Event;

/**
 * PostEvent
 */
class PostEvent extends Event
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
