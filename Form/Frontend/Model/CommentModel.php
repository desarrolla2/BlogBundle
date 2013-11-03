<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of CommentFormClass
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Frontend\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Desarrolla2\Bundle\BlogBundle\Entity\Comment;

/**
 * Class CommentModel
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 */
class CommentModel
{

    /**
     * @var integer $id
     *
     */
    protected  $id;

    /**
     * @var string $content
     * @Assert\NotBlank()
     * @Assert\Length( min=5 )
     */
    protected $content;

    /**
     * @var string $userName
     * @Assert\NotBlank()
     * @Assert\Length( min=3 )
     */
    protected $userName;

    /**
     * @var string $userEmail
     * @Assert\Email(checkMX = true)
     */
    protected $userEmail;

    /**
     * @var string $userWeb
     * @Assert\Url()
     *
     */
    protected $userWeb;

    /**
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->id = $comment->getId();
        $this->setContent($comment->getContent());
        $this->setUserName($comment->getUserName());
        $this->setUserEmail($comment->getUserEmail());
        $this->setUserWeb($comment->getUserWeb());
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @param $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return string
     */
    public function getUserWeb()
    {
        return $this->userWeb;
    }

    /**
     * @param $userWeb
     */
    public function setUserWeb($userWeb)
    {
        $this->userWeb = $userWeb;
    }
}
