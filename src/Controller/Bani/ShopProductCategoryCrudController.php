<?php

namespace App\Controller\Bani;

use App\Entity\ShopProductCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ShopProductCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShopProductCategory::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('SubCategory')->setFormTypeOptions([
                'class'=>'App\Entity\ShopProductSubCategory',
                'choice_label'=>'name',
                'multiple'=> true,
                'expanded'=> true,
                'by_reference'=> false,
                'attr' => [
                    'class' => 'select2',
                ],
            ])->setCustomOption('widget', 'select2'),
        ];
    }
    
}
