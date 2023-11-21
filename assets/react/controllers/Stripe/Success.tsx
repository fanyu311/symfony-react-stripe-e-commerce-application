import { CheckCircleOutline } from "@mui/icons-material";
import { Container, Box, Typography, Button } from "@mui/material";
import React from "react";
import { formatPrice, visit } from "../../../utils";

export default function Success({ amountTotal }) {
    return (
        <Container>
            <Box>
                <CheckCircleOutline color="success" />
                <Typography component="h1" variant="h4">
                    Paiement réussi
                </Typography>
                <Typography>
                    Merci pour votre achat de {formatPrice(amountTotal)}
                </Typography>
                <Box marginTop={2}>
                    <Button
                        variant="contained"
                        color="primary"
                        onClick={() => visit('/')}>
                        Retour à la boutique
                    </Button>
                </Box>
            </Box>
        </Container>
    )
}