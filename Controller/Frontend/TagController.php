<?php

/**
 * This file is part of the planetubuntu project.
 *
 * Copyright (c)
 * Daniel González <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\QueryException;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 *
 * Description of TagController
 *
 */
class TagController extends Controller
{

    /**
     * @Route("/tag/{slug}/{page}", name="_blog_tag", requirements={"slug" = "[\w\d\-]+", "page" = "\d{1,6}"}, defaults={"page" = "1" })
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $tag = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Tag')->getOneBySlug($request->get('slug', false));
        if (!$tag) {
            throw $this->createNotFoundException('The tag does not exist');
        }
        $query = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Post')->getQueryForGetByTag($tag);

        try {
            $pagination = $paginator->paginate(
                    $query, $this->getPage(), $this->container->getParameter('blog.items')
            );
        } catch (QueryException $e) {
            if ($e->getMessage() == 'Invalid parameter number: number of bound variables does not match number of tokens') {
                return new RedirectResponse($this->generateUrl('_blog_tag', array(
                            'slug' => $tag->getSlug(),
                        )), 301);
            }
            throw $e;
        }

        return array(
            'page' => $this->getPage(),
            'pagination' => $pagination,
            'tag' => $tag,
        );
    }

    /**
     * @Route("/tags/{page}", name="_blog_all_tag", requirements={"page" = "\d{1,6}"}, defaults={"page" = "1" })
     * @Method({"GET"})
     * @Template()
     */
    public function allAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');

        $query = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Tag')->getQueryForGet();

        $pagination = $paginator->paginate(
                $query, $this->getPage(), 30
        );

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     *
     * @return type
     */
    protected function getPage()
    {
        $request = $this->getRequest();
        $page = (int) $request->get('page', 1);
        if ($page < 1) {
            $this->createNotFoundException('Page number is not valid' . $page);
        }

        return $page;
    }

}
