<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Description of PostModel
 *
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CommentFilterModel
{

    /**
     * @var string $text
     * @Assert\Length( min=3, max=50 )
     *
     */
    public $text;

    /**
     * @var string $status
     * @Assert\Choice(choices = {"", "pending", "yes", "no"})
     */
    public $status;

    public function __construct(Request $request)
    {
        $this->text = (string)$request->get('text', '');
        $this->status = (string)$request->get('choices', '');
    }
}
