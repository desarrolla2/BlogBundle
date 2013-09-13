<?php

namespace Desarrolla2\Bundle\BlogBundle\Manager;

use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SearchManager
 * @package Desarrolla2\Bundle\BlogBundle\Manager
 */
class SearchManager
{
    /** @var \Symfony\Component\DependencyInjection\ContainerInterface $container */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->config    = $container->getParameter('blog');
        $this->provider  = $container->get(
            sprintf(
                'blog.search.%s',
                $this->config['search']['provider']
            )
        );
    }

    /**
     * @param string $query
     * @param int $page
     * @return array
     */
    public function search($query, $page = 1)
    {
        return $this->provider->search($query, $page);
    }

    public function related(Post $post, $limit = 10)
    {
        return $this->provider->related($post, $limit);
    }

    public function getItems()
    {
        return $this->provider->getItems();
    }

    public function getPagination()
    {
        return $this->provider->getPagination();
    }
}
