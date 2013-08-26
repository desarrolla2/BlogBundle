<?php

namespace Desarrolla2\Bundle\BlogBundle\Search;

use Doctrine\ORM\EntityManager;
use Desarrolla2\Bundle\BlogBundle\Search\SearchInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\Pagination\PaginationInterface;
use SphinxClient;

class Sphinx implements SearchInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * @var string $host
     */
    protected $host;

    /**
     * @var string $port
     */
    protected $port;

    /**
     * @var string $index
     */
    protected $index;

    /**
     * @var SphinxClient $sphinx
     */
    protected $sphinx;

    /**
     * @var int
     */
    protected $itemsPerPage = 30;

    /**
     * @var int
     */
    protected $limitSearchResult = 1000;

    /**
     * @var PaginationInterface
     */
    protected $pagination;

    /**
     * @var array
     */
    protected $items;

    /**
     *
     * @param \Doctrine\ORM\EntityManager    $em
     * @param \Knp\Component\Pager\Paginator $paginator
     * @param string                         $host
     * @param string                         $port
     * @param string                         $index
     */
    public function __construct(EntityManager $em, Paginator $paginator, $host, $port, $index)
    {
        $this->sphinx = new SphinxClient();
        $this->em = $em;
        $this->paginator = $paginator;
        $this->host = $host;
        $this->port = $port;
        $this->index = $index;
        $this->sphinx->SetServer($this->host, $this->port);
        $this->sphinx->SetMaxQueryTime(3000);
        $this->sphinx->SetSortMode(
            SPH_SORT_EXPR,
            ' @weight * 1000 + published_at '
        );
    }

    /**
     *
     * @param string $query
     * @param int    $limit
     * @return array
     */
    public function related($query, $limit = 10)
    {
        $this->configureRelated();

        return $this->__search($query, $limit);
    }

    /**
     *
     * @param string $query
     * @param int    $page
     * @throws \RuntimeException
     * @return array
     */
    public function search($query, $page = 1)
    {
        $this->items = array();
        $ids = array();
        $this->sphinx->SetLimits(0, $this->limitSearchResult);
        $this->sphinx->SetMatchMode(SPH_MATCH_ALL);
        $query = $this->sphinx->escapeString($query);
        $response = $this->sphinx->Query($query, $this->index);
        if ($response === false) {
            throw new \RuntimeException('Sphinx Query failed: ' . $this->sphinx->GetLastError());
        } else {
            if (empty($response['matches'])) {
                return;
            }
            foreach ($response['matches'] as $doc => $docInfo) {
                $ids[] = $doc;
            }
            $this->pagination = $this->paginator->paginate($ids, $page, $this->itemsPerPage);
            $items = $this->em->getRepository('BlogBundle:Post')->getByIds($this->pagination->getItems());
            foreach ($ids as $id) {
                foreach ($items as $key => $item) {
                    if ($id != $item->getId()) {
                        continue;
                    }
                    $this->items[] = $item;
                    unset($items[$key]);
                    break;
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function getPagination()
    {
        return $this->pagination;
    }


    /**
     * @param int $itemsPerPage
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     *
     * @param string $query
     * @throws \RuntimeException
     * @return array
     */
    protected function __search($query)
    {
        $result = array();
        $ids = array();
        $this->sphinx->SetLimits(0, $this->limitSearchResult);
        $query = $this->sphinx->escapeString($query);
        $response = $this->sphinx->Query($query, $this->index);
        if ($response === false) {
            throw new \RuntimeException('Sphinx Query failed: ' . $this->sphinx->GetLastError());
        } else {
            if (empty($response['matches'])) {
                return;
            }
            foreach ($response['matches'] as $doc => $docInfo) {
                $ids[] = $doc;
            }
            $query = $this->em->getRepository('BlogBundle:Post')->getQueryForGetByIds($ids);


            $items = $this->em->getRepository('BlogBundle:Post')->getByIds($ids);
            foreach ($ids as $id) {
                foreach ($items as $key => $item) {
                    if ($id != $item->getId()) {
                        continue;
                    }
                    $result[] = $item;
                    unset($items[$key]);
                    break;
                }
            }
        }

        return $result;
    }


    /**
     * Configure for search
     */
    protected function configureRelated()
    {
        $this->sphinx->SetMatchMode(SPH_MATCH_ANY);
    }
}
