<?php

namespace Desarrolla2\Bundle\BlogBundle\Search;

use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use Desarrolla2\Bundle\BlogBundle\Search\SearchInterface;
use SphinxClient;

class Sphinx implements SearchInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var string $host
     */
    private $host;

    /**
     * @var string $port
     */
    private $port;

    /**
     * @var string $index
     */
    private $index;

    /**
     * @var \SphinxClient $sphinx
     */
    private $sphinx;

    /**
     *
     * @param \Doctrine\ORM\EntityManager $em
     * @param string                      $host
     * @param string                      $port
     * @param string                      $index
     */
    public function __construct(EntityManager $em, $host, $port, $index)
    {
        $this->em = $em;
        $this->host = $host;
        $this->port = $port;
        $this->index = $index;
        $this->sphinx = new SphinxClient();
        $this->sphinx->SetServer($this->host, $this->port);
        $this->sphinx->SetMaxQueryTime(3000);
        $this->sphinx->SetFieldWeights(array(
            'name' => 3,
            'tags' => 2,
            'source' => 1,
            'intro' => 1,
            'content' => 1
        ));
        $this->sphinx->SetSortMode(
            SPH_SORT_EXPR, ' @weight * 1000 + published_at '
        );
    }

    /**
     * @param $query
     * @param int $page
     * @return type
     *
     * @TODO: Refactor for pagination
     */
    public function search($query, $page = 100)
    {
        $this->configureSearch();

        return $this->__search($query, $page);
    }

    /**
     * @param Post $post
     * @param int $limit
     * @return Post[]
     */
    public function related(Post $post, $limit = 10)
    {
        $this->configureRelated();

        return $this->__search($post->getTagsAsString(), $limit);
    }

    /**
     * @param $query
     * @param $limit
     * @return Post[]
     * @throws \RuntimeException
     */
    protected function __search($query, $limit)
    {
        $result = array();
        $ids = array();
        $this->sphinx->SetLimits(0, $limit);
        $query = $this->sphinx->escapeString($query);
        $response = $this->sphinx->Query($query, $this->index);
        if ($response === false) {
            throw new \RuntimeException('Sphinx Query failed: ' . $this->sphinx->GetLastError());
        } else {
            if (!empty($response['matches'])) {
                foreach ($response['matches'] as $doc => $docinfo) {
                    $ids[] = $doc;
                }
                $items = $this->em->getRepository('BlogBundle:Post')->getByIds($ids);
                foreach ($ids as $id) {
                    foreach ($items as $key => $item) {
                        if ($id == $item->getId()) {
                            $result[] = $item;
                            unset($items[$key]);
                            break;
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Configure for search
     */
    protected function configureSearch()
    {
        $this->sphinx->SetMatchMode(SPH_MATCH_ALL);
    }

    /**
     * Configure for search
     */
    protected function configureRelated()
    {
        $this->sphinx->SetMatchMode(SPH_MATCH_ANY);
    }

}
