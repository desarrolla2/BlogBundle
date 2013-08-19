<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Copyright (c)
 * dgonzalez
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use \Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * Description of ImageFilterModel
 *
 * @author : dgonzalez
 * @file : ImageFilterModel.php , UTF-8
 * @date : Feb 25, 2013 , 12:58:13 PM
 */
class ImageFilterModel
{
    /**
     * @var string $name
     * @Assert\NotBlank()
     */
    public $file;

}
