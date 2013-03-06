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

class CommentModel {

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

    public function __construct(Comment $comment) {
        $this->id = $comment->getId();
        $this->setContent($comment->getContent());
        $this->setUserName($comment->getUserName());
        $this->setUserEmail($comment->getUserEmail());
        $this->setUserWeb($comment->getUserWeb());
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    public function getUserEmail() {
        return $this->userEmail;
    }

    public function setUserEmail($userEmail) {
        $this->userEmail = $userEmail;
    }

    public function getUserWeb() {
        return $this->userWeb;
    }

    public function setUserWeb($userWeb) {
        $this->userWeb = $userWeb;
    }

}
