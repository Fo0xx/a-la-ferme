import { styled } from "@mui/material/styles";
import { Grid, Typography } from '@mui/material';
import React from 'react';
import { Link } from 'react-router-dom';
import { ApiClient } from '../../services/ApiClient';

const Farm = (props) => {

    const Img = styled("img")({
        objectFit: "cover",
        maxWidth: "100%",
        maxHeight: "100%"
    });

    return (
        <Grid container>
            <Grid item xs={4}>
                <Img
                    src={props.farm_image} alt={props.name}
                />
            </Grid>
            <Grid item xs={12} sm container>
                <Grid item xs container direction="column">
                    <Grid item xs>
                        <Typography gutterBottom variant="h4" component="div">
                            {props.name}
                        </Typography>
                        <Typography variant="body2" gutterBottom>
                            {props.short_description}
                        </Typography>
                    </Grid>
                </Grid>
            </Grid>
        </Grid>
    );


}

export default Farm;