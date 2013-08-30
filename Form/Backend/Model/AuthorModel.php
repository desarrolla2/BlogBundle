<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Desarrolla2\Bundle\BlogBundle\Entity\Author;
use Symfony\Component\Validator\Constraints as Assert;

class AuthorModel
{
    /**
     * @var string $name
     * @Assert\NotBlank()
     * @Assert\Length( min=3, max=250 )
     */
    public $name;

    /**
     * @var string $email
     * @Assert\Email()
     * @Assert\NotBlank()
     * @Assert\Length( min=3, max=250 )
     */
    public $email;

    public function __construct(Author $entity)
    {
        $this->name = $entity->getName();
        $this->email = $entity->getEmail();
    }
}
