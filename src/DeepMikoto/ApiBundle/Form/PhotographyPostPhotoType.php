<?php

namespace DeepMikoto\ApiBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('photographyPost', EntityType::class,[
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
            ->add('altText', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateTaken', DateType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('resolution', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('camera', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('exposure', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('iso', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('aperture', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('focalLength', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('file', FileType::class, [
                'required' => false,
            ])
            ->add('cover', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control post-longitude',
                    'style' => 'width: 20px;height: 20px;display: inline-block;'
                ]
            ])
            ->add('save', SubmitType::class, [
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
    public function getBlockPrefix()
    {
        return 'deepmikoto_apibundle_photographypostphoto';
    }
}
