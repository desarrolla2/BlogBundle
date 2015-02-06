<?php
/*
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller;

use Desarrolla2\Bundle\BlogBundle\Entity\Profile;
use Desarrolla2\Bundle\BlogBundle\Form\Handler\ProfileHandler;
use Desarrolla2\Bundle\BlogBundle\Form\Model\ProfileModel;
use Desarrolla2\Bundle\BlogBundle\Form\Type\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * ProfileController
 */
class ProfileController extends Controller
{
    /**
     * @Route("/profile/", name="_blog_profile_index")
     * @Method({"GET"})
     *
     * @return RedirectResponse
     */
    public function indexAction()
    {
        return new RedirectResponse($this->generateUrl('_blog_profile_edit'));
    }

    /**
     * @Route("/profile/edit", name="_blog_profile_edit")
     * @Method({"GET", "POST"})
     * @Template()
     *
     * @param Request $request
     *
     * @return array
     */
    public function editAction(Request $request)
    {
        $profile = $this->get('blog.post.profile')->get($this->getUser());
        $form = $this->createForm(new ProfileType(), new ProfileModel($profile));

        if ($request->getMethod() == 'POST') {
            $formHandler = new ProfileHandler(
                $form,
                $request,
                $this->container->get('blog.post.profile'),
                $profile
            );

            if ($formHandler->process()) {
                return $this->redirect($this->generateUrl('_blog_profile_edit'));
            }
        }

        return [
            'form' => $form->createView(),
        ];
    }
}