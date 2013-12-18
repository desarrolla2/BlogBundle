<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Desarrolla2\Bundle\BlogBundle\Entity\Repository\TagRepository;
use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;

class PostType extends AbstractType
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
                    'required' => true,
                    'trim' => true,
                )
            )
            ->add(
                'image',
                'text',
                array(
                    'required' => false,
                    'trim' => true,
                )
            )
            ->add(
                'intro',
                'textarea',
                array(
                    'required' => false,
                    'trim' => true,
                )
            )
            ->add(
                'content',
                'textarea',
                array(
                    'required' => false,
                    'trim' => true,
                )
            )
            ->add(
                'tags',
                'entity',
                array(
                    'required' => false,
                    'multiple' => true,
                    'expanded' => true,
                    'class' => 'BlogBundle:Tag',
                    'query_builder' => function (TagRepository $repository) {
                            return $repository->getQueryBuilderForGet(100);
                        },
                )
            )
            ->add(
                'status',
                'choice',
                array(
                    'required' => true,
                    'trim' => true,
                    'choices' => array(
                        PostStatus::CREATED => 'created',
                        PostStatus::PUBLISHED => 'published',
                        PostStatus::PRE_PUBLISHED => 'pre published',
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
                'data_class' => 'Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\PostModel',
                'csrf_protection' => true,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backend_post_type';
    }

}
