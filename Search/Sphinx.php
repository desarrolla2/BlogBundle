<?php

namespace Desarrolla2\Bundle\BlogBundle\Search;

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
     * @param string $host
     * @param string $port
     * @param string $index
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
     * 
     * @param string $query
     * @return array
     * @throws \RuntimeException
     */
    public function search($query, $limit = 100)
    {
        $this->configureSearch();
        return $this->__search($query, $limit);
    }

    /**
     * 
     * @param string $query
     * @return array
     * @throws \RuntimeException
     */
    public function related($query, $limit = 10)
    {
        $this->configureRelated();
        return $this->__search($query, $limit);
    }

    /**
     * 
     * @param type $query
     * @return type
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