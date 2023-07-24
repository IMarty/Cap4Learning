<?php

namespace App\Form;

use App\Entity\Contact;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'Demande de devis' => Contact::CONTACT_DEVIS,
                    'Je veux en savoir plus sur cette formation' => Contact::CONTACT_MORE_INFOS,
                    'Je souhaite avoir des renseignements pour une formule intra' => Contact::CONTACT_INTRA,
                    'Autres' => Contact::CONTACT_OTHER
                ],
                'label' => false
            ])
            ->add('name', TextType::class, [
                    'constraints' => new NotBlank(),
                    'label' => $this->translator->trans('Your name'),
                    'row_attr' => [
                        'class' => 'form-floating',

                    ],
                    'attr' => [
                        'placeholder' => ' '
                    ]
                ]
            )
            ->add('email', TextType::class, [
                    'constraints' => new Email(),
                    'label' => $this->translator->trans('Your email'),
                    'row_attr' => [
                        'class' => 'form-floating',

                    ],
                    'attr' => [
                        'placeholder' => ' '
                    ]
                ]
            )
            ->add('message', TextareaType::class, [
                    'constraints' => new NotBlank(),
                    'label' => $this->translator->trans('Your message'),
                    'row_attr' => [
                        'class' => 'form-floating',

                    ],
                    'attr' => [
                        'placeholder' => ' '
                    ]
                ]
            )
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'contact',
            ])
        ;
    }
}
