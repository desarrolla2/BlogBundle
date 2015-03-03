<?php

/*
 * This file is part of the BlogBundle package.
 *
 * Copyright (c) daniel@desarrolla2.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SearchModel
 *
 * @author Daniel González <daniel@desarrolla2.com>
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
