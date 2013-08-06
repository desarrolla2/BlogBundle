<?php

/**
 * This file is part of the planetubuntu project.
 * 
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>  
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
class LinkModel {

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
    public $rss;

    /**
     * @var string $name
     * @Assert\Email(checkMX = true)
     */
    public $mail;

    /**
     * @var string $content
     * 
     */
    public $description;

    /**
     * @var string $isPublished
     * @Assert\Choice(choices = {"0", "1"})
     */
    public $isPublished;

    public function __construct(Link $entity) {
        $this->name = $entity->getName();
        $this->isPublished = $entity->getIsPublished();
        $this->description = $entity->getDescription();
        $this->url = $entity->getUrl();
        $this->rss = $entity->getRss();
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getRss() {
        return $this->rss;
    }

    public function setRss($rss) {
        $this->rss = $rss;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getIsPublished() {
        return $this->isPublished;
    }

    public function setIsPublished($isPublished) {
        $this->isPublished = $isPublished;
    }

    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

}
