<?php

namespace Desarrolla2\Bundle\BlogBundle\Search;

use Desarrolla2\Bundle\BlogBundle\Entity\Post;
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
    protected $itemsPerPage = 12;

    /**
     * @var int
     */
    protected $maxSearchResults = 1000;

    /**
     * @var int
     */
    protected $limitRelated = 3;

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
     * @param int $maxSearchResults
     */
    public function setMaxSearchResults($maxSearchResults)
    {
        $this->maxSearchResults = $maxSearchResults;
    }

    /**
     *
     * @param Post $post
     * @param int    $limit
     * @return array
     */

    public function related(Post $post, $limit = 3)
    {
        $this->sphinx->SetMatchMode(SPH_MATCH_ANY);
        $this->sphinx->SetLimits(0, $limit);
        $ids = $this->sphinxSearch($post->getTagsAsString());
        if (!$ids) {
            return array();
        }
        $items = $this->em->getRepository('BlogBundle:Post')->getByIds($ids);
        $this->items = $this->orderResults($ids, $items);

        return $this->items;
    }

    /**
     *
     * @param string $query
     * @param int    $page
     * @return array
     */
    public function search($query, $page)
    {

        $this->sphinx->SetLimits(0, $this->maxSearchResults);
        $this->sphinx->SetMatchMode(SPH_MATCH_ALL);
        $ids = $this->sphinxSearch($query);
        if (!$ids) {
            return array();
        }
        $this->pagination = $this->paginator->paginate($ids, $page, $this->itemsPerPage);
        $items = $this->em->getRepository('BlogBundle:Post')->getByIds($this->pagination->getItems());
        $this->items = $this->orderResults($ids, $items);

        return $this->items;
    }

    /**
     * @param array $ids
     * @param array $items
     * @return array
     */
    protected function orderResults($ids, $items)
    {
        $result = array();
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

        return $result;
    }

    /**
     * @param $query
     * @return array
     * @throws \RuntimeException
     */
    protected function sphinxSearch($query)
    {
        $ids = array();
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
        }

        return $ids;
    }
}