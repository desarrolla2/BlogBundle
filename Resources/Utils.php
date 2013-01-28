<?php

namespace Desarrolla2\Bundle\BlogBundle\Resources;

class Utils
{

    /**
     * slugify a string
     * 
     * @param type $text
     * @return type 
     */
    static public function slugify($text, $limit = 100)
    {
        $limit = (int) $limit;
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
        $text = trim($text, '-');
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        $text = strtolower($text);
        $text = preg_replace('#[^-\w]+#', '', $text);
        if (empty($text))
        {
            return 'n-a';
        }
        return substr($text, 0, $limit);
    }

}

