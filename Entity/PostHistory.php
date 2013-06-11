<?php

namespace Desarrolla2\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;

/**
 * Desarrolla2\Bundle\BlogBundle\Entity\PostHistory
 *
 * @ORM\Table(name="post_history")
 * @ORM\Entity(repositoryClass="Desarrolla2\Bundle\BlogBundle\Entity\Repository\PostHistoryRepository")
 */
class PostHistory
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $intro
     *
     * @ORM\Column(name="intro", type="text")
     */
    private $intro;

    /**
     * @var string $content
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime $created_at
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * 
     * @var Post
     * 
     * @ORM\ManyToOne(targetEntity="Post", cascade={"remove"})
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $post;

    /**
     * Constructor
     */
    public function __construct() {
        
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return PostHistory
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set intro
     *
     * @param string $intro
     * @return PostHistory
     */
    public function setIntro($intro) {
        $this->intro = $intro;

        return $this;
    }

    /**
     * Get intro
     *
     * @return string 
     */
    public function getIntro() {
        return $this->intro;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return PostHistory
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return PostHistory
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set post
     *
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Post $post
     * @return PostHistory
     */
    public function setPost(\Desarrolla2\Bundle\BlogBundle\Entity\Post $post = null) {
        $this->post = $post;
        $this->setName($post->getName());
        $this->setIntro($post->getIntro());
        $this->setContent($post->getContent());
        return $this;
    }

    /**
     * Get post
     *
     * @return \Desarrolla2\Bundle\BlogBundle\Entity\Post 
     */
    public function getPost() {
        return $this->post;
    }

}