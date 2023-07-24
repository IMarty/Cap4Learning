<?php

namespace App\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Training;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ModuleAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Module', ['class' => 'col-md-9'])
            ->add('translations', TranslationsType::class, [
                'locales' => ['fr', 'en'],
                'default_locale' => getenv('LANGUAGE_DEFAULT'),
                'fields' => [
                    'title' => [
                        'field_type' => TextType::class,
                        'label' => 'Title',
                        'attr' => [
                            'class' => 'js-field-title'
                        ]
                    ],
                    'description' => [
                        'field_type' => CKEditorType::class,
                        'label' => 'Description',
                        'input_sync' => true,
                    ],
                ]
            ])
        ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('title')
        ;
    }
}