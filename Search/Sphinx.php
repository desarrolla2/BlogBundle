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

    public function __construct(EntityManager $em, $host, $port, $index)
    {
        $this->em = $em;
        $this->host = $host;
        $this->port = $port;
        $this->index = $index;
        $this->sphinx = new SphinxClient();
        $this->sphinx->SetServer($this->host, $this->port);
        $this->sphinx->SetMaxQueryTime(3000);
        $this->sphinx->SetLimits(0, 100);
        $this->sphinx->SetMatchMode(SPH_MATCH_ALL);
        $this->sphinx->SetSortMode(SPH_SORT_EXPR, " @weight * 1000 + published_at "
        );
        $this->sphinx->SetFieldWeights(array(
            'name' => 5,
            'intro' => 1,
            'content' => 1
        ));
    }

    public function search($query)
    {
        $ids = array();
        $query = $this->sphinx->escapeString($query);
        $result = $this->sphinx->Query($query, $this->index);
        if ($result === false) {
            throw new \RuntimeException('Sphinx Query failed: ' . $this->sphinx->GetLastError());
        } else {
            if (!empty($result["matches"])) {
                foreach ($result["matches"] as $doc => $docinfo) {
                    $ids[] = $doc;
                }
                return $this->em->getRepository('BlogBundle:Post')->getByIds($ids);
            }
        }
    }

}