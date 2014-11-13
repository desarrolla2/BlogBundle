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

namespace Desarrolla2\Bundle\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * ContactType
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'content',
                'textarea',
                [
                    'required' => false,
                    'trim' => true,
                ]
            )
            ->add(
                'userName',
                'text',
                [
                    'required' => true,
                    'trim' => true,
                ]
            )
            ->add(
                'userEmail',
                'text',
                [
                    'required' => true,
                    'trim' => true,
                ]
            )
            ->add(
                'captcha',
                'captcha',
                [
                    'distortion' => false,
                    'charset' => '1234567890',
                    'length' => 3,
                    'invalid_message' => 'Codigo erroneo',
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Desarrolla2\Bundle\WebBundle\Form\Model\ContactModel',
                'csrf_protection' => true,
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contact';
    }
}