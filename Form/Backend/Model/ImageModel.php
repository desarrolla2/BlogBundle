<?php

/**
 * This file is part of the desarrolla2 project.
 * 
 * Description of ImageModel
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use \Symfony\Component\Validator\Constraints as Assert;

class ImageModel {

    /**
     * @var string $name
     * @Assert\NotBlank()
     * @Assert\File(maxSize="1000000")
     */
    public $file;

    public function getFile() {
        return $this->file;
    }

    public function setFile($file) {
        $this->file =  $file;
    }

}
