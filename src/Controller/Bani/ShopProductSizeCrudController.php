<?php

namespace App\Controller\Bani;

use App\Entity\ShopProductSize;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ShopProductSizeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ShopProductSize::class;
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
