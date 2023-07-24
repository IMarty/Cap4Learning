<?php

namespace App\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\News;
use App\Entity\Training;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class PageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Content', ['class' => 'col-md-9'])
//            ->add('picture', ModelListType::class, [
//                'required' => false,
//            ])
            ->add('translations', TranslationsType::class, [
                'locales' => ['fr', 'en'],
                'default_locale' => getenv('LANGUAGE_DEFAULT'),
                'fields' => [
                    'title' => [
                        'field_type' => TextType::class,
                        'label' => 'Titre',
                        'attr' => [
                            'class' => 'js-field-title',
                            'maxlength' => 255
                        ],
                        'required' => true,
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
                    'shortDescription' => [
                        'field_type' => TextareaType::class,
                        'label' => 'Description courte (+ SEO description)',
                        'required' => true,
                        'attr' => [
                            'maxlength' => 255
                        ]
                    ],
                    'longDescription' => [
                        'field_type' => CKEditorType::class,
                        'label' => 'Description longue (page détail)',
                        'required' => true,
                    ],
                ]
            ])
        ->end();

        $formMapper->with('Meta data', ['class' => 'col-md-3'])
            ->add('linkedNews', EntityType::class, [
                'class' => News::class,
                'required' => false
            ])

            ->add('menu', ChoiceType::class, [
                'choices'  => [
                    'No menu attributed' => 'no-menu',
                    'secondary' => 'secondary',
                    'footer' => 'footer',
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('published', CheckboxType::class, [
                'required' => false,
            ])
        ->end();

        $formMapper->add('paragraphs', \Sonata\Form\Type\CollectionType::class, [
            'type_options' => [
                // Prevents the "Delete" option from being displayed
            'delete' => true,
            ]
        ], [
           'edit' => 'inline',
            'inline' => 'natural',
            'sortable' => 'position',
        ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('slug')
            ->add('published')
            ->add('updatedAt')
            ->add('createdAt')
        ;
    }

    public function preUpdate($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }
}