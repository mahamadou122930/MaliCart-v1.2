<?php

namespace App\Controller\Bani;

use App\Entity\ShopProductBrand;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ShopProductBrandCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShopProductBrand::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
