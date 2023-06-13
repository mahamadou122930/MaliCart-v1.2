<?php

namespace App\Controller\Bani;

use App\Entity\ShopProductSubCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class ShopProductSubCategoryCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return ShopProductSubCategory::class;
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
