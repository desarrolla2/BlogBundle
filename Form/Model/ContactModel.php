<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\WebBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ContactModel
{
    /**
     * @var string $content
     * @Assert\NotBlank()
     * @Assert\Length( min=5 )
     */
    public $content;

    /**
     * @var string $userName
     * @Assert\NotBlank()
     * @Assert\Length( min=3 )
     *
     */
    public $userName;

    /**
     * @var string $userEmail
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "'{{ value }}' no es un email válido.",
     *     checkMX = true
     * )
     */

    public $userEmail;
}