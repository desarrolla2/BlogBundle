<?php
namespace Desarrolla2\Bundle\BlogBundle\Search;

use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Search\SearchInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Class MySQL
 * @package Desarrolla2\Bundle\BlogBundle\Search
 */
class MySQL implements SearchInterface
{
    /** @var \Doctrine\Bundle\DoctrineBundle\Registry $registry */
    protected $registry;

    /** @var \Doctrine\DBAL\Connection $connection */
    protected $connection;

    /** @var \Doctrine\ORM\EntityManager $manager */
    protected $manager;

    /** @var int $items */
    protected $items;

    /**
     * @param Registry $registry
     * @param $connection
     * @param $manager
     * @param $items
     */
    public function __construct(Registry $registry, $connection, $manager, $items)
    {
        $this->registry = $registry;
        $this->items = $items;

        // this prevents a 'NULL not support' exception
        if (!$connection || empty($connection)) {
            $connection = null;
        }
        $this->connection = $registry->getConnection($connection);

        if (!$manager || empty($manager)) {
            $manager = null;
        }
        $this->manager = $registry->getManager($manager);
    }

    /**
     * @param $query
     * @param int $page
     * @return array
     */
    public function search($query, $page = 1)
    {
        return $this->manager->getRepository('BlogBundle:Post')->search($query, $page, $this->items);
    }

    /**
     * @param Post $post
     * @param int $limit
     * @return mixed
     */
    public function related(Post $post, $limit = 10)
    {
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $this->manager->getRepository('BlogBundle:Post')->createQueryBuilder('p');
        $qb->innerJoin('p.tags', 't');

        $tags = array();
        foreach ($post->getTags() as $tag) {
            $tags[] = $tag->getId();
        }

        $qb->where('p.status = 1');
        $qb->andWhere($qb->expr()->neq('p.id', $post->getId()));
        $qb->andWhere($qb->expr()->in('t.id', ':tags'));
        $qb->setParameter('tags', $tags);

        return $qb->getQuery()->getResult();
    }
}
