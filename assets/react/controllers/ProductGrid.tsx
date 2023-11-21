import React from 'react';
import { Box, Grid, Paper, Typography, Button, Stack} from "@mui/material";
import useProducts, { Product } from '../Hooks/useProducts';
import { formatPrice } from '../../utils';
import ShoppingBasketIcon from '@mui/icons-material/ShoppingBasket';

// récupérer les produts dans le hook 
export default function ProductGrid({ addItemToShoppingCart, shoppingCart}) {
    const products = useProducts();

    const handleProductLabel = (product: Product) => {
        const productInShoppingCart = shoppingCart?.items?.find(item => item.product.id === product.id);

        return productInShoppingCart ? `${productInShoppingCart.quantity} *` : 'Ajouter au panier';
    }

    return (
        
        <Grid container marginTop={5}>
            {products?.map((product) => (
                <Grid item key={product.id} xs={4}>
                    <Box sx={{ width: 300, m: 2 }}>
                        <Paper elevation={3} sx={{ p: 2 }}>
                            {/* 这里是价钱跟篮子的边框放到一起，也就是一个div */}
                            <Stack direction="column" spacing={2}>
                            <Box
                                component="img"
                                sx={{ width: '100%', height: 'auto' }}
                                // dans le dossier de public
                                src={`/images/products/${product.imageName}`}
                            />

                            <Typography variant='h6' gutterBottom>
                                {product.name}
                            </Typography>

                            <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between'}}>
                                <Typography variant='h6' color='secondary'>
                                    {/* 表示价钱的形式 */}
                                {formatPrice(product.price)}
                                </Typography>
                            </Box>

                            <Button
                                variant="outlined"
                                color='primary'
                                    endIcon={<ShoppingBasketIcon />}
                                    onClick={() => addItemToShoppingCart(product)}
                            >
                               {handleProductLabel(product)}
                            </Button>
                            </Stack>
                            
                      </Paper>
                    </Box>
                </Grid>
            ))}
        </Grid>
    )
}