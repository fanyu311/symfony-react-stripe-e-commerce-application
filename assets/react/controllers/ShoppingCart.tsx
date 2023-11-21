import React from 'react';
import useShoppingCart from '../Hooks/useShoppingCart';
import Header from './Header';
import { Box, Grid, Typography, Container, Button } from '@mui/material';
import ShoppingCartTable from './ShoppingCartTable';
import { visit } from '../../utils';

export default function ShoppingCart() {
    const { removeItemFromShoppingCart, ShoppingCart: ShoppingCart } = useShoppingCart();
    
    const createCheckoutSession = () => { 
        fetch('/stripe/checkout-sessions', {
            method: 'POST',
        })
            .then(response => response.json())
            .then(json => {
                visit(json['url']);
            });
    }
    return (
        <>
            <Header shoppingCart={ShoppingCart} />
            <Container>
            <Box marginY={5}>
                <Grid container justifyContent="space-between" alignItems="center">
                    <Grid item>
                        <Typography variant='h5'>Mon panier</Typography>
                        </Grid>
                        <Grid item>
                            <Button variant='contained' color="primary" onClick={createCheckoutSession}>
                                Procéder au paiment
                            </Button>
                        </Grid>
                </Grid>
                </Box>
                <ShoppingCartTable
                    removeItemFromShoppingCart={removeItemFromShoppingCart}
                    shoppingCart={ShoppingCart}/>
            </Container>
            
        </>
    )
}