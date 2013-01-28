<?php

/**
 * This file is part of the desarrolla2 proyect.
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * 
 * Description of FeedController
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 */
class FeedController extends Controller
{

    /**
     * @Route("/feed/", name="_feed")
     * @Route("/feed.{_format}")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $items = $this->getDoctrine()->getEntityManager()
                        ->getRepository('BlogBundle:Post')->get(16);

        return $this->render(
                        'BlogBundle:Frontend/Feed:index.xml.twig', array(
                    'items' => $items,
                ));
    }

    /**
     * @Route("/sitemap/", name="_sitemap")
     * @Route("/sitemap.{_format}")
     * * @Route("/sitemap.xml.gz")
     * @Method({"GET"})
     */
    public function sitemapAction(Request $request)
    {
        $items = array();
        $tags = $this->getDoctrine()->getEntityManager()
                        ->getRepository('BlogBundle:Tag')->get(50);

        foreach ($tags as $tag) {
            $items[] = $this->generateUrl('_tag', array('slug' => $tag->getSlug()), true);
        }

        return $this->render(
                        'BlogBundle:Frontend/Feed:sitemap.xml.twig', array(
                    'items' => $items,
                ));
    }

}
