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

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;

class PostFilterHandler
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
     * @param \Symfony\Component\Form\Form              $form
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Doctrine\ORM\QueryBuilder                $qb
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
        $this->form->submit($this->request);
        if ($this->form->isValid()) {
            $formData = $this->form->getData();
            $name = (string)$formData->getName();
            if ($name) {
                $this->qb->andWhere($this->qb->expr()->like('p.name', ':name'))
                    ->setParameter('name', '%' . $name . '%');
            }
            $text = (string)$formData->getText();
            if ($text) {
                $this->qb->andWhere(
                    $this->qb->expr()->orx(
                        $this
                            ->qb->expr()->like('p.intro', ':intro'),
                        $this
                            ->qb->expr()->like('p.content', ':content')
                    )
                )
                    ->setParameter('intro', '%' . $text . '%')
                    ->setParameter('content', '%' . $text . '%');
            }

            $isPublished = (string)$formData->getIsPublished();
            if ($isPublished) {
                if ($isPublished == 'yes') {
                    $this->qb->andWhere($this->qb->expr()->like('p.isPublished', ':isPublished'))
                        ->setParameter('isPublished', 1);
                }
                if ($isPublished == 'no') {
                    $this->qb->andWhere($this->qb->expr()->like('p.isPublished', ':isPublished'))
                        ->setParameter('isPublished', 0);
                }
            }

            $order = (string)$formData->getOrder();
            if ($order) {
                $this->qb->orderBy('p.' . $order, 'DESC');
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
