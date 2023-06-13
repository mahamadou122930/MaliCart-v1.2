<?php

namespace App\Controller\Bani;

use App\Entity\ShopProduct;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class ShopProductCrudController extends AbstractCrudController
{

    public const ACTION_DUPLICATE = 'Duplicate';
    public const PRODUCTS_BASE_PATH = 'upload/images/products';
    public const PRODUCTS_UPLOAD_DIR = 'public/upload/images/products';


    public static function getEntityFqcn(): string
    {
        return ShopProduct::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new(self::ACTION_DUPLICATE,)
        ->linkToCrudAction('duplicateProduct')
        ->setCssClass('btn btn-info');

        
        return $actions
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->reorder(Crud::PAGE_EDIT, [self::ACTION_DUPLICATE, Action::SAVE_AND_RETURN]);

    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('subtitle'),
            TextareaField::new('description'),
            MoneyField::new('price', 'Prix')->setCurrency('XOF'),
            AssociationField::new('SubCategory'),
            AssociationField::new('Brand'),
            AssociationField::new('size')->setFormTypeOptions([
                'class'=>'App\Entity\ShopProductSize',
                'choice_label'=>'name',
                'multiple'=> true,
                'expanded'=> true,
                'by_reference'=> false,
                'attr' => [
                    'class' => 'select2',
                ],
            ])->setCustomOption('widget', 'select2'),
            AssociationField::new('color')->setFormTypeOptions([
                'class'=>'App\Entity\ShopProductColor',
                'choice_label'=>'name',
                'multiple'=> true,
                'expanded'=> true,
                'by_reference'=> false,
                'attr' => [
                    'class' => 'select2',
                ],
            ])->setCustomOption('widget', 'select2'),
            ImageField::new('illustration')
            ->setBasePath(self::PRODUCTS_BASE_PATH)
            ->setUploadDir(self::PRODUCTS_UPLOAD_DIR)
            ->setSortable(false),
            ImageField::new('illustration2')
            ->setBasePath(self::PRODUCTS_BASE_PATH)
            ->setUploadDir(self::PRODUCTS_UPLOAD_DIR)
            ->setSortable(false),
            ImageField::new('illustration3')
            ->setBasePath(self::PRODUCTS_BASE_PATH)
            ->setUploadDir(self::PRODUCTS_UPLOAD_DIR)
            ->setSortable(false),
            ImageField::new('illustration4')
            ->setBasePath(self::PRODUCTS_BASE_PATH)
            ->setUploadDir(self::PRODUCTS_UPLOAD_DIR)
            ->setSortable(false),
            SlugField::new('slug')->setTargetFieldName('subtitle'),
            BooleanField::new('statut'),
        ];
    }

    public function duplicatedProduct(
        AdminContext $context,
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $em
        ): Response
    {
        /** @Var Product $product */
        $product = $context->getEntity()->getInstance();

        $duplicatedProduct = clone $product;

        parent::persistEntity($em, $duplicatedProduct);

        $url= $adminUrlGenerator->setController(self::class)
        ->setAction(Action::DETAIL)
        ->setEntityId($duplicatedProduct->getId())
        ->generateUrl();

        return $this->redirect($url);
    }
}
