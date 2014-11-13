<?php
/**
 * This file is part of the desarrolla2/blog-bundle project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegisterModel
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

class RegisterModel
{
    /**
     * @var string $userName
     * @Assert\NotBlank()
     * @Assert\Length( min=3 )
     * @Assert\Regex("/[\w\d\s\_\-\.]+/")
     */
    protected $userName;

    /**
     * @var string $userEmail
     * @Assert\Email(checkMX = true)
     */
    protected $userEmail;

    /**
     * @var string $plainPassword
     * @Assert\NotBlank()
     * @Assert\Length( min=4 )
     */
    protected $plainPassword;

    /**
     * @var string
     */
    protected $captcha;

    /**
     * @param string $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $captcha
     */
    public function setCaptcha($captcha)
    {
        $this->captcha = $captcha;
    }

    /**
     * @return mixed
     */
    public function getCaptcha()
    {
        return $this->captcha;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
}
