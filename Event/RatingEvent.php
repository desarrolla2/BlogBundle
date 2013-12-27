<?php
/**
 * This file is part of the desarrolla2/blog-bundle package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Desarrolla2\Bundle\BlogBundle\Entity\Rating;

/**
 * RatingEvent
 */
class RatingEvent extends Event
{
    /**
     * @var Rating
     */
    protected $rating;

    /**
     * @param Rating $rating
     */
    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return Rating
     */
    public function getRating()
    {
        return $this->rating;
    }

} 