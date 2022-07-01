import React from 'react';
import { ApiClient } from '../../../services/ApiClient';
import { getPhotos } from '../../../services/Pexels';
import user from '../User';
import { Typography, TextField, Button, FormControlLabel, Link, Box, Grid, Switch } from '@mui/material';
import AccountCircleIcon from '@mui/icons-material/AccountCircle';

export default class LoginForm extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            confirm_password: '',
            showPassword: false,
            role: true, //if true, the role will be farmer, else, the role will be user
            backgroundImage: null
        };
    }

    componentDidMount() {
        // Get the background image from Pexels API
        getPhotos(158179).then(res => {
            this.setState({ backgroundImage: res.src.large2x });
        });
    }

    handleClickShowPassword = () => {
        this.setState({ showPassword: !this.state.showPassword });
    };

    handleSubmit = (e) => {
        e.preventDefault();

        ApiClient.post(`api/register`, {
            headers: {
                Accept: 'application/json'
            },
            first_name: this.state.first_name,
            last_name: this.state.last_name,
            email: this.state.email,
            password: this.state.password,
            confirm_password: this.state.confirm_password,
            role_id: this.state.role ? 1 : 2
        }).then(response => {
            user.authenticated(response.data, this.authenticatedCallback)
        }).catch(error =>
            //check if response status is 404, alert user that email or password is incorrect
            console.error(error)
            //console.error(error)
        );
    }

    render() {

        return (
            <Box className='login-container' display="grid" alignItems="center" height="100vh">
                <img src={this.state.backgroundImage} alt="Mouton dans la prairie"/>
                <Grid container direction='row' spacing={0} minHeight="75%" maxWidth="lg" margin="0 auto" align='center' justifyContent="center">
                    <Grid item container direction='column' display="flex" alignItems="center" justifyContent="center" xs={12} sm={12} md={6} sx={{ background: 'white', padding: { sm: '0 10%' } }}>
                        <AccountCircleIcon fontSize='large' sx={{ fontSize: 50 }} />
                        <Typography variant="h4" color="primary">Créer un compte</Typography>
                        <Box component="form" onSubmit={this.handleSubmit} sx={{ mt: 1 }}>
                            <Grid container direction='row' spacing={2}>
                                <Grid item xs={12} md={6}>
                                    <TextField
                                        margin="normal"
                                        required
                                        id="first_name"
                                        label="Prénom"
                                        name="first_name"
                                        autoComplete="given-name"
                                        autoFocus
                                        onChange={(e) => this.setState({ first_name: e.target.value })}
                                    />
                                </Grid>
                                <Grid item xs={12} md={6}>
                                    <TextField
                                        margin="normal"
                                        required
                                        name="last_name"
                                        label="Nom de famille"
                                        type="text"
                                        id="last_name"
                                        autoComplete="family-name"
                                        onChange={(e) => this.setState({ last_name: e.target.value })}
                                    />
                                </Grid>
                            </Grid>
                            <TextField
                                margin="normal"
                                required
                                id="email"
                                label="Adresse email"
                                name="email"
                                autoComplete="email"
                                autoFocus
                                fullWidth
                                onChange={(e) => this.setState({ email: e.target.value })}
                            />
                            <TextField
                                margin="normal"
                                required
                                id="password"
                                label="Mot de passe"
                                name="password"
                                autoComplete="new-password"
                                type="password"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                                autoFocus
                                fullWidth
                                onChange={(e) => this.setState({ password: e.target.value })}
                            />
                            <TextField
                                margin="normal"
                                required
                                id="confirm_password"
                                label="Confirmer le mot de passe"
                                name="email"
                                autoComplete="new-password"
                                type="password"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                                autoFocus
                                fullWidth
                                onChange={(e) => this.setState({ confirm_password: e.target.value })}
                            />
                            <FormControlLabel onChange={() => this.setState({ role: !this.state.role })} control={<Switch defaultChecked />} label="Agriculteur" />
                            <Button
                                type="submit"
                                fullWidth
                                variant="contained"
                                sx={{ mt: 3, mb: 2 }}
                            >
                                Se connecter
                            </Button>
                            <Grid container>
                                <Grid item md>
                                    <Link href="#" variant="body2">
                                        {"Vous avez déjà un compte ? Connectez-vous"}
                                    </Link>
                                </Grid>
                            </Grid>
                        </Box>
                    </Grid>
                    <Grid item container direction='column' display="flex" justifyContent="center" xs={12} sm={12} md={4} sx={{ background: "#407A64" }}>
                        <Typography color='white' variant="h3" align='center'>
                            Bienvenue !
                        </Typography>
                        <Typography color='white'>
                            Crée un compte et rejoins l'aventure !
                        </Typography>
                    </Grid>
                </Grid>
            </Box>
        );

    }
}