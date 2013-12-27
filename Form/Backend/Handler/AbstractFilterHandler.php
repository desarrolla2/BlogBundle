<?php
/**
 * This file is part of the desarrolla2/blog-bundle package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;

/**
 * AbstractFilterHandler
 */
abstract class AbstractFilterHandler
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
     * @param Form         $form
     * @param Request      $request
     * @param QueryBuilder $qb
     */
    public function __construct(Form $form, Request $request, QueryBuilder $qb)
    {
        $this->form = $form;
        $this->request = $request;
        $this->qb = $qb;
    }

    abstract public function process();

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