<?php
/**
 * This file is part of the planetubuntu package.
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
use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\Query\QueryException;

/**
 * RedirectController
 *
 * Route("/r")
 */
class RedirectController extends Controller
{
    /**
     * @Route("/p/s/{id}", name="_blog_redirect_post_source", requirements={"id" = "\d{1,11}"})
     * @Method({"GET"})
     *
     * @param Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return RedirectResponse
     */
    public function postSourceAction(Request $request)
    {
        $post = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Post')->find($request->get('id', false));
        if (!$post) {
            throw $this->createNotFoundException('The post does not exist');
        }
        if ($post->getStatus() != PostStatus::PUBLISHED) {
            return new RedirectResponse($this->generateUrl('_blog_default'), 302);
        }

        return new RedirectResponse($post->getSource(), 302);
    }
} 