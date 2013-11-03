<?php
/**
 * This file is part of the planetubuntu project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Desarrolla2\Bundle\BlogBundle\Form\Frontend\Type\RegisterType;
use Desarrolla2\Bundle\BlogBundle\Form\Frontend\Model\RegisterModel;
use Desarrolla2\Bundle\BlogBundle\Form\Frontend\Handler\RegisterHandler;

/**
 * Class UserController
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 *
 * @Route("/user")
 */
class UserController extends Controller
{

    /**
     *
     * Creates a new Comment entity.
     *
     * @Route("/register", name="_blog_user_register")
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array
     */
    public function registerAction(Request $request)
    {

        $form = $this->createForm(new RegisterType(), new RegisterModel());
        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $formHandler = new RegisterHandler($form, $request, $em);

            if ($formHandler->process()) {
                die('1');
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
}