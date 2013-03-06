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
class FeedController extends Controller {

    /**
     * @Route("/feed/", name="_feed")
     * @Route("/feed.{_format}")
     * @Method({"GET"})
     */
    public function indexAction(Request $request) {
        $request->setRequestFormat('xml');
        $items = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Post')->get(
                $this->container->getParameter('blog.rss.items')
        );

        return $this->render(
                        'BlogBundle:Frontend/Feed:index.xml.twig', array(
                    'title' => $this->container->getParameter('blog.rss.title'),
                    'items' => $items,
        ));
    }

    /**
     * @Route("/feed/{slug}/", name="_feed_tag", requirements={"slug" = "[\w\d\-]+"})
     * @Method({"GET"})
     */
    public function tagAction(Request $request) {
        $request->setRequestFormat('xml');
        $tag = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Tag')->getOneBySlug($request->get('slug', false));
        if (!$tag) {
            throw $this->createNotFoundException('The tag does not exist');
        }
        $items = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Post')->getByTag(
                $tag, $this->container->getParameter('blog.rss.items')
        );

        return $this->render(
                        'BlogBundle:Frontend/Feed:index.xml.twig', array(
                    'title' => $this->container->getParameter('blog.rss.title') . ' :: ' . $tag->getName(),
                    'items' => $items,
        ));
    }

    /**
     * @Route("/sitemap/", name="_sitemap")
     * @Route("/sitemap.{_format}")
     * @Route("/sitemap.xml.gz")
     * @Method({"GET"})
     */
    public function sitemapAction(Request $request) {
        $request->setRequestFormat('xml');
        $items = array();
        $tags = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Tag')->get(
                $this->container->getParameter('blog.sitemap.items')
        );
        foreach ($tags as $tag) {
            $items[] = $this->generateUrl('_tag', array('slug' => $tag->getSlug()), true);
        }
        return $this->render(
                        'BlogBundle:Frontend/Feed:sitemap.xml.twig', array(
                    'items' => $items,
        ));
    }

}
