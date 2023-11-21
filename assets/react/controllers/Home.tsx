import React from 'react';
import Header from './Header';
import ProductGrid from './ProductGrid';
import useShoppingCart from '../Hooks/useShoppingCart';

export default function Home() {
    const { addItemToShoppingCart, ShoppingCart: ShoppingCart } = useShoppingCart();

    return (
        
        <>
            <Header  shoppingCart={ShoppingCart}/>
            <ProductGrid addItemToShoppingCart={addItemToShoppingCart} shoppingCart={ShoppingCart}/>
        </>
    )
}