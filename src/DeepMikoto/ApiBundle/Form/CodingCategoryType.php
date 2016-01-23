<?php

namespace DeepMikoto\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodingCategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('file', 'file', [
                'required' => false,
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
            'data_class' => 'DeepMikoto\ApiBundle\Entity\CodingCategory'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'deepmikoto_apibundle_codingcategory';
    }
}
