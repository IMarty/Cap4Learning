<?php

namespace App\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsFormsType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\Training;
use App\Entity\TrainingCategory;
use App\Form\TrainingTranslationType;
use Buzz\Middleware\ContentLengthMiddleware;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class TrainingAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Informations')
                ->with('Content', ['class' => 'col-md-9'])
                    ->add('translations', TranslationsFormsType::class, [
                        'locales' => ['fr', 'en'],
                        'default_locale' => getenv('LANGUAGE_DEFAULT'),
                        'form_type' => TrainingTranslationType::class
                    ])
                    ->add('modules', \Sonata\Form\Type\CollectionType::class, [
                         'type_options' => [
                             // Prevents the "Delete" option from being displayed
                             'delete' => true,
                         ],
                        'label' => 'Program',

                     ], [
                         'edit' => 'inline',
                         'inline' => 'table',
                         'sortable' => 'none',
                     ])
                ->end();

        $formMapper
                ->with('Meta data', ['class' => 'col-md-3'])
                    ->add('picture', ModelListType::class, [
                        'required' => false,
                    ])
                    ->add('file', ModelListType::class, [
                        'required' => false,
                    ], [
                        'link_parameters' => [
                            'context' => 'default',
                            'provider' => 'sonata.media.provider.file',
                        ]
                    ])
                    ->add('category', EntityType::class, [
                        'class' => TrainingCategory::class,
                        'required' => true,
                        'multiple' => false,
                    ])
                    ->add('priceInter', MoneyType::class, [
                        'required' => false,
                    ])
                    ->add('priceIntra', MoneyType::class, [
                        'required' => false,
                    ])
                    ->add('weight', IntegerType::class, [
                        'label' => 'Display order'
                    ])
                    ->add('durationDays', IntegerType::class, [
                        'label' => 'Session duration (/day)'
                    ])
                    ->add('durationHours', IntegerType::class, [
                        'label' => 'Session duration (/h)'
                    ])
                    ->add('eligibleCpf', CheckboxType::class, [
                        'required' => false,
                        'label' => 'CPF'
                    ])
                    ->add('nextDate', DateType::class, [
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => ['class' => 'js-datepicker'],
                    ])
                    ->add('published', CheckboxType::class, [
                        'required' => false,
                    ])
            ->end()
        ->end();

        $formMapper
            ->tab('Sessions')
                ->with('Sessions')
                    ->add('sessions', CollectionType::class, [
                    ], array(

                        'edit'            => 'inline',
                        'inline'          => 'table',
                        'sortable'        => 'position',
                        /*here provide service name for junction admin */
                    ))
                ->end()
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('weight', 'integer', array('editable' => true, 'label' => 'Order') )
            ->addIdentifier('title')
            ->addIdentifier('category')
            ->add('slug')
            ->add('published')
            ->add('updatedAt')
            ->add('createdAt')
        ;
    }

    public function preCreate($object)
    {
        $object = $this->setNextDate($object);
    }

    public function preUpdate($object)
    {
        $object = $this->setNextDate($object);
        $object->setUpdatedAt(new \DateTime());
    }

    public function setNextDate($object)
    {
        /** @var Training $object */
        $session = $object->getNextSession();
        if ($session) {
            $object->setNextDate($session->getStartDate());
        } else {
            $object->setNextDate(null);
        }
        return $object;
    }
}