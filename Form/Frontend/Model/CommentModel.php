<?php

/**
 * This file is part of the desarrolla2 proyect.
 * 
 * Description of CommentFormClass
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Frontend\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Desarrolla2\Bundle\BlogBundle\Entity\Comment;

class CommentModel
{

    /**
     * @var integer $id
     *
     */
    public $id;

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

    public function __construct(Comment $comment)
    {
        $this->id = $comment->getId();
        $this->content = (string) $comment->getContent();
        $this->userName = (string) $comment->getUserName();
        $this->userEmail = (string) $comment->getUserEmail();
        $this->userWeb = (string) $comment->getUserWeb();
    }

}
