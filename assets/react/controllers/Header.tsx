import React from 'react';
import { AppBar, Toolbar, Grid, IconButton, Badge } from '@mui/material';
import ShoppingBasketIcon from '@mui/icons-material/ShoppingBasket';
import StoreIcon from '@mui/icons-material/store';
import { visit } from '../../utils';


export default function Header({ shoppingCart}) {
    // créer un onclick quand on clique le icon de boutique redireger vers le page de home, lie avec inconbutton
    const showHome = () => {
        visit('/');
    }

    const showShoppingCart = () => { 
        visit('/shopping-cart');
    }

    const calculateTotalQuantity = () => { 
        return shoppingCart?.items?.map((item) => item.quantity).reduce((a, b) => a + b, 0);
    }
    return (
        
        <AppBar position="static">
            <Toolbar>
                <Grid container justifyContent="space-between" alignItems="center" style={{ width: ' 100%' }}>
                    <Grid item>
                        {/* icon de homepage */}
                        <IconButton color='inherit' onClick={showHome}>
                            <StoreIcon />
                        </IconButton>
                    </Grid>
                    {/* icon de panier */}
                    <Grid item>
                        <IconButton color='inherit' onClick={showShoppingCart}>
                            {/* compter les article de product dans le panier */}
                            <Badge badgeContent={calculateTotalQuantity()} color="secondary">
                            <ShoppingBasketIcon />
                            </Badge>
                            
                        </IconButton>
                    </Grid>
                </Grid>
            </Toolbar>
        </AppBar>
    )
}