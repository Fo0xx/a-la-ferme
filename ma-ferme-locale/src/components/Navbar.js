import React from 'react';

import { AppBar, Box, Toolbar, Typography, IconButton, Menu, Container, Avatar, Button, Tooltip, MenuItem, Link } from '@mui/material';

import '../styles/global.scss';
import user from '../components/User/User';
import { Breakpoint } from 'react-socks';
import Mobile from './Navbar/Mobile';
import { ApiClient } from '../services/ApiClient';

const settings = ['S\'inscrire', 'Se connecter'];

class Navbar extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            anchorElUser: null,
            anchorElNav: null
        }

    }

    handleOpenNavMenu = (event) => {
        this.setState({ anchorElNav: event.currentTarget });
    };
    handleOpenUserMenu = (event) => {
        this.setState({ anchorElUser: event.currentTarget });
    };

    handleCloseNavMenu = () => {
        this.setState({ anchorElNav: null });
    };

    handleCloseUserMenu = () => {
        this.setState({ anchorElUser: null });
    };

    logout = (e) => {
        e.preventDefault();

        ApiClient.post('/logout', {})
            .then(() => {
                console.log('logout');
            }).catch((err) => {
                console.log(err);
            }).finally(() => {
                user.logout();
                this.props.history.push('/login');
            });

        this.handleCloseUserMenu();
    }

    render() {

        return (
            <>
                <Breakpoint sm up style={{ position: "absolute" }}>
                    <AppBar position="fixed" sx={{ color: 'white', boxShadow: 'none', background: 'linear-gradient(180deg, rgba(0, 0, 0, 0.27) 0%, rgba(255, 255, 255, 0) 100%)' }} >
                        <Container>
                            <Toolbar disableGutters>
                                <Link href="/" underline="none" color="inherit">
                                    <Typography
                                        variant="h6"
                                        noWrap
                                        component="div"
                                        sx={{ mr: 2, display: 'flex' }}
                                    >
                                        MA FERME LOCALE
                                    </Typography>
                                </Link>

                                <Box sx={{ flexGrow: 1, display: 'flex', justifyContent: 'flex-end', mr: 20 }}>
                                    <Button href='/' onClick={this.handleCloseNavMenu} sx={{ my: 2, color: 'inherit', display: 'block' }}>
                                        Accueil
                                    </Button>
                                    <Button href='/farms' onClick={this.handleCloseNavMenu} sx={{ my: 2, color: 'inherit', display: 'block' }}>
                                        Les fermes
                                    </Button>
                                    <Button href='/le-projet' onClick={this.handleCloseNavMenu} sx={{ my: 2, color: 'inherit', display: 'block' }}>
                                        Le projet
                                    </Button>
                                </Box>

                                <Box sx={{ flexGrow: 0 }}>
                                    <Tooltip title="Open settings">
                                        <IconButton onClick={this.handleOpenUserMenu} sx={{ p: 0 }}>
                                            {
                                                user.isLoggedIn() ? <Avatar alt="IAM" src="/static/images/avatar/2.jpg" /> : <Avatar alt="W" src="/static/images/avatar/2.jpg" />
                                            }
                                        </IconButton>
                                    </Tooltip>
                                    <Menu
                                        id="menu-appbar"
                                        anchorEl={this.state.anchorElUser}
                                        anchorOrigin={{
                                            vertical: 'bottom',
                                            horizontal: 'center',
                                        }}
                                        keepMounted
                                        transformOrigin={{
                                            vertical: 'top',
                                            horizontal: 'right'
                                        }}
                                        open={Boolean(this.state.anchorElUser)}
                                        onClose={this.handleCloseUserMenu}
                                    >
                                        {user.isLoggedIn() ?
                                            <div>
                                                <Link href="/dashboard" underline="none" color="inherit">
                                                <MenuItem
                                                    onClick={this.handleCloseUserMenu}>Profile</MenuItem>
                                                </Link>
                                                <MenuItem onClick={this.handleCloseUserMenu}>User Management</MenuItem>
                                                <MenuItem onClick={this.logout}>Logout</MenuItem>
                                            </div>
                                            :
                                            settings.map((setting) => (
                                                <MenuItem key={setting} onClick={this.handleCloseUserMenu}>
                                                    <Typography textAlign="center">{setting}</Typography>
                                                </MenuItem>
                                            ))}

                                    </Menu>
                                </Box>
                            </Toolbar>

                        </Container>
                    </AppBar>
                </Breakpoint>
                <Breakpoint xs only>
                    <Mobile />
                </Breakpoint>
            </>
        );
    }
}

export default Navbar;