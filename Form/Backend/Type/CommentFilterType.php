<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentFilterType extends AbstractType
{

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                ->add('text', 'text', array(
                    'required' => false,
                    'trim'     => true,
                ))
                ->add('status', 'choice', array(
                    'required' => false,
                    'trim'     => true,
                    'choices'  => array(
                        'pending' => 'pending',
                        'yes'     => 'yes',
                        'no'      => 'no',
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
            'data_class'      => 'Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\CommentFilterModel',
            'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'desarrolla2_bundle_blogbundle_comment_filter_type';
    }

}
