<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of CommentHandler
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @file : CommentHandler.php , UTF-8
 * @date : Aug 22, 2012 , 5:03:37 PM
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Desarrolla2\Bundle\BlogBundle\Entity\Comment;
use Doctrine\ORM\EntityManager;

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
     * @var \\Desarrolla2\Bundle\BlogBundle\Entity\Comment
     */
    protected $entity;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     *
     * @param \Symfony\Component\Form\Form                  $form
     * @param \Symfony\Component\HttpFoundation\Request     $request
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Comment $entity
     * @param \Doctrine\ORM\EntityManager                   $em
     */
    public function __construct(Form $form, Request $request, Comment $entity, EntityManager $em)
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
        if ($this->form->isValid()) {
            $this->entity = $this->form->getData();

            $this->em->persist($this->entity);
            $this->em->flush();
            return true;
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
