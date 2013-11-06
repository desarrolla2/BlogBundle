<?php

/**
 * This file is part of the planetubuntu project.
 *
 * Description of LinkType
 *
 * @author : Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>
 * @file : LinkType.php , UTF-8
 * @date : Mar 14, 2013 , 4:37:37 PM
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LinkType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text', array(
                    'required' => true,
                    'trim' => true,
                ))
                ->add('url', 'text', array(
                    'required' => true,
                    'trim' => true,
                ))
                ->add('rss', 'text', array(
                    'required' => false,
                    'trim' => true,
                ))
                ->add('mail', 'text', array(
                    'required' => false,
                    'trim' => true,
                ))
                ->add('description', 'textarea', array(
                    'required' => false,
                    'trim' => true,
                ))
                ->add('notes', 'textarea', array(
                    'required' => false,
                    'trim' => true,
                ))
                ->add('isPublished', 'choice', array(
                    'required' => false,
                    'trim' => true,
                    'choices' => array(
                        0 => 'no',
                        1 => 'yes',
                    ),
                ))
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\LinkModel',
            'csrf_protection' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_link_type';
    }

}
