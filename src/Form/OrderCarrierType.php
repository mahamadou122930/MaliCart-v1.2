<?php

namespace App\Form;

use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderCarrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];


        $builder
    ->add('carriers', EntityType::class, [
            'label'=> 'Choisissez votre adresse de livraison',
            'required' => true,
            'class'=> Carrier::class,
            'multiple' => false,
            'expanded' => true
        ])
        -> add('submit', SubmitType::class, [
            'label' => 'Proceed to Payment',
            'attr' => [
                'class'=> 'btn btn-primary d-block w-100'
            ]
        ])
    ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user'=> array()
        ]);
    }
}
