<?php

/**
 * This file is part of the desarrolla2/blog-bundle project.
 *
 * Copyright (c)
 * Daniel González Cerviño <daniel@desarrolla2.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Desarrolla2\Bundle\BlogBundle\Entity\Link;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * Description of LinkModel
 *
 */
class LinkModel
{

    /**
     * @var string $name
     * @Assert\NotBlank()
     * @Assert\Length( min=3, max=250 )
     */
    public $name;

    /**
     * @var string $name
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public $url;

    /**
     * @var string $name
     * @Assert\Url()
     */
    public $rss = null;

    /**
     * @var string $name
     * @Assert\Email(checkMX = true)
     */
    public $mail = null;

    /**
     * @var string $description
     *
     */
    public $description = '';

    /**
     * @var string $notes
     *
     */
    public $notes = '';

    /**
     * @var string $isPublished
     * @Assert\Choice(choices = {"0", "1"})
     */
    public $isPublished = 0;

    /**
     * @param Link $entity
     */
    public function __construct(Link $entity)
    {
        $this->name = $entity->getName();
        $this->isPublished = $entity->getIsPublished();
        $this->description = $entity->getDescription();
        $this->notes = $entity->getNotes();
        $this->mail = $entity->getMail();
        $this->url = $entity->getUrl();
        $this->rss = $entity->getRss();
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $isPublished
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return string
     */
    public function getIsPublished()
    {
        return $this->isPublished;
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $rss
     */
    public function setRss($rss)
    {
        $this->rss = $rss;
    }

    /**
     * @return string
     */
    public function getRss()
    {
        return $this->rss;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
