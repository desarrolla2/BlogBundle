<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * PageController
 */
class PageController extends Controller
{

    /**
     * @Route("/about-us",  name="_about_us")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @Route("/faq",  name="_faq")
     * @Template()
     */
    public function faqAction()
    {
        return array();
    }


    /**
     * @Route("/cookies-policy",  name="_cookies")
     * @Template()
     */
    public function cookiesAction()
    {
        return array();
    }

}