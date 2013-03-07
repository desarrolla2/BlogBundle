<?php

/**
 * This file is part of the planetubuntu proyect.
 * 
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@externos.seap.minhap.es>  
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * 
 * Description of SearchController
 *
 */
class SearchController extends Controller {

    /**
     * @Route("/search", name="_search")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Request $request) {
        $paginator = $this->get('knp_paginator');
        
        $query = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Post')->getQueryForGet();


        $pagination = $paginator->paginate(
                $query, $this->getPage(), $this->container->getParameter('blog.items')
        );

        return array(
            'pagination' => $pagination,
            'title' => $this->container->getParameter('blog.title'),
            'description' => $this->container->getParameter('blog.description'),
        );
    }

}