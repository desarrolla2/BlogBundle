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

use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;
use Doctrine\ORM\Query\ResultSetMapping;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * ArchiveController
 *
 * @Route("/archive")
 */
class ArchiveController extends Controller
{

    /**
     * @Route("/", name="_blog_archive")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $items = $this->session->all();
        $sessionValues = [];
        foreach ($items as $item) {
            if (!is_object($item)) {
                $sessionValues[] = (string) $item;
                continue;
            }
            if (method_exists($item, '__toString')) {
                $sessionValues[] = $item->__toString();
            }
        }

        return [
            'items' => $this->getDoctrine()->getManager()
                ->getRepository('BlogBundle:Post')->getArchiveItems(),
        ];
    }

    /**
     * @Route(
     *  "/{year}/{month}/{page}",
     *  name="_blog_archive_page",
     *  requirements={"year"="\d{4}", "month"="\d{1,2}", "page" = "\d{1,4}"}, defaults={"page" = "1" }
     * )
     * @Route("/{year}/{month}", requirements={"year"="\d{4}", "month"="\d{1,2}"})
     * @Method({"GET"})
     * @Template()
     */
    public function pageAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $year = $request->get('year');
        $month = $request->get('month');
        $page = $this->getPage($request);
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('n', 'n', 'string');
        $count =
        $query = $this->getDoctrine()
            ->getManager()
            ->createNativeQuery(
                ' SELECT COUNT(*) as n FROM ( '.
                ' SELECT p.id, '.
                ' SUBSTRING(p.published_at, 1, 4) AS year, '.
                ' SUBSTRING(p.published_at, 6, 2) AS month '.
                ' FROM post AS p'.
                ' WHERE p.status = '.PostStatus::PUBLISHED.
                ' HAVING year = :year '.
                ' AND month = :month '.
                ' ) AS items',
                $rsm
            )
            ->setParameter('year', $year)
            ->setParameter('month', $month)
            ->getSingleScalarResult();

        $query = $this->getDoctrine()
            ->getManager()
            ->createQuery(
                ' SELECT p as item, '.
                ' SUBSTRING(p.publishedAt, 1, 4) as year, '.
                ' SUBSTRING(p.publishedAt, 6, 2) as month '.
                ' FROM BlogBundle:Post p '.
                ' WHERE p.status = '.PostStatus::PUBLISHED.
                ' HAVING year = :year '.
                ' AND month = :month '
            )
            ->setHint('knp_paginator.count', $count)
            ->setParameter('year', $year)
            ->setParameter('month', $month);

        $pagination = $paginator->paginate(
            $query->getResult(),
            $page,
            $this->container->getParameter('blog.items'),
            ['distinct' => false]
        );

        return [
            'page' => $page,
            'year' => $year,
            'month' => $month,
            'pagination' => $pagination,
        ];
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    protected function getPage(Request $request)
    {
        $page = (int) $request->get('page', 1);
        if ($page < 1) {
            $this->createNotFoundException('Page number is not valid'.$page);
        }

        return $page;
    }
}
