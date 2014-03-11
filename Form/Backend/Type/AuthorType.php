<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuthorType extends AbstractType
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
                array(
                    'required' => true,
                    'trim' => true,
                )
            )
            ->add(
                'email',
                'text',
                array(
                    'required' => true,
                    'trim' => true,
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
                'data_class' => 'Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\AuthorModel',
                'csrf_protection' => true,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backend_author_type';
    }
}
