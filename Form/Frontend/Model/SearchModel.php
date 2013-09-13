<?php

/**
 * This file is part of the desarrolla2 project.
 *
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Frontend\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SearchModel
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 */
class SearchModel
{

    /**
     * @var string $content
     * @Assert\NotBlank()
     * @Assert\Length( min=3, max=100 )
     */
    protected $q;

    /**
     * @var int $age
     * @Assert\Range(min=1)
     */
    protected $page;

    /**
     * @return string
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * @param $q
     */
    public function setQ($q)
    {
        $this->q = $q;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }
}
