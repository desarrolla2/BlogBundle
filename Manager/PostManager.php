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

namespace Desarrolla2\Bundle\BlogBundle\Manager;

use DateTime;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Entity\Repository\PostRepository;
use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;

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
