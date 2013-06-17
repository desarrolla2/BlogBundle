<?php

namespace Desarrolla2\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;

/**
 * Desarrolla2\Bundle\BlogBundle\Entity\Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="Desarrolla2\Bundle\BlogBundle\Entity\Repository\PostRepository")
 */
class Post
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
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

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
     * @var string $slug
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true))
     */
    private $slug;

    /**
     * @var string $source
     *
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;

    /**
     * @var int $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Tag",inversedBy="tags") 
     * @ORM\JoinTable(name="post_tag")
     */
    private $tags;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", cascade={"remove"}) 
     */
    private $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="PostHistory", mappedBy="post", cascade={"remove"}) 
     */
    private $history;

    /**
     * @var Author
     * 
     * @ORM\ManyToOne(targetEntity="Author") 
     */
    private $author;

    /**
     * @var \DateTime $created_at
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updated_at
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime $published_at
     *
     * @ORM\Column(name="published_at", type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->history = $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = 0;
        $this->source = '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
     * @param string $content
     * @return Post
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
     * Set slug
     *
     * @param string $slug
     * @return Post
     */
    protected function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Post
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set author
     *
     * @param Desarrolla2\Bundle\BlogBundle\Entity\Author $author
     * @return Post
     */
    public function setAuthor(\Desarrolla2\Bundle\BlogBundle\Entity\Author $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return Desarrolla2\Bundle\BlogBundle\Entity\Author 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Post
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add tags
     *
     * @param Desarrolla2\Bundle\BlogBundle\Entity\Tag $tags
     * @return Post
     */
    public function addTag(\Desarrolla2\Bundle\BlogBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param Desarrolla2\Bundle\BlogBundle\Entity\Tag $tags
     */
    public function removeTag(\Desarrolla2\Bundle\BlogBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Clear Tags
     */
    public function removeTags()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * 
     * @return string
     */
    public function getTagsAsString()
    {
        $tags = '';
        foreach ($this->tags as $tag) {
            $tags .= $tag->getName() . ' ';
        }
        return trim($tags);
    }

    /**
     * Add comments
     *
     * @param Desarrolla2\Bundle\BlogBundle\Entity\Comment $comments
     * @return Post
     */
    public function addComment(\Desarrolla2\Bundle\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param Desarrolla2\Bundle\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Desarrolla2\Bundle\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set intro
     *
     * @param string $intro
     * @return Post
     */
    public function setIntro($intro)
    {
        $this->intro = (string) $intro;

        return $this;
    }

    /**
     * Get intro
     *
     * @return string 
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     * @return Post
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get publishedAt
     *
     * @return \DateTime 
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Add history
     *
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\PostHistory $history
     * @return Post
     */
    public function addHistory(\Desarrolla2\Bundle\BlogBundle\Entity\PostHistory $history)
    {
        $this->history[] = $history;

        return $this;
    }

    /**
     * Remove history
     *
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\PostHistory $history
     */
    public function removeHistory(\Desarrolla2\Bundle\BlogBundle\Entity\PostHistory $history)
    {
        $this->history->removeElement($history);
    }

    /**
     * Get history
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return Post
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return bool
     */
    public function hasSource()
    {
        return (bool) $this->getSource();
    }

    /**
     * Get Status
     * 
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set Status
     * 
     * @param int $status
     * @return Post
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get Image
     * 
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set Image
     * 
     * @param string $image
     * @return Post
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Retrieve if is published
     * 
     * @return bool
     */
    public function isPublished()
    {
        return (bool) ( $this->status == PostStatus::PUBLISHED );
    }

    /**
     * Retrieve if has image
     * 
     * @return bool
     */
    public function hasImage()
    {
        return (bool) count($this->getImage());
    }

}

