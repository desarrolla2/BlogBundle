<?php
/**
 * This file is part of the desarrolla2/blog-bundle package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Manager;

use Desarrolla2\Bundle\BlogBundle\Entity\Rating;
use Desarrolla2\Bundle\BlogBundle\Event\RatingEvent;
use Desarrolla2\Bundle\BlogBundle\Event\RatingEvents;

use Symfony\Component\HttpFoundation\Request;

/**
 * RatingManager
 */
class RatingManager extends AbstractManager
{
    /**
     * @param string  $entity
     * @param string  $id
     * @param string  $rate
     * @param Request $request
     *
     * @return Rating
     */
    public function create($entity, $id, $rate, Request $request)
    {
        $rating = new Rating();
        $rating->setEntityName($entity);
        $rating->setEntityId($id);
        $rating->setRating($rate);
        $rating->setIp($request->getClientIp());
        $rating->setUserAgent($request->headers->get('User-Agent'));

        return $rating;
    }

    /**
     * @param Rating $rating
     */
    public function persist(Rating $rating)
    {
        $this->em->persist($rating);
        $this->em->flush();

        $this->eventDispatcher->dispatch(
            RatingEvents::PERSISTED,
            new RatingEvent($rating)
        );
    }
} 