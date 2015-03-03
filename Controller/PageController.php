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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
