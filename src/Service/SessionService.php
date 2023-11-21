<?php

namespace App\Service;

use App\Entity\Product;
use App\Model\ShoppingCart;
use App\Model\ShoppingCartItem;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionService
{
    // clé de notre session
    public const SHOPPING_CART = 'shoppingCart';

    // 构造函数的注入声明告诉Symfony在创建你的服务实例时将 RequestStack 传递给构造函数。通过这种方式，你的服务可以在需要时访问当前请求的信息。
    public function __construct(
        private RequestStack $requestStack
    ) {
    }

    public function getShoppingCart(): ShoppingCart
    {
        // 1èrm paramètre est clé de session , 2ème paramètre est si le clé de session n'existe pas , on va créer un nouveau shoppingcart en session
        return $this->getSession()->get(self::SHOPPING_CART, new ShoppingCart());
    }

    public function addItemToShoppingCart(Product $product): void
    {
        $shoppingCart = $this->getShoppingCart();

        $existingShoppingCartItem = $this->getExistingShoppingCardItem($product);

        if ($existingShoppingCartItem) {
            $existingShoppingCartItem->quantity++;
        } else {
            $shoppingCart->items->add(new ShoppingCartItem($product, 1));
        }

        $this->getSession()->set(self::SHOPPING_CART, $shoppingCart);
    }

    public function removeItemFromShoppingCart(Product $product): void
    {
        $shoppingCart = $this->getShoppingCart();

        $existingShoppingCartItem = $this->getExistingShoppingCardItem($product);

        if (null === $existingShoppingCartItem) {
            return;
        }

        $shoppingCart->items->removeElement($existingShoppingCartItem);

        $reindexedItems = array_values($shoppingCart->items->toArray());
        $shoppingCart->items = new ArrayCollection($reindexedItems);

        $this->getSession()->set(self::SHOPPING_CART, $shoppingCart);
    }

    private function getExistingShoppingCardItem(Product $product)
    {
        // ça c'est existe 
        $existingShoppingCartItem = $this
            ->getShoppingCart()
            ->items
            // créer une closure
            ->filter(fn (ShoppingCartItem $item) => $item->product->getId() === $product->getId())
            ->first();

        // c'est false
        if (false === $existingShoppingCartItem) {
            return null;
        }

        return $existingShoppingCartItem;
    }


    // pour ne pas avoir à faire un $this->getrequest à chaque fois 
    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
