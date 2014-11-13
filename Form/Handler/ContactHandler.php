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

namespace Desarrolla2\Bundle\WebBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Desarrolla2\Bundle\WebBundle\Handler\Contact;

/**
 * ContactHandler
 */
class ContactHandler
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Desarrolla2\Bundle\WebBundle\Form\Type\ContactType
     */
    protected $form;

    /**
     * @var \Desarrolla2\Bundle\WebBundle\Handler\Contact
     */
    protected $handler;

    /**
     * @param Request $request
     * @param Form $form
     * @param Contact $handler
     */
    public function __construct(Request $request, Form $form, Contact $handler)
    {
        $this->request = $request;
        $this->form = $form;
        $this->handler = $handler;
    }

    public function process()
    {
        $this->form->bind($this->request);
        if ($this->form->isValid()) {
            $this->handler->send($this->form->getData());

            return true;
        }

        return false;
    }
}