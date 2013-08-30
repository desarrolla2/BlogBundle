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
 * @file   : TwigExtension.php , UTF-8
 * @date   : Oct 15, 2012 , 9:54:55 PM
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
            $this->locale = (string)$locale;
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
            'highlight' => new \Twig_Filter_Method($this, 'highlight'),
        );
    }

    /**
     * @param $search
     * @param $subject
     * @return mixed
     */
    public function highlight($subject, $search)
    {
        $replace = '<strong>' . $search . '</strong>';

        return str_ireplace($search, $replace, $subject);
    }

    /**
     *
     * @param  \DateTime $date
     * @return string
     */
    public function localeCustomDate($date)
    {
        $dateType = $this->getDateType('full');
        $timeType = $this->getTimeType('full');
        $dateFormatter = IntlDateFormatter::create(
            $this->locale,
            $dateType,
            $timeType
        );
        $dateFormatter->setPattern('MMMM  yyyy');

        return $dateFormatter->format($date);
    }

    /**
     *
     * @param  \DateTime $date
     * @param string     $dateType
     * @param string     $timeType
     * @return string
     */
    public function localeDate($date, $dateType = 'medium', $timeType = 'none')
    {
        $dateType = $this->getDateType($dateType);
        $timeType = $this->getTimeType($timeType);
        $dateFormatter = IntlDateFormatter::create(
            $this->locale,
            $dateType,
            $timeType
        );

        return $dateFormatter->format($date);
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
     * @param string $timeType
     * @return int
     */
    protected function getTimeType($timeType)
    {
        switch (strtolower($timeType)) {
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
     * @param  string $dateType
     * @return int
     */
    protected function getDateType($dateType)
    {
        switch (strtolower($dateType)) {
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
