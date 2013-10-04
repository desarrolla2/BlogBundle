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

namespace Desarrolla2\Bundle\BlogBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 *
 * Description of DashboardController
 *
 */
class DashboardController extends Controller
{

    /**
     *
     * @Route("/", name="_blog_back_dashboard")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     *
     * @Template()
     */
    public function resumeAction()
    {
        $postRepository = $this->getDoctrine()->getRepository('BlogBundle:Post');
        $tagRepository = $this->getDoctrine()->getRepository('BlogBundle:Tag');
        $commentRepository = $this->getDoctrine()->getRepository('BlogBundle:Comment');

        return array(
            'post_number'             => $postRepository->count(),
            'post_published_number'   => $postRepository->countPublished(),
            'tag_number'              => $tagRepository->count(),
            'comment_number'          => $commentRepository->count(),
            'comment_approved_number' => $commentRepository->countApproved(),
        );
    }

    public function unrelatedAction()
    {
        return array(
            'items' => $this->getDoctrine()->getRepository('PlanetBundle:Unrelated')->getPost(),
        );
    }

    /**
     *
     * @Template()
     */
    public function pendingContentAction()
    {
        return array(
            'items' => $this->getDoctrine()->getRepository('BlogBundle:Post')->getUnpublished(),
        );
    }

    /**
     *
     * @Template()
     */
    public function pendingCommentAction()
    {
        return array(
            'items' => $this->getDoctrine()->getRepository('BlogBundle:Comment')->getPending(),
        );
    }

}
