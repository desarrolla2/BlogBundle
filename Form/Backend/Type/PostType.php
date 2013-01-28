<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                ->add('name', 'text', array(
                    'required' => true,
                    'trim'     => true,
                ))
                ->add('intro', 'textarea', array(
                    'required' => false,
                    'trim'     => true,
                ))
                ->add('content', 'textarea', array(
                    'required' => false,
                    'trim'     => true,
                ))
                ->add('tags', 'entity', array(
                    'required' => false,
                    'multiple' => true,
                    'expanded' => true,
                    'class'    => 'BlogBundle:Tag',
                ))
                ->add('isPublished', 'choice', array(
                    'required' => false,
                    'trim'     => true,
                    'choices'  => array(
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
            'data_class'      => 'Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\PostModel',
            'csrf_protection' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'desarrolla2_bundle_blogbundle_post_type';
    }

}
