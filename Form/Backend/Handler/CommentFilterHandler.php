<?php

/**
 * This file is part of the desarrolla2 proyect.
 * 
 * Description of PostHandler
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : CommentFilterHandler.php , UTF-8
 * @date : Aug 22, 2012 , 5:03:37 PM
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;

class CommentFilterHandler
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
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qb;

    /**
     * 
     * @param \Symfony\Component\Form\Form $form
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\QueryBuilder $qb
     */
    public function __construct(Form $form, Request $request, QueryBuilder $qb)
    {
        $this->form = $form;
        $this->request = $request;
        $this->qb = $qb;
    }

    /**
     * 
     * @return boolean
     */
    public function process()
    {
        $this->form->bind($this->request);
        if ($this->form->isValid()) {
            $formData = $this->form->getData();
            if ($text = (string) $formData->text) {
                $this->qb->andWhere($this->qb->expr()->like('c.content', ':text'))
                        ->setParameter('text', '%' . $text . '%');
            }
            if ($status = (string) $formData->status) {
                if ($status == 'pending') {
                    $this->qb->andWhere($this->qb->expr()->like('c.status', ':status'))
                            ->setParameter('status', 0);
                }
                if ($status == 'yes') {
                    $this->qb->andWhere($this->qb->expr()->like('c.status', ':status'))
                            ->setParameter('status', 1);
                }
                if ($status == 'no') {
                    $this->qb->andWhere($this->qb->expr()->like('c.status', ':status'))
                            ->setParameter('status', 2);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 
     * @return \Symfony\Component\Form\Form 
     */
    public function getFilter()
    {
        return $this->form;
    }

    /**
     * 
     * @return \Doctrine\ORM\Query
     */
    public function getQuery()
    {
        return $this->qb->getQuery();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->form->getData();
    }

}
