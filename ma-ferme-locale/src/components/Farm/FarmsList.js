import React from 'react';
import { ApiClient } from '../../services/ApiClient';
import { Button, Divider, Grid, Link, Slider, Typography } from '@mui/material';
import { Box } from '@mui/system';

import AutocompleteBAN from './Positions/AutocompleteBAN';
import GeoLoc from './Positions/GeoLoc';
import Farm from './Farm';

class FarmsList extends React.Component {

    slugify(string) {
        const a = 'àáâäæãåāăąçćčđďèéêëēėęěğǵḧîïíīįìıİłḿñńǹňôöòóœøōõőṕŕřßśšşșťțûüùúūǘůűųẃẍÿýžźż·/_,:;'
        const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiiiilmnnnnoooooooooprrsssssttuuuuuuuuuwxyyzzz------'
        const p = new RegExp(a.split('').join('|'), 'g')

        return string.toString().toLowerCase()
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
            .replace(/&/g, '-and-') // Replace & with 'and'
            .replace(/[^\w-]+/g, '') // Remove all non-word characters
            .replace(/--+/g, '-') // Replace multiple - with single -
            .replace(/^-+/, '') // Trim - from start of text
            .replace(/-+$/, '') // Trim - from end of text
    }

    constructor(props) {
        super(props);

        this.state = {
            farms: [],
            longitude: '',
            latitude: '',
            radius: 10,
        };

        this.setLocation = this.setLocation.bind(this);
    }

    setFarms(farms) {
        this.setState({ farms });
    }

    setLocation(longitude, latitude) {
        this.setState({
            longitude: longitude,
            latitude: latitude
        });
    }


    getFarmByRadius() {

        ApiClient.get(`/api/farms/${this.state.longitude}/${this.state.latitude}/${this.state.radius}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => {
                this.setFarms(response.data.data.data);
            })
            .catch(error =>
                console.error(error),
                this.setFarms([])
            );
    }

    componentDidMount() {
        ApiClient.get(`/api/farms`, {
            headers: {
                Accept: 'application/json'
            }
        })
            .then(response => {
                this.setState({
                    farms: response.data.data
                });
                console.log(this.state.farms);
            })
            .catch(error =>
                console.error(error)
            );
    }

    componentWillUnmount() {
        this.setState({
            farms: []
        });
    }

    render() {

        return (
            <>
                <Box sx={{ width: '100vw', maxWidth: '100%', mx: 'auto' }}>
                    <Grid container spacing={0} >
                        <Grid item xs={12} md={6}>
                            <img src='./img/fresh_farm_products.png' alt='Produits frais de la ferme' style={{width: "100%"}} />
                        </Grid>
                        <Grid sx={{ display: 'grid', alignContent: 'space-evenly' }} item xs={12} md={6} padding="0 5%">
                            <Typography color='common.black' variant="h4" align='center'>
                                Filtrer votre recherche :
                            </Typography>

                            <Grid container spacing={2}>
                                <Grid item xs={12} sm={6}>
                                    <AutocompleteBAN maxResults={5} setLocation={this.setLocation} />
                                </Grid>
                                <Grid item xs={12} sm={6}>
                                    <GeoLoc setLocation={this.setLocation} />
                                </Grid>
                            </Grid>

                            <Slider
                                aria-label="Radius"
                                onChange={(event, newValue) => this.setState({ radius: newValue })}
                                defaultValue={10}
                                step={5}
                                marks
                                min={5}
                                max={25}
                                valueLabelDisplay="auto"
                                sx={{ borderRadius: '0 !important' }}
                            />
                            <Button onClick={() => this.getFarmByRadius()} variant="contained" color='black' size='large' fullWidth>
                                Rechercher
                            </Button>
                        </Grid>
                    </Grid>

                    <Divider sx={{ width: '50%', margin: '0 auto', border: '1px solid', background: 'black' }} variant='fullWidth' textAlign='center' />
                </Box>

                <Typography variant="h4" align='center' pb="5%">
                    Il y a <Typography color="primary" variant="h4" component="span">{this.state.farms.length}</Typography> ferme.s autour de vous
                </Typography>

                {
                    this.state.farms.length === 0 ?
                        <Typography variant="h4" align='center'>
                            Aucune ferme trouvée
                        </Typography>
                        :
                        <Grid container display="flex">
                            {
                                this.state.farms.map(farm =>
                                    <Link href={`/farms/${farm.id}`} key={farm.id} color="inherit" underline="none">
                                        <Grid item container xs={12} sm={5} data-farm-id={farm.id}>
                                            <Farm name={farm.name} short_description={farm.short_description} farm_image={farm.farm_image} />
                                        </Grid>
                                    </Link>
                                )
                            }
                        </Grid>
                }
            </>
        );
    }

}

export default FarmsList;