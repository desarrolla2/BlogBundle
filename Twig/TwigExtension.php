<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Copyright (c)
 * Daniel González <daniel@desarrolla2.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Twig;

/**
 * TwigExtension
 */
class TwigExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            'highlight' => new \Twig_Filter_Method($this, 'highlight'),
        ];
    }

    /**
     * @param string $subject
     * @param string $search
     *
     * @return mixed
     */
    public function highlight($subject, $search)
    {
        $replace = '<strong>'.$search.'</strong>';

        return str_ireplace($search, $replace, $subject);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blog_extension';
    }
}