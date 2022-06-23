import React from 'react';
import { Box, Grid, Link, Typography } from '@mui/material';

const Footer = () => {

    return (
        <footer className="footer" >
            <Box className="footer-box" sx={{ background: 'black', textAlign: { xs: 'center', sm: 'start' } }}>
                <Grid container spacing={2} justifyContent="center" alignItems="flex-start" marginTop={0} paddingTop="4vh">
                    <Grid item xs={6} sm={3}>
                        <Typography variant="h1" color="#fff" gutterBottom>
                            M F L
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            Nous rapprochons le monde.
                        </Typography>
                        <Typography variant="h6" color="#fff" sx={{ fontWeight: 'bold' }} gutterBottom>
                            Be Local
                        </Typography>
                    </Grid>
                    <Grid item xs={6} sm={2}>
                        <Typography variant="h6" color="#fff" sx={{ fontWeight: 'bold' }} gutterBottom>
                            Explorer
                        </Typography>
                        <Link href="/" color="inherit">
                            <Typography variant="body1" color="#858585" gutterBottom>
                                Accueil
                            </Typography>
                        </Link>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            Les Fermes
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            Le projet
                        </Typography>
                    </Grid>
                    <Grid item xs={12} sm={2}>
                        <Typography variant="h6" color="#fff" sx={{ fontWeight: 'bold' }} gutterBottom>
                            Découvrir
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            1 Chemin Le Carretal<br />
                            31790, Saint-Sauveur<br />
                            31, Occitanie
                        </Typography>
                        <Typography variant="h6" color="#fff" marginTop="4vh" sx={{ fontWeight: 'bold' }} gutterBottom>
                            Contact
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            contact@mfl.com
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            +33 2 31 58 69 52
                        </Typography>
                    </Grid>
                    <Grid item xs={5} sm={2}>
                        <Typography variant="h6" color="#fff" sx={{ fontWeight: 'bold' }} gutterBottom>
                            Nous suivre
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            Instagram
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            Facebook
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            Pinterest
                        </Typography>
                    </Grid>
                    <Grid item xs={6} sm={2}>
                        <Typography variant="h6" color="#fff" sx={{ fontWeight: 'bold' }} gutterBottom>
                            Légal
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            Mentions Légales
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            CGU
                        </Typography>
                        <Typography variant="body1" color="#858585" gutterBottom>
                            Vos données
                        </Typography>
                    </Grid>
                </Grid>
                <Typography variant="body1" color="#858585" textAlign="center" marginTop="4vh">
                    © 2020 Mafermelocale. Tous droits réservés.
                </Typography>
            </Box>
        </footer>
    );

};

export default Footer;