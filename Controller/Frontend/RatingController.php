<?php
/**
 * This file is part of the desarrolla2/blog-bundle package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

/**
 * RatingController
 *
 * @Route("/rating")
 */
class RatingController extends Controller
{
    /**
     * @Route("/{entity}/{id}/{rate}", name="_blog_rate", requirements={"entity" = "[\w]+", "id" = "\d{1,11}", "rate" = "[\+\-]1"})
     *
     * @Method({"POST"})
     * @param Request $request
     *
     * @return array
     */
    public function rateAction(Request $request)
    {
        $manager = $this->get('blog.rating.manager');
        $rating = $manager->create(
            $request->get('entity'),
            $request->get('id'),
            $request->get('rate'),
            $request
        );

        $manager->persist($rating);

        return new Response('Gracias!.');
    }
} 