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
