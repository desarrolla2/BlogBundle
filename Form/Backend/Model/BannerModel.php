<?php
/**
 * This file is part of the desarrolla2/blog-bundle package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Desarrolla2\Bundle\BlogBundle\Entity\Banner;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BannerModel
 */
class BannerModel
{

    /**
     * @var string $name
     * @Assert\NotBlank()
     * @Assert\Length( min=3, max=250 )
     */
    protected $name;

    /**
     * @var string $content
     *
     * @Assert\NotBlank()
     * @Assert\Length( min=15 )
     */
    protected $content;

    /**
     * @var string $content
     *
     * @Assert\NotBlank()
     * @Assert\Range( min=0 )
     */
    protected $weight;

    /**
     * @var string $isPublished
     * @Assert\Choice(choices = {"0", "1"})
     */
    protected $isPublished = 0;

    /**
     * @param Banner $banner
     */
    public function __construct(Banner $banner)
    {
        $this->name = $banner->getName();
        $this->content = $banner->getContent();
        $this->weight = $banner->getWeight();
        $this->isPublished = $banner->getIsPublished();
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
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
     * @param string $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }



} 