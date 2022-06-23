import { Grid, Typography } from "@mui/material";
import { Box } from "@mui/system";
import React, { Suspense } from "react";
import { ApiClient } from "../../services/ApiClient";
import { getPhotos } from "../../services/Pexels";

import PermIdentityOutlinedIcon from '@mui/icons-material/PermIdentityOutlined';
import PinDropIcon from '@mui/icons-material/PinDrop';

class MyAccount extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            user: '',
            role: '',
            address: '',
            backgroundImage: '',
        }
    }

    componentDidMount() {
        getPhotos(288621).then(res => {
            this.setState({ backgroundImage: res.src.large2x });
        });

        //make a get request to the api/user endpoint with the token in the header
        //set the state to the response
        ApiClient.get('api/user', {
            headers: {
                Accept: 'application/json',
                Authorization: `Bearer ${localStorage.getItem('userToken')}`
            }
        }).then(res => {
            this.setState({
                user: res.data.data,
                role: res.data.data.role,
                address: res.data.data.address,
            });
            console.log(this.state.role);
        }).catch(err => {
            console.log(err);
        });
    }

    render() {
        return (
            <>
                <Box height="30vh" width="100%" position="relative" mb="17vh">
                    <Box zIndex={1} padding="2% 3%" width={{ xs: "100%", sm: "80%" }} position="absolute" borderRadius="40px" left="50%" bottom="-50%" sx={{ backgroundColor: "#315955", transform: "translateX(-50%)" }}>
                        <Grid container direction="row">
                            <Grid item container xs={12} sm={6}>
                                <Grid container direction="row" columnSpacing={2} rowSpacing={0}>
                                    <Grid item container xs={12} sm={4}>
                                        <img src="./img/poule_avatar.png" alt="avatar" style={{ width: "100%", height: "100%", objectFit: "cover", border: "5px solid black", borderRadius: "10%", position: "relative", bottom: "50%" }} />
                                    </Grid>
                                    <Grid item container xs={12} sm={8} alignContent="flex-start">
                                        <Suspense fallback={<div>Loading...</div>}>
                                            <Typography variant="h3" color="common.white" width="100%">Bonjour, {this.state.user.first_name}</Typography>
                                            <Typography variant="body1" color="common.black">{this.state.role.name}</Typography>
                                        </Suspense>
                                    </Grid>
                                </Grid>
                            </Grid>
                            <Grid item container xs={12} sm={6} pl="5%" borderLeft="1px solid black">
                                <Grid container direction="row" rowSpacing={5}>
                                    <Grid item container xs={12} sm={6}>
                                        <Typography variant="h6" align="left" fontWeight="bold" width="100%">
                                            ADRESSE MAIL
                                        </Typography>
                                        <Typography variant="body1" align="left" fontWeight="bold" color="common.white">
                                            {this.state.user.email}
                                        </Typography>
                                    </Grid>
                                    <Grid item container xs={12} sm={6}>
                                        <Typography variant="h6" align="left" fontWeight="bold" width="100%">
                                            ADRESSE
                                        </Typography>
                                        <Typography variant="body1" align="left" fontWeight="bold" color="common.white" maxWidth="65%">
                                            {this.state.address.address},<br />
                                            {this.state.address.postcode} {this.state.address.city}
                                        </Typography>
                                    </Grid>
                                    <Grid item container xs={12} sm={6}>
                                        <Typography variant="h6" align="left" fontWeight="bold" width="100%">
                                            TELEPHONE
                                        </Typography>
                                        <Typography variant="body1" align="left" fontWeight="bold" color="common.white">
                                            {this.state.address.phone}
                                        </Typography>
                                    </Grid>
                                </Grid>
                            </Grid>
                        </Grid>
                    </Box>
                    <img src={this.state.backgroundImage} alt="background" style={{ width: "100%", height: "100%", objectFit: "cover" }} />
                </Box>
                <Box px="5%">
                    <Grid container direction="row" justifyContent="space-evenly" alignItems="center" >
                        <Grid item container justifyContent="center" xs={12} sm={4} backgroundColor="#BFB063" borderRadius="10px">
                            <PermIdentityOutlinedIcon sx={{ fontSize: 50 }} />
                            <Typography variant="h2" align="center" fontFamily="Karla" color="common.black" width="100%">
                                MON PROFIL
                            </Typography>
                        </Grid>
                        <Grid item container justifyContent="center" xs={12} sm={4} backgroundColor="#BFB063" borderRadius="10px">
                            <PinDropIcon sx={{ fontSize: 50 }} />
                            <Typography variant="h2" align="center" fontFamily="Karla" color="common.black" width="100%" >
                                MON ADRESSE
                            </Typography>
                        </Grid>
                    </Grid>
                </Box>
            </>
        );
    }

}

export default MyAccount;