import { Divider, Grid, Stack, Typography } from "@mui/material";
import { Box } from "@mui/system";
import React, { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import { ApiClient } from "../../services/ApiClient";

import CreditCardIcon from '@mui/icons-material/CreditCard';
import PetsOutlinedIcon from '@mui/icons-material/PetsOutlined';
import AccessibleForwardOutlinedIcon from '@mui/icons-material/AccessibleForwardOutlined';
import EggIcon from '@mui/icons-material/Egg';
import MapIcon from '@mui/icons-material/Map';
import FarmMap from "./FarmMap";


const ShowFarm = () => {

    let { farmId } = useParams(); //get the id of the farm from the url params

    let [farm, setFarm] = useState({}); //create a state for the farm
    let [vote, setVote] = useState([]); //create a state for the vote
    let [farmDetail, setFarmDetail] = useState({}); //create a state for the farm detail
    let [address, setAddress] = useState({}); //create a state for the address
    let [user, setUser] = useState({}); //create a state for the user
    let [products, setProducts] = useState([]); //create a state for the products
    let [longitude, setLongitude] = useState(0); //create a state for the longitude
    let [latitude, setLatitude] = useState(0); //create a state for the latitude


    /**
     * Fetch the farm data from the API and set it in the state
     * 
     */
    useEffect(() => {
        ApiClient.get(`api/farms/${farmId}?include=votes,farm_detail,address,user,products`, {
            headers: {
                Accept: 'application/json'
            }
        }).then(response => {
            setFarm(response.data.data);
            setVote(response.data.data.votes);
            setFarmDetail(response.data.data.farm_detail);
            setAddress(response.data.data.address);
            setUser(response.data.data.user);
            setProducts(response.data.data.products);
            setLongitude((1 * response.data.data.address.lon));
            setLatitude((1 * response.data.data.address.lat));
        }).catch(error => {
            console.error(error);
        }
        )

    }, [farmId]);

    return (
        <>
            <Box height={{ md: "100vh" }}>
                <Box height={{ xs: "10vh", sm: "36vh" }} mb={2}>
                    <img src={farm.farm_image} alt={farm.name} style={{ width: "100%", height: "100%", objectFit: 'cover' }} />
                </Box>
                <Typography textAlign="center" variant="h1" fontWeight="400" width="100%">{farm.name}</Typography>
                <Typography textAlign="center" variant="h4" width="100%" mb={{ xs: 3, sm: false }}>{address.address}, {address.postcode} {address.city}</Typography>
                <Box mx={{ xs: 2, sm: 5 }} position={{ lg: "absolute" }} bottom={0} mb={{ xs: 3, sm: 7 }}>
                    <Grid container spacing={2} direction={{ xs: "column-reverse", sm: "row" }} justifyContent="space-between">
                        <Grid item xs={12} sm={8}>
                            <Typography variant="body1" width="100%" whiteSpace="pre-line" fontWeight={600}>{farmDetail.about}</Typography>
                        </Grid>
                        <Grid direction="column" item xs={12} sm={3.5} >
                            <Grid display="grid" alignItems="center" justifyContent="center" height="7vh" bgcolor="#315955" xs={12}>
                                <Typography variant="h3" width="100%" color="common.white">Informations utiles</Typography>
                            </Grid>
                            <Grid item xs={12} color="#BFB063" minHeight="15vh" height="auto" display="grid" border="1px solid #315955">
                                <Stack direction="row" alignItems="center" justifyContent="center" rowGap={5} gap={2}>
                                    <CreditCardIcon />
                                    <Typography variant="h5">Carte bancaire acceptée</Typography>
                                </Stack>
                                <Stack direction="row" alignItems="center" justifyContent="center" gap={2}>
                                    <PetsOutlinedIcon />
                                    <Typography variant="h5">Animaux acceptés</Typography>
                                </Stack>
                                <Stack direction="row" alignItems="center" justifyContent="center" gap={2}>
                                    <AccessibleForwardOutlinedIcon />
                                    <Typography variant="h5">Accessible aux handicapés</Typography>
                                </Stack>
                            </Grid>
                        </Grid>
                    </Grid>
                </Box>
            </Box>
            <Typography variant="body1" fontStyle="italic" mx={{ xs: 2, sm: 7 }} mb={{ xs: 2, sm: 5 }} textAlign="center">
                Afin de garantir la sécurité de tous, les producteurs Ma Ferme Locale se mobilisent au quotidien pour mettre en œuvre
                toutes les mesures sanitaires liées à l'épidémie de COVID19. Cela concerne toutes les activités proposées par notre réseau.
                Mangez et Vivez fermier en toute sérénité ! Pour toute question, n'hésitez pas à contacter nos producteurs.
            </Typography>
            <Stack direction={{ xs: "column", sm: "row" }} alignItems="center" justifyContent="start" gap={2} mx={5} mb={{ xs: 2, sm: 5 }}>
                <EggIcon fontSize="large" sx={{ color: "#012840" }} />
                <Typography color="#012840" variant="h2">PRODUIT(S) DE LA FERME</Typography>
            </Stack>
            <Grid container rowGap={3} direction="row" justifyContent="flex-start" alignItems="flex-start" mb={{ xs: 2, sm: 5 }}>
                {products.map((product, index) => {
                    return (
                        <Grid item xs={6} sm={4} md={2.4} key={index}>
                            <Stack direction="column" alignItems="center" justifyContent="center" gap={1}>
                                <Box width={{ xs: 120, md: 250 }} height={{ xs: 120, md: 250 }}>
                                    <img src={product.product_image} alt={product.product_name} style={{ width: "100%", height: "100%", objectFit: 'cover', border: "4px solid #315955" }} />
                                </Box>
                                <Typography variant="h5" width={{ xs: 120, md: 250 }} fontWeight={400} textAlign="center" color="#484848">{product.product_name}</Typography>
                                <Typography variant="body1" fontWeight={600} color="#788C64">{product.price} €</Typography>
                            </Stack>
                        </Grid>
                    )
                }
                )}
            </Grid>
            <Stack direction={{ xs: "column", sm: "row" }} alignItems="center" justifyContent="start" gap={2} mx={5} mb={{ xs: 2, sm: 5 }}>
                <MapIcon fontSize="large" sx={{ color: "#012840" }} />
                <Typography color="#012840" variant="h2">Contact & plan d'accès</Typography>
            </Stack>
            <Box mx={{ xs: 2, sm: 5 }} mb={{ xs: 3, sm: 7 }}>
                <Grid container direction="row" spacing={2}>
                    <Grid item xs={12} md={6}>
                        <Typography variant="h4" fontWeight={400} color="primary">Coordonnées</Typography>
                        <Divider width="50%" sx={{ bgcolor: "primary.light" }} />
                        <Typography variant="body1" fontWeight={600} color="primary" mb={{ xs: 2, sm: 5 }}>Contact : {user.first_name} {user.last_name}</Typography>

                        <Typography variant="body1" fontWeight={600} color="primary">Adresse : {address.address}, {address.postcode} {address.city}</Typography>
                        <Typography variant="body1" fontWeight={600} color="primary">Courriel : {farmDetail.business_mail}</Typography>
                        <Typography variant="body1" fontWeight={600} color="primary" mb={{ xs: 2, sm: 5 }}>Téléphone : {farmDetail.phone}</Typography>

                        <Typography variant="body1" fontWeight={600} color="primary">Facebook : facebook.com/{farmDetail.facebook_id}</Typography>
                        <Typography variant="body1" fontWeight={600} color="primary" mb={{ xs: 2, sm: 5 }}>Instagram : instagram.com/{farmDetail.instagram_id}</Typography>

                        <Typography variant="h4" fontWeight={400} color="primary">Indications routières</Typography>
                        <Divider width="50%" sx={{ bgcolor: "primary.light" }} />
                        <Typography variant="body1" fontWeight={600} color="primary" mb={{ xs: 2, sm: 5 }}>
                            Depuis Flers direction Domfront (D962). 500 mètres avant La Chappelle-au-Moine
                        </Typography>
                    </Grid>
                    <Grid item xs={12} md={6} height={{xs: "43vh", md: "auto"}}>
                        <FarmMap longitude={longitude} latitude={latitude} zoom={12} farmName={farm.name} />
                    </Grid>
                </Grid>
            </Box>
        </>
    );
}

export default ShowFarm;

