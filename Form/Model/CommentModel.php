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

use Desarrolla2\Bundle\BlogBundle\Entity\Comment;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CommentModel
 */
class CommentModel
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length( min=5 )
     */
    protected $content;

    /**
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->setContent($comment->getContent());
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
