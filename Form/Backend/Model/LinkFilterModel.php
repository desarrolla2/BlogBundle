<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of LinkModel
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class LinkFilterModel
{

    /**
     * @var string $name
     * @Assert\Length( min=3, max=50 )
     */
    protected $name;

    /**
     * @var string $isPublished
     * @Assert\Choice(choices = {"whatever", "yes", "no"})
     */
    protected $isPublished;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->name = (string) $request->get('name', '');
        $this->isPublished = (string) $request->get('choices', 'whatever');
    }

    /**
     * @param string $isPublished
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return string
     */
    public function getIsPublished()
    {
        return $this->isPublished;
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
