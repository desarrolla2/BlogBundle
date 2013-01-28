<?php

/**
 * This file is part of the desarrolla2 proyect.
 * 
 * Description of CommentModel
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Desarrolla2\Bundle\BlogBundle\Entity\Comment;
use Symfony\Component\Validator\Constraints as Assert;

class CommentModel
{

    /**
     * @var string $content
     * @Assert\NotBlank()
     * @Assert\MinLength( limit=5 )
     */
    public $content;

    /**
     * @var string $userName
     * @Assert\NotBlank()
     * @Assert\MinLength( limit=3 )
     *
     */
    public $userName;

    /**
     * @var string $userEmail
     * @Assert\Email(
     *     message = "'{{ value }}' no es un email válido.",
     *     checkMX = true
     * )
     */
    public $userEmail;

    /**
     * @var string $userWeb
     * @Assert\Url()
     * 
     */
    public $userWeb;

    /**
     * @var string $status
     * @Assert\Choice(choices = {"0", "1", "2"})
     */
    public $status;

    public function __construct(Comment $entity)
    {
        $this->content = (string) $entity->getContent();
        $this->userName = (string) $entity->getUserName();
        $this->userEmail = (string) $entity->getUserEmail();
        $this->userWeb = (string) $entity->getUserWeb();
        $this->status = (int) $entity->getStatus();
    }

}
