<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                ->add('file', 'file', array(
                    'required' => true,
                ))
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\ImageModel',
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
