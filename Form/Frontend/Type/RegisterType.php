<?php
/**
 * This file is part of the desarrolla2/blog-bundle project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Frontend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class RegisterType
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */
class RegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'userName',
                'text',
                array(
                    'required' => true,
                    'trim' => true,
                )
            )
            ->add(
                'userEmail',
                'text',
                array(
                    'required' => false,
                    'trim' => true,
                )
            )
            ->add(
                'userEmail',
                'text',
                array(
                    'required' => false,
                    'trim' => true,
                )
            )
            ->add(
                'plainPassword',
                'repeated',
                array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.password'),
                    'second_options' => array('label' => 'form.password_confirmation'),
                    'invalid_message' => 'Las contraseñas no coinciden',
                )
            )
            ->add(
                'captcha',
                'captcha',
                array(
                    'distortion' => false,
                    'charset' => '1234567890',
                    'length' => 3,
                    'invalid_message' => 'Código erroneo',
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Desarrolla2\Bundle\BlogBundle\Form\Frontend\Model\RegisterModel',
                'csrf_protection' => true,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'register';
    }
}
