<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                    'label' => 'Titre',
                    'attr' => [
                        'class' => 'js-field-title',
                        'maxlength' => 255
                    ],
                    'required' => true,
                ]
            )
            ->add('slug', TextType::class, [
                'label' => 'SLUG',
                'attr' => [
                    'class' => 'js-field-slug',
                    'maxlength' => 255
                ],
                'required' => true,
            ])
            ->add('metas',  TextareaType::class, [
                'label' => 'Metas Keywords (SEO)',
            ])
            ->add('shortDescription',  TextareaType::class, [
                'label' => 'Description courte (teaser + SEO description)',
                'required' => true,
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            ->add('longDescription',  CKEditorType::class, [
                'label' => 'Description longue (page detail)',
                'required' => true,
            ])
            ->add('requirements',  CKEditorType::class, [
                'label' => 'Prérequis',
                'required' => true,
            ])
            ->add('coveredSkills',  \Sonata\AdminBundle\Form\Type\CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Compétences ciblées'
            ])
            ->add('goals',  \Sonata\AdminBundle\Form\Type\CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Objectifs'
            ])
            ->add('audience',  CKEditorType::class, [
                'label' => 'Public ciblé',
                'required' => true,
            ])
            ->add('methods',  CKEditorType::class, [
                'label' => 'Méthodes',
                'required' => true,
            ])
            ->add('achievement',  CKEditorType::class, [
                'label' => 'Validation des acquis'
            ])
            ->add('trainer',  TextType::class, [
                'label' => 'Formateur'
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array('data_class'=>'App\Entity\TrainingTranslation'));
    }
}
