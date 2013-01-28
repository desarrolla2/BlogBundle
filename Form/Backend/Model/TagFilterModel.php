<?php

/**
 * This file is part of the desarrolla2 proyect.
 * 
 * Description of TagFilterModel
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class TagFilterModel
{

    /**
     * @var string $name
     * @Assert\MinLength( limit=3 )
     * @Assert\MaxLength( limit=50 )
     *
     */
    public $name;


    public function __construct(Request $request)
    {
        $this->name = (string) $request->get('name', '');
    }

}
