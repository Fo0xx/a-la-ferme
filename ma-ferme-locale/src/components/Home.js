import { Button, Grid, Stack, Typography } from "@mui/material";
import { Box } from "@mui/system";
import React from "react";
import { getVideos } from "../services/Pexels";

class Home extends React.Component {

    state = {
        video: '',
        poster: '',
    }

    componentDidMount() {
        console.log('Home mounted');

        getVideos(2758322).then(res => {
            this.setState({ video: res.video_files[2].link, poster: res.image });
        });
    }

    //create an array of objects with all the products types
    products = [
        {
            name: 'Fruits',
            uri: './img/icons/fruits.png',
        },
        {
            name: 'Produits laitiers',
            uri: './img/icons/produits_laitiers.png',
        },
        {
            name: 'Huiles et graisses',
            uri: './img/icons/huiles_et_graisses.png',
        },
        {
            name: 'Légumes et légumineuses',
            uri: './img/icons/legumes_et_legumineuses.png',
        },
        {
            name: 'Céréales',
            uri: './img/icons/cereales.png',
        },
        {
            name: 'Viandes et poissons',
            uri: './img/icons/viandes_et_poissons.png',
        },
        {
            name: 'Sucreries',
            uri: './img/icons/sucreries.png',
        },
        {
            name: 'Condiments',
            uri: './img/icons/condiments.png',
        },
        {
            name: 'Boissons',
            uri: './img/icons/boissons.png',
        },
        {
            name: 'Autres',
            uri: './img/icons/autres.png',
        }
    ]

    render() {
        return (
            <>
                <Box textAlign="center" height="100vh">
                    <video id="background-video" poster={this.state.poster} playsInline autoPlay loop muted>

                        <source src={this.state.video} type="video/mp4" />

                    </video>
                    <Grid container justifyContent='center' sx={{ height: '90vh' }}>
                        <Grid item xs={12} display="inline-grid" alignContent="space-around" justifyContent="center">
                            <Typography color="common.white" variant="h1" sx={{ p: '5% 0' }}>
                                LE LOCAL POUR <br /> UN AVENIR MEILLEUR
                            </Typography>
                        </Grid>
                        <Grid item>
                            <Stack justifyContent="space-evenly" height='100%'>
                                <Button variant="contained" size="large" color="secondary" href="/farms">
                                    Je découvre le projet
                                </Button>
                                <Button variant="contained" size="large" color="thirdary" href="/login">
                                    Je cherche une ferme !
                                </Button>
                            </Stack>
                        </Grid>
                    </Grid>

                </Box>
                <Box sx={{ backgroundColor: "white" }} >
                    <Box pb="2%" sx={{ background: "no-repeat center url(./img/green_background.png)", backgroundSize: { xs: "100% 200%", sm: "cover" } }}>
                        <Grid container spacing={2} marginTop="0" alignItems="center">
                            <Grid item xs={12} sm={5}>
                                <img src="./img/produits_frais.png" alt="produits frais" style={{ maxWidth: "100%" }} />
                            </Grid>
                            <Grid item xs={12} sm={7}>
                                <Typography variant="h4" color="black" marginBottom="4vh">
                                    Vous êtes à la recherche de produits frais ?
                                </Typography>
                                <Typography variant="body1" color="black">
                                    Alors vous êtes au bon endroit !<br />
                                    Sur notre site nous répertorions plus d'un centaine de ferme
                                    sur le territoire français.<br />
                                    <br />
                                    Recherchez une ferme près de chez vous, commander les<br />
                                    produits dont vous avez besoin et direction la ferme !<br />
                                    <br />
                                    Nous proposons des fermes laitières, fromagères ou proposant
                                    des produits de la terre.
                                </Typography>
                            </Grid>
                        </Grid>
                    </Box>
                    <br />
                    <Box margin="4vh 0">
                        <Typography textAlign="center" variant="h4" color="black" marginBottom="4vh">
                            Quels produits pouvez-vous trouver sur Ma ferme locale ?
                        </Typography>
                        <Grid container columns={11} rowGap={2} justifyContent="space-around" sx={{ px: { xs: "5%", sm: "12%" } }}>
                            {this.products.map((product, index) => (
                                <Grid item key={index} xs={5} sm={2} borderRadius="16px" padding="1% 0" sx={{ backgroundColor: "#FBF4E9" }}>
                                    <img src={product.uri} alt={product.name} style={{ maxWidth: "100%", display: "block", margin: "0 auto" }} />
                                    <Typography variant="body1" color="black" textAlign="center" fontWeight={600} mt="2vh">
                                        {product.name}
                                    </Typography>
                                </Grid>
                            ))}
                        </Grid>
                    </Box>
                    <Box sx={{ backgroundColor: "#EAECE2" }}>
                        <Grid container spacing={2} marginTop="0" alignItems="center" justifyContent="center">
                            <Grid item xs={12} sm={6} sx={{ paddingLeft: { sm: "7vw" }, textAlign: { xs: "center", sm: "initial" } }}>
                                <Typography variant="h4" color="black" marginBottom="4vh">
                                    Une démarche développement durable
                                </Typography>
                                <Typography variant="body1" color="black">
                                    Ici tout le monde est gagnant, oui, tout le monde.
                                </Typography>
                                <br />
                                <Typography variant="body1" color="black">
                                    Le prix des produits est au plus juste pour le producteur
                                    comme le consommateur. Ainsi tout le monde est gagnant !
                                </Typography>
                                <br />
                                <Typography variant="body1" color="black">
                                    Plus de gaspillage, même les produits "moches" seront mis
                                    en ventes. Après tout, ils ont le même goûts 😉
                                </Typography>
                                <br />
                                <Typography variant="body1" color="black">
                                    Et si une ferme est proche de chez vous, n'hésitez pas à
                                    enfourcher le vélo !
                                </Typography>
                            </Grid>
                            <Grid item xs={12} sm={4}>
                                <img src="./img/feuille_eco.png" alt="Trio de feuilles représentant le durable" style={{ maxWidth: "100%" }} />
                            </Grid>
                        </Grid>
                    </Box>
                </Box>
            </>

        )
    }

}

export default Home;