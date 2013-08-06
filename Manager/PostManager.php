<?php

/**
 * This file is part of the planetubuntu project.
 * 
 * Copyright (c)
 * Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Manager;

use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;
use Doctrine\ORM\EntityManager;
use \DateTime;

/**
 * 
 * Description of PostManager
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : PostManager.php , UTF-8
 * @date : May 19, 2013 , 11:51:36 PM
 */
class PostManager
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager; 
     */
    protected $em;

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function publish(Post $post)
    {
        $post->setStatus(PostStatus::PUBLISHED);
        $post->setPublishedAt(new DateTime());
        $this->em->persist($post);
        $this->em->flush();
    }

}