<?php

/**
 * This file is part of the planetubuntu proyect.
 * 
 * Copyright (c)
 * Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Model;

/**
 * 
 * Description of PostStatus
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
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