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

namespace Desarrolla2\Bundle\BlogBundle\Form\Handler;

use Desarrolla2\Bundle\BlogBundle\Entity\Comment;
use Desarrolla2\Bundle\BlogBundle\Manager\SanitizerManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * CommentHandler
 */
class CommentHandler
{
    /**
     * @var \Symfony\Component\Form\Form
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
     *
     * @var SanitizerManager
     */
    protected $sanitizer;

    /**
     * @var \Desarrolla2\Bundle\BlogBundle\Entity\Comment
     */
    protected $entity;

    /**
     * @param Form             $form
     * @param Request          $request
     * @param EntityManager    $em
     * @param SanitizerManager $sanitizer
     * @param Comment          $comment
     */
    public function __construct(
        Form $form,
        Request $request,
        EntityManager $em,
        SanitizerManager $sanitizer,
        Comment $comment
    ) {
        $this->form = $form;
        $this->request = $request;
        $this->entity = $comment;
        $this->em = $em;
        $this->sanitizer = $sanitizer;
    }

    /**
     * @return boolean
     */
    public function process()
    {
        $this->form->submit($this->request);

        if ($this->form->isValid()) {
            $entityModel = $this->form->getData();

            $this->entity->setContent(
                $this->sanitizer->doClean(
                    $entityModel->getContent()
                )
            );

            $this->em->persist($this->entity);
            $this->em->flush();

            return true;
        }

        return false;
    }
}
