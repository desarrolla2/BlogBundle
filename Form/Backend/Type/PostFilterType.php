<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostFilterType extends AbstractType
{

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add(
                'name',
                'text',
                array(
                    'required' => false,
                    'trim' => true,
                )
            )
            ->add(
                'text',
                'text',
                array(
                    'required' => false,
                    'trim' => true,
                )
            )
            ->add(
                'order',
                'choice',
                array(
                    'required' => true,
                    'choices' => array(
                        'createdAt' => 'created_at',
                        'updatedAt' => 'updated_at',
                        'publishedAt' => 'published_at',
                        'name' => 'name',

                    ),
                )
            )
            ->add(
                'isPublished',
                'choice',
                array(
                    'required' => false,
                    'trim' => true,
                    'choices' => array(
                        'yes' => 'yes',
                        'no' => 'no',
                    ),
                )
            );
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\PostFilterModel',
                'csrf_protection' => false,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'desarrolla2_bundle_blogbundle_post_filter_type';
    }
}
