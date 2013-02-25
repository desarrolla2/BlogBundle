<?php

/**
 * This file is part of the desarrolla2 proyect.
 * 
 * Copyright (c)
 * dgonzalez 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */
namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * 
 * Description of ImageFilterType
 *
 * @author : dgonzalez 
 * @file : ImageFilterType.php , UTF-8
 * @date : Feb 25, 2013 , 12:56:15 PM
 */
class ImageFilterType  extends AbstractType
{

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                ->add('file', 'text', array(
                    'required' => true,
                    'trim'     => true,
                ))
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\ImageFilterModel',
            'csrf_protection' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'desarrolla2_bundle_blogbundle_image_type';
    }

}
