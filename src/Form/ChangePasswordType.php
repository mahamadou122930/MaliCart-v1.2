<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldpassword', PasswordType::class, [
                'mapped'=> false,
            ])
            ->add('newpassword', RepeatedType::class, [
                'type'=> PasswordType::class,
                'mapped'=> false,
                'invalid_message'=> 'le mot de passe et la configuration doivent être identique.',
                'first_options'=> [
                    'attr'=> [
                        'placeholder'=> 'Merci de saisir votre mot de passe.'
                    ]
                ],
                'second_options'=> [
                    'attr' => [
                        'placeholder'=> 'Merci de confirmer votre mot de passe.'
                    ]
                ]
            ])
            ->add('update', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
