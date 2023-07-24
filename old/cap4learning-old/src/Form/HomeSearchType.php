<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class HomeSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                    'constraints' => new NotBlank(),
                    'label_attr' => [
                        'class' => 'visually-hidden'
                    ],
                    'attr' => [
                        'placeholder' => 'What to learn today?'
                    ]
                ]
            )
        ;
    }
}
