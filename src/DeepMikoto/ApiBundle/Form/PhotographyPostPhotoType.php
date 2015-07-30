<?php

namespace DeepMikoto\ApiBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PhotographyPostPhotoType
 *
 * @package DeepMikoto\ApiBundle\Form
 */
class PhotographyPostPhotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photographyPost', 'entity',[
                'class' => 'DeepMikoto\ApiBundle\Entity\PhotographyPost',
                'placeholder' => 'Choose a photography post',
                'empty_data' => null,
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'query_builder' => function ( EntityRepository $er ) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.date', 'DESC');
                }
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
            'data_class' => 'DeepMikoto\ApiBundle\Entity\PhotographyPostPhoto'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'deepmikoto_apibundle_photographypostphoto';
    }
}
