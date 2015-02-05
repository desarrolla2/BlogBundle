<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of CommentHandler
 *
 * @author : Daniel González <daniel@desarrolla2.com>
 * @date   : Aug 20, 2012 , 7:38:25 PM
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Desarrolla2\Bundle\BlogBundle\Entity\Comment;
use Doctrine\ORM\EntityManager;
use Desarrolla2\Bundle\BlogBundle\Manager\SanitizerManager;

/**
 * CommentHandler
 */
class CommentHandler
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
