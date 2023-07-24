<?php

namespace App\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Address;
use App\Entity\TrainingCategory;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class TrainingCategoryAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Content', ['class' => 'col-md-9'])
            ->add('translations', TranslationsType::class, [
                'locales' => ['fr', 'en'],
                'default_locale' => getenv('LANGUAGE_DEFAULT'),
                'fields' => [
                    'title' => [
                        'field_type' => TextType::class,
                        'label' => 'Titre',
                        'attr' => [
                            'class' => 'js-field-title',
                            'required' => true,
                            'maxlength' => 255
                        ]
                    ],
                    'slug' => [
                        'field_type' => TextType::class,
                        'label' => 'SLUG',
                        'attr' => [
                            'class' => 'js-field-slug',
                            'maxlength' => 255
                        ],
                        'required' => true,
                    ],
                    'description' => [
                        'field_type' => TextareaType::class,
                        'label' => 'Description courte (+ SEO description)',
                        'required' => true,
                        'attr' => [
                            'maxlength' => 255
                        ]

                    ],
                ]
            ])
            ->add('parent', EntityType::class, [
                'class' => TrainingCategory::class,
                'required' => false
            ])
            ->add('weight', IntegerType::class, [
                'label' => 'Display order'
            ])
        ->end();

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('weight', 'integer', array('editable' => true, 'label' => 'Order') )
            ->add('parent')
            ->addIdentifier('title')
            ->add('slug')
            ->add('description')
        ;
    }
}