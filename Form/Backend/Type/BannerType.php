<?php
/**
 * This file is part of the desarrolla2/blog-bundle package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * BannerType
 */
class BannerType extends AbstractType
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
                'content',
                'textarea',
                array(
                    'required' => false,
                    'trim' => true,
                )
            )
            ->add(
                'weight',
                'integer',
                array(
                    'required' => true,
                )
            )
            ->add(
                'isPublished',
                'choice',
                array(
                    'required' => false,
                    'trim' => true,
                    'choices' => array(
                        0 => 'no',
                        1 => 'yes',
                    ),
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
                'data_class' => 'Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\BannerModel',
                'csrf_protection' => true,
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backend_banner_type';
    }
}
