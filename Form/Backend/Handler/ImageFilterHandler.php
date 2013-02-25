<?php

/**
 * This file is part of the desarrolla2 proyect.
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
use Doctrine\ORM\QueryBuilder;

/**
 * 
 * Description of ImageFilterHandler
 *
 * @author : dgonzalez 
 * @file : ImageFilterHandler.php , UTF-8
 * @date : Feb 25, 2013 , 12:59:38 PM
 */
class ImageFilterHandler {

    /**
     * @var  \Symfony\Component\Form\Form 
     */
    protected $form;

    /**
     * @var \Symfony\Component\HttpFoundation\Request 
     */
    protected $request;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qb;

    /**
     * 
     * @param \Symfony\Component\Form\Form $form
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\QueryBuilder $qb
     */
    public function __construct(Form $form, Request $request, QueryBuilder $qb) {
        $this->form = $form;
        $this->request = $request;
        $this->qb = $qb;
    }

    /**
     * 
     * @return boolean
     */
    public function process() {
        $this->form->bind($this->request);
        if ($this->form->isValid()) {
            $formData = $this->form->getData();
            if ($name = (string) $formData->name) {
                $this->qb->andWhere($this->qb->expr()->like('t.name', ':name'))
                        ->setParameter('name', '%' . $name . '%');
            }
            return true;
        }
        return false;
    }

    /**
     * 
     * @return \Symfony\Component\Form\Form 
     */
    public function getFilter() {
        return $this->form;
    }

    /**
     * 
     * @return \Doctrine\ORM\Query
     */
    public function getQuery() {
        return $this->qb->getQuery();
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->form->getData();
    }

}