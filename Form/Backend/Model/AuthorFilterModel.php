<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of TagFilterModel
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class AuthorFilterModel
{
    /**
     * @var string $name
     * @Assert\Length( min=3, max=50 )
     */
    protected $name;

    /**
     * @var string $email
     * @Assert\Email()
     * @Assert\Length( min=3, max=50 )
     */
    protected $email;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->name = (string) $request->get('name', '');
        $this->email = (string) $request->get('email', '');
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}
