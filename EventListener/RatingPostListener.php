<?php
/**
 * This file is part of the desarrolla2/blog-bundle package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\EventListener;

use Desarrolla2\Bundle\BlogBundle\Event\RatingEvent;
use Desarrolla2\Bundle\BlogBundle\Entity\Rating;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Manager\PostManager;

/**
 * RatingPostListener
 */
class RatingPostListener
{
    /**
     * @var PostManager
     */
    protected $postManager;

    /**
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    /**
     * @param RatingEvent $event
     */
    public function onRate(RatingEvent $event)
    {
        $rating = $event->getRating();
        if (!$rating->getEntityName() === 'Post') {
            return;
        }
        $post = $this->postManager->find($rating->getEntityId());
        if (!$post) {
            return;
        }

        $this->postManager->updateRating($post);
    }
}
