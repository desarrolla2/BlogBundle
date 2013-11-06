<?php

/**
 * This file is part of the planetubuntu project.
 *
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Desarrolla2\Bundle\BlogBundle\Entity\Link;
use Doctrine\ORM\EntityManager;

/**
 *
 * Description of LinkHandler
 *
 */
class LinkHandler implements ContainerAwareInterface
{

    /**
     * @var  \Symfony\Component\Form\Form
     */
    protected $form;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \\Desarrolla2\Bundle\BlogBundle\Entity\Link
     */
    protected $entity;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    /**
     *
     * @param \Symfony\Component\Form\Form                                                          $form
     * @param \Symfony\Component\HttpFoundation\Request                                             $request
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Link|\Desarrolla2\Bundle\BlogBundle\Entity\Post $entity
     * @param \Doctrine\ORM\EntityManager                                                           $em
     */
    public function __construct(Form $form, Request $request, Link $entity, EntityManager $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->entity = $entity;
        $this->em = $em;
    }

    /**
     *
     * @return boolean
     */
    public function process()
    {
        $this->form->submit($this->request);
        $valid = true;

        if ($this->form->isValid() && $valid) {
            $entityModel = $this->form->getData();
            $this->entity->setName($entityModel->getName());
            $this->entity->setDescription($entityModel->getDescription());
            $this->entity->setUrl($entityModel->getUrl());
            $this->entity->setRss($entityModel->getRSS());
            $this->entity->setIsPublished($entityModel->getIsPublished());
            $this->entity->setMail($entityModel->getMail());
            $this->entity->setNotes($entityModel->getNotes());
            $valid = true;
            if ($this->container !== null) {
                /** @var $validatorService \Symfony\Component\Validator\Validator */
                $validatorService = $this->container->get('validator');
                /** @var $errors \Symfony\Component\Validator\ConstraintViolationList */
                $errors = $validatorService->validate($this->entity, array());
                $valid = $errors->count() === 0;
            }
            if ($valid) {
                $this->em->persist($this->entity);
                $this->em->flush();
                return true;
            }
            return false;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->form->getData();
    }
}
