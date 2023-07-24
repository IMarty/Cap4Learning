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
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ParagraphAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Paragraph', ['class' => 'col-md-9'])
            ->add('disposition', ChoiceType::class, [
                'choices'  => [
                    'Big image layout' => 'big_image',
                    'Small image layout' => 'small_image',
                    'One column' => 'one_column',
                    'Two columns' => 'two_column',
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'js-pg-disposition',
                ],
                'help' => 'Fields displayed switching disposition : <br><br>
                <b>Big image layout</b> : media + main column<br>
                <b>Small image layout</b> : media + main column<br>
                <b>One column</b> : main column + feature<br>
                <b>Two columns</b> : main column + secondary column + feature'
            ])

            ->add('media', ModelListType::class, [
                'required' => false,
                'row_attr' => [
                    'class' => 'js-pg-media',
                ],
                'attr' => [
                    'class' => 'js-pg-media',
                ],
            ])

            ->add('translations', TranslationsType::class, [
                'locales' => ['fr', 'en'],
                'default_locale' => getenv('LANGUAGE_DEFAULT'),
                'fields' => [
                    'textColumn1' => [
                        'field_type' => CKEditorType::class,
                        'label' => 'Main Column',
                        'row_attr' => [
                            'class' => 'js-pg-textColumn1',
                        ]
                    ],
                    'textColumn2' => [
                        'field_type' => CKEditorType::class,
                        'label' => 'Secondary column',
                        'row_attr' => [
                            'class' => 'js-pg-textColumn2',
                        ]
                    ],
                    'feature' => [
                        'field_type' => CKEditorType::class,
                        'label' => 'Feature',
                        'row_attr' => [
                            'class' => 'js-pg-feature',
                        ]
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
            ->addIdentifier('title')
            ->add('shortDescription')
            ->add('updatedAt')
            ->add('createdAt')
        ;
    }

    public function preUpdate($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }
}