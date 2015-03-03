<?php

/*
 * This file is part of the BlogBundle package.
 *
 * Copyright (c) daniel@desarrolla2.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller;

use Desarrolla2\Bundle\BlogBundle\Form\Model\SearchModel;
use Desarrolla2\Bundle\BlogBundle\Form\Type\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * Description of SearchController
 *
 */
class SearchController extends Controller
{
    /**
     * @Route("/search", name="_blog_search")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $items = array();
        $pagination = null;
        $form = $this->createForm(new SearchType(), new SearchModel());
        $query = $request->get('q', false);
        $page = $this->getPage();
        if ($query) {
            $form->submit($request);
            if ($form->isValid()) {
                $query = $form->getData()->getQ();
                $search = $this->get('blog.search');
                $search->search(
                    $query,
                    $page
                );

                $items = $search->getItems();
                $pagination = $search->getPagination();
            }
        }

        return array(
            'page' => $page,
            'form' => $form->createView(),
            'items' => $items,
            'query' => $query,
            'pagination' => $pagination,

        );
    }

    /**
     * @return int
     */
    private function getPage()
    {
        $page = (int) $this->getRequest()->get('page', 1);
        if (!$page) {
            return 1;
        }

        return $page;
    }
}
