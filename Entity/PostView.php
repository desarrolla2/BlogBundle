<?php

/*
 * This file is part of the BlogBundle package.
 *
 * Copyright (c) daniel@desarrolla2.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace Desarrolla2\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PostView
 *
 * @ORM\Table(name="post_view",indexes={@ORM\Index(name="post_click_idx", columns={"post_id", "date"})})
 * @ORM\Entity(repositoryClass="Desarrolla2\Bundle\BlogBundle\Entity\Repository\PostViewRepository")
 */
class PostView
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var Post
     *
     * @ORM\Column(name="post_id", type="integer")
     */
    protected $postId;

    /**
     *
     * @var Post
     *
     * @ORM\Column(name="post_slug", type="string")
     */
    protected $postSlug;

    /**
     *
     * @var Post
     *
     * @ORM\Column(name="count", type="integer")
     */
    protected $count;

    /**
     * @var \DateTime $published_at
     *
     * @ORM\Column(name="date", type="date")
     */
    protected $date;

    /**
     * @var \DateTime $created_at
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updated_at
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

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
     * Set post_id
     *
     * @param integer $postId
     *
     * @return PostView
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;

        return $this;
    }

    /**
     * Get post_id
     *
     * @return integer
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * Set post_slug
     *
     * @param string $postSlug
     *
     * @return PostView
     */
    public function setPostSlug($postSlug)
    {
        $this->postSlug = $postSlug;

        return $this;
    }

    /**
     * Get post_slug
     *
     * @return string
     */
    public function getPostSlug()
    {
        return $this->postSlug;
    }

    /**
     * Set count
     *
     * @param integer $count
     *
     * @return PostView
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return PostView
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PostView
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
     * @param \DateTime $updatedAt
     *
     * @return PostView
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
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Post $post
     *
     * @return FeedItem
     */
    public function setPost(\Desarrolla2\Bundle\BlogBundle\Entity\Post $post = null)
    {
        $this->postId = $post->getId();
        $this->postSlug = $post->getSlug();

        return $this;
    }

    /**
     *
     */
    public function increment()
    {
        $this->count++;
    }
}
