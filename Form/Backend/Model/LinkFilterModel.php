<?php

/**
 * This file is part of the desarrolla2 proyect.
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
     * @Assert\MinLength( limit=3 )
     * @Assert\MaxLength( limit=50 )
     *
     */
    public $name;

    /**
     * @var string $isPublished
     * @Assert\Choice(choices = {"whatever", "yes", "no"})
     */
    public $isPublished;

    public function __construct(Request $request)
    {
        $this->name = (string) $request->get('name', '');
        $this->isPublished = (string) $request->get('choices', 'whatever');
    }

}
