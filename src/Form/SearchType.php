<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\ShopProductSubCategory;
use Doctrine\DBAL\Types\BooleanType;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label'=> false,
                'required'=> false,
                'attr'=> [
                    'palceholder'=> 'Votre Recherche ...'
                ]
            ])
            
            ->add('SubCategory', EntityType::class, [
                'label'=> false,
                'required'=> false,
                'class'=> ShopProductSubCategory::class,
                'multiple'=>true
                ])    
            ->add('min', NumberType::class, [
                'label'=> false,
                'required'=> false,
                'attr' => [
                    'class'=>'form-control range-slider-value-min',
                    'placeholder'=> 'Prix Min'
                ]
                ])    
            ->add('max', NumberType::class, [
                'label'=> false,
                'required'=> false,
                'attr' => [
                    'class'=>'form-control range-slider-value-max',
                    'placeholder'=> 'Prix Max'
                ]
                ])    
            ->add('promo', CheckboxType::class, [
                'label'=> 'En promotion',
                'required'=> false,
                ])    
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer',
                'attr' => [
                    'class'=> 'btn-block btn-info'
                    ]
                ])
            
            
            ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection'=> false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}