<?php

/**
 * This file is part of the desarrolla2 proyect.
 * 
 * Description of CommentHandler
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @date : Aug 20, 2012 , 7:38:25 PM
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Frontend\Handler;

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
     * @param \Symfony\Component\Form\Form $form
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Comment $comment
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(Form $form, Request $request, Comment $comment, EntityManager $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->entity = $comment;
        $this->em = $em;
    }

    /**
     * @return boolean
     */
    public function process()
    {
        $this->form->bind($this->request);

        if ($this->form->isValid()) {
            $entityModel = $this->form->getData();

            $this->entity->setContent((string) $entityModel->content);
            $this->entity->setUserName((string) $entityModel->userName);
            $this->entity->setUserEmail((string) $entityModel->userEmail);
            $this->entity->setUserWeb((string) $entityModel->userWeb);

            $this->em->persist($this->entity);
            $this->em->flush();
            return true;
        }
        return false;
    }

}
