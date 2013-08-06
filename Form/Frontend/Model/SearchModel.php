<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of CommentFormClass
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Frontend\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SearchModel
{

    /**
     * @var string $content
     * @Assert\NotBlank()
     * @Assert\Length( min=3, max=100 )
     */
    public $q;

    public function getQuery()
    {
        return $this->q;
    }

    public function setQuery($query)
    {
        $this->q = $query;
    }

    public function getQ()
    {
        return $this->q;
    }

    public function setQ($q)
    {
        $this->q = $q;
    }
}
