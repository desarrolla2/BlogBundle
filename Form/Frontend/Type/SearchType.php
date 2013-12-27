<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Frontend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SearchType
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */
class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'q',
                'text',
                array(
                    'required' => true,
                    'trim' => true,
                )
            )
            ->add(
                'page',
                'hidden',
                array(
                    'required' => false,
                    'trim' => true,
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
                'data_class' => 'Desarrolla2\Bundle\BlogBundle\Form\Frontend\Model\SearchModel',
                'csrf_protection' => false,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
