<?php

namespace Desarrolla2\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Desarrolla2\Bundle\BlogBundle\Model\Gravatar;

/**
 * Desarrolla2\Bundle\BlogBundle\Entity\Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="Desarrolla2\Bundle\BlogBundle\Entity\Repository\CommentRepository")
 */
class Comment
{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $userName
     *
     * @ORM\Column(name="user_name", type="string", length=255)
     */
    private $userName;

    /**
     * @var string $userEmail
     *
     * @ORM\Column(name="user_email", type="string", length=255)
     */
    private $userEmail;

    /**
     * @var string $userWeb
     *
     * @ORM\Column(name="user_web", type="string", length=255)
     */
    private $userWeb;

    /**
     * @var string $content
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string status
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     *
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userName = '';
        $this->userEmail = '';
        $this->userWeb = '';
        $this->status = 0;
    }

    public function __toString()
    {
        return $this->getContent();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param  string  $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = (string) $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param  boolean $published
     * @return Comment
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param  \DateTime $updatedAt
     * @return Comment
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set post
     *
     * @param  Desarrolla2\Bundle\BlogBundle\Entity\Post $post
     * @return Comment
     */
    public function setPost(\Desarrolla2\Bundle\BlogBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return Desarrolla2\Bundle\BlogBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set userEmail
     *
     * @param  string  $userEmail
     * @return Comment
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set user
     *
     * @param  string  $user
     * @return Comment
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userWeb
     *
     * @param  string  $userWeb
     * @return Comment
     */
    public function setUserWeb($userWeb)
    {
        $this->userWeb = $userWeb;

        return $this;
    }

    /**
     * Get userWeb
     *
     * @return string
     */
    public function getUserWeb()
    {
        return $this->userWeb;
    }

    /**
     * Set status
     *
     * @param  integer $status
     * @return Comment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * get Avatar URL
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return Gravatar::URL . md5(strtolower(trim($this->getUserEmail())));
    }
}
