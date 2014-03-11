<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Desarrolla2\Bundle\BlogBundle\Entity\Post
 *
 * @ORM\Table(name="search_query",indexes={@ORM\Index(name="search_query_idx", columns={"query"})})
 * @ORM\Entity(repositoryClass="Desarrolla2\Bundle\BlogBundle\Entity\Repository\SearchQueryRepository")
 */
class SearchQuery
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var Post
     *
     * @ORM\Column(name="query", type="string")
     */
    protected $query;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set query
     *
     * @param string $query
     *
     * @return SearchQuery
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }
}
