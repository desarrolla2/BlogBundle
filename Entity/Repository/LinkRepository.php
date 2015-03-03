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
use Desarrolla2\Bundle\BlogBundle\Model\LinkStatus;
use Doctrine\ORM\EntityRepository;

/**
 * LinkRepository
 */
class LinkRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getActive()
    {
        $query = $this->getQueryForGetActive();

        return $query->getResult();
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function getQueryForGetActive()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT l FROM BlogBundle:Link l '.
            ' WHERE l.isPublished = '.LinkStatus::PUBLISHED.
            ' ORDER BY l.createdAt DESC '
        );

        return $query;
    }

    /**
     * @return array
     */
    public function getActiveOrdered()
    {
        $query = $this->getQueryForGetActiveOrdered();

        return $query->getResult();
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function getQueryForGetActiveOrdered()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT l FROM BlogBundle:Link l '.
            ' WHERE l.isPublished = '.LinkStatus::PUBLISHED.
            ' ORDER BY l.name ASC '
        );

        return $query;
    }
}
