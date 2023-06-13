<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> false,
                'attr'=> [
                    'placeholder'=> 'Nommez Votre adresse'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label'=> false,
                'attr'=> [
                    'placeholder'=> 'Entrez Votre Prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label'=> false,
                'attr'=> [
                    'placeholder'=> 'Entrez votre Nom'
                ]
            ])
            ->add('company', TextType::class, [
                'label'=> false,
                'required' => false,
                'attr'=> [
                    'placeholder'=> '(facultatif) Entrez votre compagnie'
                ]
            ])
            ->add('address', TextType::class, [
                'label'=> false,
                'attr'=> [
                    'placeholder'=> 'Rue 610, Bacodji Marche'
                ] 
            ])
            ->add('postal', TextType::class, [
                'label'=> false,
                'attr'=> [
                    'placeholder'=> 'Entrez votre code postal'
                ]
            ])
            ->add('city', TextType::class, [
                'label'=> false,
                'attr'=> [
                    'placeholder'=> 'Votre Ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label'=> false,
                'attr'=> [
                    'class'=> 'form-select',
                ]
            ])
            ->add('phone', TelType::class, [
                'label'=> false,
                'attr'=> [
                    'placeholder'=> 'Votre Numéro de Téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'Save my address'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
