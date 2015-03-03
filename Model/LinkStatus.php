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

namespace Desarrolla2\Bundle\BlogBundle\Model;

/**
 *
 * Description of LinkStatus
 *
 * @author : Daniel González Cerviño <daniel@desarrolla2.com>
 * @file : LinkStatus.php , UTF-8
 * @date : Mar 26, 2013 , 7:00:15 PM
 */
class LinkStatus
{
    /**
     * The entity was created
     */
    const CREATED = 0;

    /**
     * The entity was publised
     */
    const PUBLISHED = 1;

    /**
     *
     */
    const REMOVED = 50;
}
