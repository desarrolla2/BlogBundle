<?php

/**
 * This file is part of the planetubuntu project.
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
use DateTime;

/**
 *
 * Description of StatsController
 *
 * @Route("/report")
 */
class ReportController extends Controller
{

    /**
     * @Route("/posted-items", name="_blog_report")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $day_ago = new DateTime('-1 day');
        $week_ago = new DateTime('-1 week');
        $month_ago = new DateTime('-1 month');
        $year_ago = new DateTime('-1 year');
        $first_time = new DateTime('1th January 1970 00:00:00 (UTC)');

        return array(
            'post' => array(
                'last_day' => $em->getRepository('BlogBundle:Post')
                        ->countFromDate($day_ago),
                'last_week' => $em->getRepository('BlogBundle:Post')
                        ->countFromDate($week_ago),
                'last_month' => $em->getRepository('BlogBundle:Post')
                        ->countFromDate($month_ago),
                'last_year' => $em->getRepository('BlogBundle:Post')
                        ->countFromDate($year_ago),
                'total' => $em->getRepository('BlogBundle:Post')
                        ->countFromDate($first_time),
            ),
            'comment' => array(
                'last_day' => $em->getRepository('BlogBundle:Comment')
                        ->countFromDate($day_ago),
                'last_week' => $em->getRepository('BlogBundle:Comment')
                        ->countFromDate($week_ago),
                'last_month' => $em->getRepository('BlogBundle:Comment')
                        ->countFromDate($month_ago),
                'last_year' => $em->getRepository('BlogBundle:Comment')
                        ->countFromDate($year_ago),
                'total' => $em->getRepository('BlogBundle:Comment')
                        ->countFromDate($first_time),
            ),
            'link' => array(
                'last_day' => $em->getRepository('BlogBundle:Link')
                        ->countFromDate($day_ago),
                'last_week' => $em->getRepository('BlogBundle:Link')
                        ->countFromDate($week_ago),
                'last_month' => $em->getRepository('BlogBundle:Link')
                        ->countFromDate($month_ago),
                'last_year' => $em->getRepository('BlogBundle:Link')
                        ->countFromDate($year_ago),
                'total' => $em->getRepository('BlogBundle:Link')
                        ->countFromDate($first_time),
            ),
        );
    }

}
