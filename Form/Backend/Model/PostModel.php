<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of PostModel
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Symfony\Component\Validator\Constraints as Assert;

class PostModel
{

    /**
     * @var string $name
     * @Assert\NotBlank()
     * @Assert\Length( min=3, max=250 )
     *
     */
    public $name;

    /**
     * @var string $image
     * @Assert\Url()
     * @Assert\Length( max=250 )
     */
    public $image;

    /**
     * @var string $intro
     * @Assert\Length( min=3 )
     */
    public $intro;

    /**
     * @var string $content
     *
     * @Assert\NotBlank()
     * @Assert\Length( min=15 )
     */
    public $content;

    /**
     * @var string $isPublished
     * @Assert\Choice(choices = {"0", "1", "2"})
     */
    public $status;

    /**
     * @var Doctrine\Common\Collections\Collection
     */
    public $tags;

    public function __construct(Post $entity)
    {
        $this->name = $entity->getName();
        $this->image = $entity->getImage();
        $this->intro = $entity->getIntro();
        $this->content = $entity->getContent();
        $this->status = $entity->getStatus();
        $this->tags = $entity->getTags();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getIntro()
    {
        return $this->intro;
    }

    public function setIntro($intro)
    {
        $this->intro = $intro;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags(Doctrine\Common\Collections\Collection $tags)
    {
        $this->tags = $tags;
    }
}
