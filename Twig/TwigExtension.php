<?php

/**
 * This file is part of the desarrolla2 project.
 * 
 * Copyright (c)
 * Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Twig;

use Locale;
use IntlDateFormatter;

/**
 * 
 * Description of TwigExtension
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : TwigExtension.php , UTF-8
 * @date : Oct 15, 2012 , 9:54:55 PM
 */
class TwigExtension extends \Twig_Extension
{

    /**
     * @var string
     */
    protected $locale = null;

    /**
     * @param string $locale
     */
    public function __construct($locale = null)
    {
        if ($locale) {
            $this->locale = (string) $locale;
        } else {
            $this->locale = Locale::getDefault();
        }
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            'localeDate' => new \Twig_Filter_Method($this, 'localeDate'),
            'localeCustomDate' => new \Twig_Filter_Method($this, 'localeCustomDate'),
        );
    }

    /**
     * 
     * @param type $date
     * @param type $format
     * @return type
     */
    public function localeCustomDate($date, $format)
    {
        $datetype = $this->getDateType('full');
        $timetype = $this->getTimeType('full');
        $dateFormater = IntlDateFormatter::create(
                        $this->locale, $datetype, $timetype
        );
        $dateFormater->setPattern('MMMM  yyyy');
        return $dateFormater->format($date);
    }

    /**
     * 
     * @return string
     */
    public function localeDate($date, $datetype = 'medium', $timetype = 'none')
    {
        $datetype = $this->getDateType($datetype);
        $timetype = $this->getTimeType($timetype);
        $dateFormater = IntlDateFormatter::create(
                        $this->locale, $datetype, $timetype
        );
        return $dateFormater->format($date);
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return 'blog_extension';
    }

    /**
     * 
     * @param type $timetype
     * @return type
     */
    protected function getTimeType($timetype)
    {
        switch (strtolower($timetype)) {
            case 'none':
                return IntlDateFormatter::NONE;
                break;
            case 'full':
                return IntlDateFormatter::FULL;
                break;
            case 'long':
                return IntlDateFormatter::LONG;
                break;
            case 'medium':
                return IntlDateFormatter::MEDIUM;
                break;
            case 'short':
                return IntlDateFormatter::SHORT;
                break;
            default :
                return IntlDateFormatter::MEDIUM;
                break;
        }
    }

    /**
     * 
     * @param type $datetype
     * @return type
     */
    protected function getDateType($datetype)
    {
        switch (strtolower($datetype)) {
            case 'none':
                return IntlDateFormatter::NONE;
                break;
            case 'full':
                return IntlDateFormatter::FULL;
                break;
            case 'long':
                return IntlDateFormatter::LONG;
                break;
            case 'medium':
                return IntlDateFormatter::MEDIUM;
                break;
            case 'short':
                return IntlDateFormatter::SHORT;
                break;
            default :
                return IntlDateFormatter::MEDIUM;
                break;
        }
    }

}
