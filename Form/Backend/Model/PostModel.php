<?php

/**
 * This file is part of the desarrolla2 proyect.
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
     * @Assert\MinLength( limit=3 )
     * @Assert\MaxLength( limit=250 )
     *
     */
    public $name;

    /**
     * @var string $intro
     * @Assert\MinLength( limit=3 )
     *
     */
    public $intro;

    /**
     * @var string $content
     * 
     * @Assert\NotBlank()
     * @Assert\MinLength( limit=15 )
     */
    public $content;

    /**
     * @var string $isPublished
     * @Assert\Choice(choices = {"0", "1"})
     */
    public $isPublished;
    
    /**
     * @var Doctrine\Common\Collections\Collection 
     */
    public $tags;

    public function __construct(Post $entity)
    {
        $this->name = $entity->getName();
        $this->intro = $entity->getIntro();
        $this->content = $entity->getContent();
        $this->isPublished = $entity->getIsPublished();
        $this->tags = $entity->getTags();
    }

}
