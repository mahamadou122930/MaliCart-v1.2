<?php

namespace App\Form;

use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderCarrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder

        ->add('carrier', EntityType::class, [
            'class' => Carrier::class,
            'choice_label' => 'name',
            'expanded' => true,
            'choice_value' => 'id', // Specify the value to use for the carrier choices
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Proceed to Payment',
            'attr' => [
                'class' => 'btn btn-primary d-block w-100',
            ],
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, // Set the data class to null since you're not binding to an entity
        ]);
    }
}
