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

namespace Desarrolla2\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * ProfileType
 */
class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                [
                    'required' => false,
                    'trim' => true,
                ]
            )
            ->add(
                'address',
                'text',
                [
                    'required' => false,
                    'trim' => true,
                ]
            )
            ->add(
                'description',
                'textarea',
                [
                    'required' => false,
                    'trim' => true,
                ]
            )
            ->add(
                'show_public_profile',
                'checkbox',
                [
                    'required' => false,
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
                'data_class' => 'Desarrolla2\Bundle\BlogBundle\Form\Model\ProfileModel',
                'csrf_protection' => true,
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'profile';
    }
}
