<?php

/**
 * This file is part of the desarrolla2 project.
 * 
 * Copyright (c)
 * dgonzalez 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Desarrolla2\Bundle\BlogBundle\Entity\Image;
use Doctrine\ORM\EntityManager;

/**
 * 
 * Description of ImageHandler
 *
 * @author : dgonzalez 
 * @file : ImageHandler.php , UTF-8
 * @date : Feb 25, 2013 , 1:52:40 PM
 */
class ImageHandler {

    /**
     * @var  \Symfony\Component\Form\Form 
     */
    protected $form;

    /**
     * @var \Symfony\Component\HttpFoundation\Request 
     */
    protected $request;

    /**
     * @var \\Desarrolla2\Bundle\BlogBundle\Entity\Comment
     */
    protected $entity;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $uploadPath;

    /**
     * 
     * @param \Symfony\Component\Form\Form $form
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Image $entity
     * @param \Doctrine\ORM\EntityManager $em
     * @param string $uploadPath
     */
    public function __construct(Form $form, Request $request, Image $entity, EntityManager $em, $uploadPath) {
        $this->form = $form;
        $this->request = $request;
        $this->entity = $entity;
        $this->em = $em;
        $this->uploadPath = $uploadPath;
    }

    /**
     * 
     * @return boolean
     */
    public function process() {
        $this->form->bind($this->request);
        if ($this->form->isValid()) {
            $entityModel = $this->form->getData();
            $file = $entityModel->getFile();
            $fileName = $this->getName() . '.' . $file->getClientOriginalExtension();
            $file->move($this->uploadPath . DIRECTORY_SEPARATOR . $fileName);
            $this->entity->setFile($fileName);
            $this->em->persist($this->entity);
            $this->em->flush();
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->form->getData();
    }

    protected function getName() {
        return sha1(time());
    }

}
