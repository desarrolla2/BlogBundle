<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Desarrolla2\Bundle\BlogBundle\Entity\Author;
use Doctrine\ORM\EntityManager;

class AuthorHandler
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
     * @param \Symfony\Component\Form\Form                 $form
     * @param \Symfony\Component\HttpFoundation\Request    $request
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Author $entity
     * @param \Doctrine\ORM\EntityManager                  $em
     */
    public function __construct(Form $form, Request $request, Author $entity, EntityManager $em)
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
        $this->form->bind($this->request);
        if ($this->form->isValid()) {
            $entityModel = $this->form->getData();

            $this->entity->setName((string) $entityModel->name);
            $this->entity->setEmail((string) $entityModel->email);

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
