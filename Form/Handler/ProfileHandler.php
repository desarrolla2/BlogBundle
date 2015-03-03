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

namespace Desarrolla2\Bundle\BlogBundle\Form\Handler;

use Desarrolla2\Bundle\BlogBundle\Entity\Profile;
use Desarrolla2\Bundle\BlogBundle\Manager\ProfileManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * ProfileHandler
 */
class ProfileHandler
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ProfileManager
     */
    protected $manager;

    /**
     * @var Profile
     */
    protected $profile;

    /**
     * @param Form           $form
     * @param Request        $request
     * @param ProfileManager $manager
     * @param Profile        $profile
     */
    public function __construct(Form $form, Request $request, ProfileManager $manager, Profile $profile)
    {
        $this->form = $form;
        $this->request = $request;
        $this->manager = $manager;
        $this->profile = $profile;
    }

    /**
     * @return bool
     */
    public function process()
    {
        $this->form->submit($this->request);

        if ($this->form->isValid()) {
            $entityModel = $this->form->getData();

            $this->profile->setName($entityModel->getName());
            $this->profile->setAddress($entityModel->getAddress());
            $this->profile->setDescription($entityModel->getDescription());

            $this->manager->persist($this->profile);

            return true;
        }

        return false;
    }
}
