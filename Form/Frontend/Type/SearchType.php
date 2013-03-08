<?php

namespace Desarrolla2\Bundle\BlogBundle\Form\Frontend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('q', 'text', array(
                    'required' => true,
                    'trim' => true,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Desarrolla2\Bundle\BlogBundle\Form\Frontend\Model\SearchModel',
            'csrf_protection' => false,
        ));
    }

    public function getName() {
        return '';
    }

}
