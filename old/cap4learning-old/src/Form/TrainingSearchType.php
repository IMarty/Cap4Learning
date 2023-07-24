<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class TrainingSearchType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => $this->translator->trans('Search'),
                'row_attr' => [
                    'class' => 'form-floating',

                ],
                'attr' => [
                    'placeholder' => ' '
                ],
                'required' => false
            ])
            ->add('eligibleCpf', CheckboxType::class, [
                    'required' => false,
                    'label' => $this->translator->trans('CPF eligible classes only'),
                    'row_attr' => [
                        'class' => '-spaced',
                    ],
                ]
            )
        ;
    }
}
