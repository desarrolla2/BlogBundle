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

namespace Desarrolla2\Bundle\BlogBundle\Entity\Repository;

use DateTime;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Model\CommentStatus;
use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 */
class CommentRepository extends EntityRepository
{

    /**
     * @return \Doctrine\ORM\Query
     */
    public function getQueryForGet()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT c FROM BlogBundle:Comment c '.
            ' WHERE c.status = '.CommentStatus::PENDING.
            ' OR c.status = '.CommentStatus::APPROVED.
            ' ORDER BY c.createdAt DESC '
        );

        return $query;
    }

    /**
     * @param bool $limit
     *
     * @return array
     */
    public function getLatest($limit = false)
    {
        $query = $this->getQueryForGet($limit);
        if ($limit) {
            $query->setMaxResults($limit);
        }

        return $query->getResult();
    }

    /**
     * @param Post $post
     *
     * @return \Doctrine\ORM\AbstractQuery
     */
    public function getQueryForGetForPost(Post $post)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT c FROM BlogBundle:Comment c '.
            ' WHERE ( c.status = '.CommentStatus::PENDING.' OR c.status = '.CommentStatus::APPROVED.' ) '.
            ' AND c.post = :post '.
            ' ORDER BY c.createdAt ASC '
        )
            ->setParameter('post', $post);

        return $query;
    }

    /**
     * @param Post $post
     *
     * @return array
     */
    public function getForPost(Post $post)
    {
        $query = $this->getQueryForGetForPost($post);

        return $query->getResult();
    }
}
