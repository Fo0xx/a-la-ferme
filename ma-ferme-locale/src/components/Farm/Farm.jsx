import { Grid, Typography } from '@mui/material';
import React from 'react';
import { Link } from 'react-router-dom';
import { ApiClient } from '../../services/ApiClient';

class Farm extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            name: '',
            short_description: '',
            farm_image: '',
        };

    }

    render() {

        return (
            <Grid container>
                <Grid item container xs={3} sm={3}>
                    <img src={this.props.farm_image} alt={this.props.name} style={{ maxWidth: "100%" }} />
                </Grid>
                <Grid item container xs={12} sm={3}>
                    <Typography variant="h3" fontWeight="400" >{this.props.name}</Typography>
                    <Typography variant="body2">{this.props.short_description}</Typography>
                </Grid>
            </Grid>
        );
    }

}

export default Farm;