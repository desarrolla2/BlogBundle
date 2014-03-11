<?php
namespace Desarrolla2\Bundle\BlogBundle\Search;

use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Knp\Component\Pager\Paginator;

/**
 * Class MySQL
 *
 * @package Desarrolla2\Bundle\BlogBundle\Search
 */
class MySQL extends AbstractSearch
{
    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry $registry
     */
    protected $registry;

    /**
     * @var \Doctrine\DBAL\Connection $connection
     */
    protected $connection;

    /**
     * @var \Doctrine\ORM\EntityManager $manager
     */
    protected $manager;

    /**
     * @param Registry                       $registry
     * @param \Knp\Component\Pager\Paginator $paginator
     * @param                                $connection
     * @param                                $manager
     * @param                                $itemsPerPage
     * @internal param $items
     */
    public function __construct(Registry $registry, Paginator $paginator, $connection, $manager, $itemsPerPage)
    {
        $this->registry = $registry;
        $this->paginator = $paginator;
        $this->itemsPerPage = $itemsPerPage;

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
     * @param        $query
     * @param  int   $page
     * @return array
     */
    public function search($query, $page = 1)
    {
        $searchQueryBuilder = $this->manager->getRepository('BlogBundle:Post')->getSearchBuilder(
            $query,
            $page,
            $this->itemsPerPage
        );

        $this->pagination = $this->paginator->paginate($searchQueryBuilder);

        return $searchQueryBuilder->getQuery()->getResult();
    }

    /**
     * @param  Post  $post
     * @param  int   $limit
     * @return mixed
     */
    public function related(Post $post, $limit = 3)
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

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        $this->items = $qb->getQuery()->getResult();

        return $this->items;
    }
}
