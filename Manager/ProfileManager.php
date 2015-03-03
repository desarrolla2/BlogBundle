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

namespace Desarrolla2\Bundle\BlogBundle\Manager;

use Desarrolla2\Bundle\BlogBundle\Entity\Profile;
use Desarrolla2\Bundle\BlogBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * ProfileManager
 */
class ProfileManager extends AbstractManager
{
    /**
     * @param User $user
     *
     * @return Profile
     */
    public function get(User $user)
    {
        $profile = $user->getProfile();
        if (!$profile) {
            $profile = new Profile();
            $user->setProfile($profile);
            $profile->setUser($user);

            $this->persist($user, true);
        }

        return $profile;
    }

    /**
     * @return mixed
     */
    public function create()
    {
        throw new \RuntimeException('This method is not available');
    }

    /**
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('BlogBundle:Profile');
    }
}
