<?php
/**
 * This file is part of the desarrolla2/blog-bundle project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Frontend\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

/**
 * Class RegisterHandler
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

class RegisterHandler
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
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @param Form          $form
     * @param Request       $request
     * @param EntityManager $em
     */
    public function __construct(Form $form, Request $request, EntityManager $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
    }

    /**
     * @return boolean
     */
    public function process()
    {
        $this->form->submit($this->request);

        if ($this->form->isValid()) {
            // @TODO
            return true;
        }

        return false;
    }
}
