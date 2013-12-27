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

namespace Desarrolla2\Bundle\BlogBundle\Model;

/**
 *
 * Description of PostStatus
 *
 * @author : Daniel González <daniel@desarrolla2.com>
 * @file : PostStatus.php , UTF-8
 * @date : Mar 26, 2013 , 12:25:41 AM
 */
class PostStatus
{
    /**
     * The entity was created
     */

    const CREATED = 0;

    /**
     * The entity is waiting for publish
     */
    const PRE_PUBLISHED = 2;

    /**
     * The entity was publised
     */
    const PUBLISHED = 1;

    /**
     *
     */
    const REMOVED = 50;

}
