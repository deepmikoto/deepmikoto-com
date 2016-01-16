<?php

namespace DeepMikoto\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NewPhotographyPostType
 *
 * @package DeepMikoto\ApiBundle\Form
 */
class EditPhotographyPostType extends AbstractType
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
            ->add('location', 'text', [
                'attr' => [
                    'class' => 'form-control post-location'
                ]
            ])
            ->add('public', 'checkbox', [
                'attr' => [
                    'class' => 'form-control post-longitude'
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
            'data_class' => 'DeepMikoto\ApiBundle\Entity\PhotographyPost'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'deepmikoto_apibundle_photographypost';
    }
}
