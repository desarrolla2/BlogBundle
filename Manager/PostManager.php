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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Entity\Repository\PostRepository;
use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;
use \DateTime;

/**
 *
 * PostManager
 */
class PostManager extends AbstractManager
{

    /**
     * @param EntityManager   $em
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(EntityManager $em, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($em, $eventDispatcher);
        $this->repository = $em->getRepository('BlogBundle:Post');
    }

    /**
     * @param int $id
     *
     * @return Post
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

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
     * @param Post $post
     */
    protected function  persist(Post $post)
    {
        $this->em->persist($post);
        $this->em->flush();
    }

}
