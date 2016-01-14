<?php

namespace DeepMikoto\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaticPageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'textarea', [
                'attr' => [
                    'class' => 'form-control form-group'
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
            'data_class' => 'DeepMikoto\ApiBundle\Entity\StaticPage'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'deepmikoto_apibundle_staticpage';
    }
}
