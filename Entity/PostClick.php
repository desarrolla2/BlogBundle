<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PostClick
 * @ORM\Table(name="post_click",indexes={@ORM\Index(name="post_click_idx", columns={"post_id", "date"})})
 * @ORM\Entity(repositoryClass="Desarrolla2\Bundle\BlogBundle\Entity\Repository\PostClickRepository")
 */
class PostClick
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
    protected $post_id;

    /**
     *
     * @var Post
     *
     * @ORM\Column(name="post_slug", type="string")
     */
    protected $post_slug;

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
     * @return PostClick
     */
    public function setPostId($postId)
    {
        $this->post_id = $postId;

        return $this;
    }

    /**
     * Get post_id
     *
     * @return integer
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * Set post_slug
     *
     * @param string $postSlug
     *
     * @return PostClick
     */
    public function setPostSlug($postSlug)
    {
        $this->post_slug = $postSlug;

        return $this;
    }

    /**
     * Get post_slug
     *
     * @return string
     */
    public function getPostSlug()
    {
        return $this->post_slug;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PostClick
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
     * @return PostClick
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
        $this->post_id = $post->getId();
        $this->post_slug = $post->getSlug();

        return $this;
    }

    /**
     * Set count
     *
     * @param integer $count
     *
     * @return PostClick
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
     * @return PostClick
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
     *
     */
    public function increment()
    {
        $this->count++;
    }
}
