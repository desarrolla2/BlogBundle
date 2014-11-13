<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Copyright (c)
 * Daniel González <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Exception;

/**
 *
 * Description of ExceptionController
 *
 * @Route("/error")
 */
class ExceptionController extends Controller
{

    /**
     *
     * @Route("/404")
     * @Method("GET")
     */
    function throw404Action()
    {
        throw new NotFoundHttpException('This is a NotFoundHttpException');
    }

    /**
     *
     * @Route("/500")
     * @Method("GET")
     */
    function throw500Action()
    {
        throw new Exception('This is a Exception');
    }

}
