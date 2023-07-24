<?php

namespace App\Admin;

use App\Entity\Contact;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class ContactAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Content', ['class' => 'col-md-9'])
            ->add('type', ChoiceType::class, [
                'choices' => self::getTypeChoices(),
            ])
            ->add('name')
            ->add('conversionPage')
            ->add('email')
            ->add('message')
        ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('getTypeLabel')
            ->add('name')
            ->add('email')
            ->add('message')
            ->add('createdAt')
        ;
    }


    protected static function getTypeChoices()
    {
        $choices = [
           'Devis' => Contact::CONTACT_DEVIS,
           "Plus d'information" => Contact::CONTACT_MORE_INFOS,
           'Formule intra' => Contact::CONTACT_INTRA,
           'Contact' => Contact::CONTACT_OTHER,
        ];

        return $choices;
    }

    public function preUpdate($object)
    {
    }
}