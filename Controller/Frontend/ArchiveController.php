<?php

/**
 * This file is part of the desarrolla2 proyect.
 * 
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>  
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

/**
 * 
 * Description of ArchiveController
 *
 * @Route("/archive")
 */
class ArchiveController extends Controller {

    /**
     * @Route("/", name="_archive")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Request $request) {
        $query = $this->getDoctrine()
                ->getManager()
                ->createQuery(
                ' SELECT COUNT(p) as n, ' .
                ' SUBSTRING(p.publishedAt, 1, 4) as year, ' .
                ' SUBSTRING(p.publishedAt, 6, 2) as month ' .
                ' FROM BlogBundle:Post p ' .
                ' WHERE p.isPublished = 1 ' .
                ' GROUP BY year, month ' .
                ' ORDER BY year DESC, month DESC '
        );
        $items = $query->getResult();
        $results = array();
        foreach ($items as $item) {
            array_push($results, array(
                'n' => $item['n'],
                'date' => new \DateTime($item['year'] . '/' . $item['month'] . '/01')
            ));
        }
        return array(
            'results' => $results,
            'title' => $this->container->getParameter('blog.archive.title'),
            'description' => $this->container->getParameter('blog.archive.description'),
        );
    }

    /**
     * @Route("/{year}/{month}", name="_archive_page", requirements={"year"="\d{4}", "month"="\d{1,2}"})
     * @Method({"GET"})
     * @Template()
     */
    public function pageAction(Request $request) {
        $items = array();
        $year = $request->get('year');
        $month = $request->get('month');
        $query = $this->getDoctrine()
                ->getManager()
                ->createQuery(
                        ' SELECT p as item, ' .
                        ' SUBSTRING(p.publishedAt, 1, 4) as year, ' .
                        ' SUBSTRING(p.publishedAt, 6, 2) as month ' .
                        ' FROM BlogBundle:Post p ' .
                        ' WHERE p.isPublished = 1 ' .
                        ' HAVING year = :year ' .
                        ' AND month = :month '
                )
                ->setParameter('year', $year)
                ->setParameter('month', $month)
        ;
        $results = $query->getResult();
        foreach ($results as $result) {
            array_push($items, $result['item']);
        }
        return array(
            'pagination' => $items,
            'title' => $this->container->getParameter('blog.archive.title'),
            'description' => $this->container->getParameter('blog.archive.description'),
        );
    }

}
