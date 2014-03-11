<?php
namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;

class AuthorFilterHandler
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
        $this->form->bind($this->request);
        if ($this->form->isValid()) {
            $formData = $this->form->getData();
            if ($name = (string) $formData->name) {
                $this->qb->andWhere($this->qb->expr()->like('t.name', ':name'))
                    ->setParameter('name', '%' . $name . '%');
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
