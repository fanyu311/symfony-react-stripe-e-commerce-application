<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public function __construct(
        private StripeService $stripeService,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name')
            ->setRequired(true);

        yield TextareaField::new('description')
            ->setRequired(true);

        yield BooleanField::new('active');

        yield MoneyField::new('price')
            ->setCurrency('EUR')
            ->setRequired(true);

        yield Field::new('imageFile', 'Image')
            ->setFormType(VichFileType::class)
            ->onlyOnForms();

        yield TextField::new('stripeProductId', 'Identifiant Produit Stripe')
            ->hideWhenCreating();

        yield TextField::new('stripePriceId', 'Identifiant Prix Stripe')
            ->hideWhenCreating();
    }

    // modification de l'interface d'administration
    // 当你使用 Symfony 的 EasyAdminBundle 来管理实体对象（比如数据库中的表），你可以通过覆盖 persistEntity 方法来添加一些在保存实体对象到数据库之前需要执行的自定义代码。
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /**
         * @var Product $product
         */
        $product = $entityInstance;

        $stripeProduct = $this->stripeService->createProduct($product);

        // récupérer l'id de stripe de indentifier à signier moi à bdd
        $product->setStripeProductId($stripeProduct->id);

        // créer le prix
        $stripePrice = $this->stripeService->createPrice($product);

        $product->setStripePriceId($stripePrice->id);

        parent::persistEntity($entityManager, $entityInstance);
    }

    // 这是 Symfony 的 EasyAdminBundle 中用于自定义实体更新行为的方法，你覆盖了 updateEntity 方法。
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /**
         * @var Product $product
         */
        $product = $entityInstance;

        $this->stripeService->updateProduct($product);

        parent::updateEntity($entityManager, $entityInstance);
    }
}
