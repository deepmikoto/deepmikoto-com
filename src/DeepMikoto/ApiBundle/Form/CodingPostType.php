<?php

namespace DeepMikoto\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CodingPostType
 *
 * @package DeepMikoto\ApiBundle\Form
 */
class CodingPostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('categories', 'entity', [
                'class' => 'DeepMikoto\ApiBundle\Entity\CodingCategory',
                'expanded' => true,
                'multiple' => true
            ])
            ->add('content', 'textarea', [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('save', 'submit', [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'DeepMikoto\ApiBundle\Entity\CodingPost'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'deepmikoto_apibundle_codingpost';
    }
}
