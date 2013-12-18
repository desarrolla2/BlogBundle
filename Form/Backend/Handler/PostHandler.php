<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of PostHandler
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @file   : PostHandler.php , UTF-8
 * @date   : Aug 22, 2012 , 5:03:37 PM
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler;

use DateTime;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Entity\PostHistory;
use Doctrine\ORM\EntityManager;

class PostHandler
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
     * @var \\Desarrolla2\Bundle\BlogBundle\Entity\Post
     */
    protected $entity;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     *
     * @param \Symfony\Component\Form\Form               $form
     * @param \Symfony\Component\HttpFoundation\Request  $request
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Post $entity
     * @param \Doctrine\ORM\EntityManager                $em
     */
    public function __construct(Form $form, Request $request, Post $entity, EntityManager $em)
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
            $entityModel = $this->form->getData();
            $this->entity->setName((string)$entityModel->getName());
            $this->entity->setIntro((string)$entityModel->getIntro());
            $this->entity->setContent((string)$entityModel->getContent());
            $this->entity->setImage((string)$entityModel->getImage());
            $this->entity->setStatus((bool)$entityModel->getStatus());
            if ($this->entity->isPublished() && !$this->entity->getPublishedAt()) {
                $this->entity->setPublishedAt(new DateTime());
            }
            $this->entity->removeTags();
            foreach ($entityModel->tags as $tag) {
                $this->entity->addTag($tag);
            }
            $this->em->persist($this->entity);
            $this->createHistory();
            $this->updateTags($this->entity->getTags());
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

    /**
     * create History
     */
    protected function createHistory()
    {
        $history = new PostHistory();
        $history->setPost($this->entity);
        $this->em->persist($history);
    }

    /**
     * update tags
     */
    protected function updateTags($tags)
    {
        foreach ($tags as $tag) {
            $this->em->getRepository('BlogBundle:Tag')->indexTagItemsForTag($tag);
        }
    }

}
