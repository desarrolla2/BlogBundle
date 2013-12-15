<?php

/**
 * This file is part of the BlogBundle project.
 *
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * Description of Link
 *
 * @ORM\Table(name="link")
 * @ORM\Entity(repositoryClass="Desarrolla2\Bundle\BlogBundle\Entity\Repository\LinkRepository")
 *
 */
class Link
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string $slug
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true))
     */
    protected $slug;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, unique=true)
     */
    protected $url;

    /**
     * @var string $rss
     *
     * @ORM\Column(name="rss", type="string", length=255, unique=true, nullable=true)
     */
    protected $rss = null;

    /**
     * @var string $mail
     *
     * @ORM\Column(name="mail", type="string", length=255, unique=true, nullable=true)
     */
    protected $mail = null;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description = '';

    /**
     * @var string $content
     *
     * @ORM\Column(name="notes", type="text")
     */
    protected $notes = '';

    /**
     * @var string $isPublished
     *
     * @ORM\Column(name="is_published", type="boolean")
     */
    protected $isPublished = false;

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
     * Constructor
     */
    public function __construct()
    {
    }

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
     * Set name
     *
     * @param  string $name
     * @return Link
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
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Link
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
     * Set isPublished
     *
     * @param  boolean $isPublished
     * @return Link
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get isPublished
     *
     * @return boolean
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Set updatedAt
     *
     * @param  \DateTime $updatedAt
     * @return Link
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
     * Set url
     *
     * @param  string $url
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set rss
     *
     * @param  string $rss
     * @return Link
     */
    public function setRss($rss)
    {
        if (!$rss) {
            $rss = null;
        }
        $this->rss = $rss;

        return $this;
    }

    /**
     * Get rss
     *
     * @return string
     */
    public function getRss()
    {
        return $this->rss;
    }

    /**
     * Set description
     *
     * @param  string $description
     * @return Link
     */
    public function setDescription($description)
    {
        $this->description = (string)$description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = (string)$notes;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Link
     */
    public function setSlug($slug)
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
}
