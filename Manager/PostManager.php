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

namespace Desarrolla2\Bundle\BlogBundle\Manager;

use Desarrolla2\Bundle\BlogBundle\Entity\Repository\PostRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;
use \DateTime;

/**
 * PostManager
 */
class PostManager extends AbstractManager
{
    /**
     * @param Post $post
     */
    public function publish(Post $post)
    {
        $post->setStatus(PostStatus::PUBLISHED);
        $post->setPublishedAt(new DateTime());
        $this->persist($post);
    }

    /**
     * @param Post $post
     */
    public function updateRating(Post $post)
    {
        $rating = $this->em->getRepository('BlogBundle:Rating')
            ->getRatingFor('Post', $post->getId());
        $votes = $this->em->getRepository('BlogBundle:Rating')
            ->getVotesFor('Post', $post->getId());
        $post->setRating($rating);
        $post->setVotes($votes);

        $this->persist($post);
    }

    /**
     * @return Post
     */
    public function create()
    {
        return new Post();
    }

    /**
     * @return PostRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('BlogBundle:Post');
    }


}