<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of CommentHandler
 *
 * @author : Daniel González <daniel@desarrolla2.com>
 * @date : Aug 20, 2012 , 7:38:25 PM
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Desarrolla2\Bundle\BlogBundle\Search\SphinxManager;

class SearchHandler
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
     * @var \Desarrolla2\Bundle\BlogBundle\Search\SphinxManager
     */
    protected $sm;

    /**
     *
     * @param \Symfony\Component\Form\Form                              $form
     * @param \Symfony\Component\HttpFoundation\Request                 $request
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Comment             $comment
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(Form $form, Request $request, EntityManager $em, SphinxManager $sm)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
        $this->sm = $sm;
    }

    /**
     * @return boolean
     */
    public function process()
    {
        $this->form->submit($this->request);

        if ($this->form->isValid()) {
            $query = $this->form->getData()->getQuery();

            return true;
        }

        return false;
    }

}
