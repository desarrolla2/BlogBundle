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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * AbstractManager
 */
abstract class AbstractManager
{
    /**
     * @var \Doctrine\ORM\EntityManager;
     */
    protected $em;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @param EntityManager            $em
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EntityManager $em, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param int $id
     *
     * @return Post
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param mixed $entity
     * @param bool  $flush
     */
    public function persist($entity, $flush = true)
    {
        $this->em->persist($entity);
        if ($flush) {
            $this->em->flush();
        }
    }

    /**
     * @return mixed
     */
    abstract public function create();

    /**
     * @return EntityRepository
     */
    abstract public function getRepository();
}
