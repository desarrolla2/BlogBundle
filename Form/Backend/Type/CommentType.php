<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add(
                'content',
                'textarea',
                array(
                    'required' => true,
                    'trim' => true,
                )
            )
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
                'userWeb',
                'text',
                array(
                    'required' => false,
                    'trim' => true,
                )
            )
            ->add(
                'status',
                'choice',
                array(
                    'required' => false,
                    'trim' => true,
                    'choices' => array(
                        0 => 'pending',
                        1 => 'yes',
                        2 => 'no',
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
                'data_class' => 'Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\CommentModel',
                'csrf_protection' => true,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backend_comment_type';
    }

}
