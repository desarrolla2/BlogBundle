<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of PostModel
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class PostFilterModel
{

    /**
     * @var string $name
     * @Assert\Length( min=3, max=50 )
     */
    public $name;

    /**
     * @var string $text
     * @Assert\Length( min=3, max=60 )
     */
    public $text;

    /**
     * @var string $isPublished
     * @Assert\Choice(choices = {"whatever", "yes", "no"})
     */
    public $isPublished;

    public function __construct(Request $request)
    {
        $this->name = (string)$request->get('name', '');
        $this->text = (string)$request->get('text', '');
        $this->isPublished = (string)$request->get('choices', 'whatever');
    }
}
