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
use Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandler;

class CommentHandler {

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
     * @var \Desarrolla2\RSSClient\Handler\Sanitizer\SanitizerHandler
     */
    protected $sanitizer;

    /**
     * 
     * @param \Symfony\Component\Form\Form $form
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Comment $comment
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(Form $form, Request $request, Comment $comment, EntityManager $em, SanitizerHandler $sanitizer) {
        $this->form = $form;
        $this->request = $request;
        $this->entity = $comment;
        $this->em = $em;
        $this->sanitizer = $sanitizer;
    }

    /**
     * @return boolean
     */
    public function process() {
        $this->form->bind($this->request);

        if ($this->form->isValid()) {
            $entityModel = $this->form->getData();

            $this->entity->setContent(
                    $this->sanitizer->doClean(
                            $entityModel->getContent()
            ));
            $this->entity->setUserName(
                    $this->sanitizer->doClean(
                            $entityModel->getUserName()
            ));
            $this->entity->setUserEmail(
                    $this->sanitizer->doClean(
                            $entityModel->getUserEmail()
            ));
            $this->entity->setUserWeb(
                    $this->sanitizer->doClean(
                            $entityModel->getUserWeb()
            ));

            $this->em->persist($this->entity);
            $this->em->flush();
            return true;
        }
        return false;
    }

}
