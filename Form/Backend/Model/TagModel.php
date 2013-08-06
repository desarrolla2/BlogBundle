<?php

/**
 * This file is part of the desarrolla2 project.
 * 
 * Description of TagModel
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Desarrolla2\Bundle\BlogBundle\Entity\Tag;
use Symfony\Component\Validator\Constraints as Assert;

class TagModel
{

    /**
     * @var string $name
     * @Assert\NotBlank()
     * @Assert\Length( min=3, max=250 )
     */
    public $name;

    public function __construct(Tag $entity)
    {
        $this->name = $entity->getName();
    }

}
