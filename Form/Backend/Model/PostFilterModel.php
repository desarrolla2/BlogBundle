<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of PostModel
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class PostFilterModel
{

    /**
     * @var string $name
     * @Assert\Length( min=3, max=50 )
     */
    protected $name;

    /**
     * @var string $text
     * @Assert\Length( min=3, max=60 )
     */
    protected $text;

    /**
     * @var string $order
     * @Assert\Choice(choices = {"createdAt", "updatedAt", "publishedAt", "name"})
     */
    protected $order;
    /**
     * @var string $isPublished
     * @Assert\Choice(choices = {"whatever", "yes", "no"})
     */
    protected $isPublished;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->name = (string) $request->get('name', '');
        $this->text = (string) $request->get('text', '');
        $this->isPublished = (string) $request->get('choices', 'whatever');
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
     * @param string $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
