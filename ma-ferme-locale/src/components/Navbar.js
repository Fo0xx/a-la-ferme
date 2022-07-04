import React from 'react';

import { AppBar, Box, Toolbar, Typography, IconButton, Menu, Container, Avatar, Button, Tooltip, MenuItem, Link } from '@mui/material';

import '../styles/global.scss';
import { Breakpoint } from 'react-socks';
import Mobile from './Navbar/Mobile';
import { Navigate } from 'react-router-dom';
import { useSanctum } from '../services/Sanctum';

const settings = ['S\'inscrire', 'Se connecter'];

const Navbar = () => {

    const [anchorElUser, setAnchorElUser] = React.useState(null);
    const [anchorElNav, setAnchorElNav] = React.useState(null);

    const { authenticated, signOut } = useSanctum();

    const handleOpenNavMenu = (event) => {
        setAnchorElNav(event.currentTarget);
    };
    const handleOpenUserMenu = (event) => {
        setAnchorElUser(event.currentTarget);
    };

    const handleCloseNavMenu = () => {
        setAnchorElNav(null);
    };

    const handleCloseUserMenu = () => {
        setAnchorElUser(null);
    };

    const logout = (e) => {
        e.preventDefault();

        signOut();

        Navigate('/', { replace: true });

        handleCloseUserMenu();
    }

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
                                <Button href='/' onClick={handleCloseNavMenu} sx={{ my: 2, color: 'inherit', display: 'block' }}>
                                    Accueil
                                </Button>
                                <Button href='/farms' onClick={handleCloseNavMenu} sx={{ my: 2, color: 'inherit', display: 'block' }}>
                                    Les fermes
                                </Button>
                                <Button href='/le-projet' onClick={handleCloseNavMenu} sx={{ my: 2, color: 'inherit', display: 'block' }}>
                                    Le projet
                                </Button>
                            </Box>

                            <Box sx={{ flexGrow: 0 }}>
                                <Tooltip title="Open settings">
                                    <IconButton onClick={handleOpenUserMenu} sx={{ p: 0 }}>
                                        {
                                            authenticated ? <Avatar alt="user" src="/static/images/avatar/2.jpg" /> : <Avatar alt="lambda" src="/static/images/avatar/2.jpg" />
                                        }
                                    </IconButton>
                                </Tooltip>
                                <Menu
                                    id="menu-appbar"
                                    anchorEl={anchorElUser}
                                    anchorOrigin={{
                                        vertical: 'bottom',
                                        horizontal: 'center',
                                    }}
                                    keepMounted
                                    transformOrigin={{
                                        vertical: 'top',
                                        horizontal: 'right'
                                    }}
                                    open={Boolean(anchorElUser)}
                                    onClose={handleCloseUserMenu}
                                >
                                    {authenticated ?
                                        <div>
                                            <Link href="/dashboard" underline="none" color="inherit">
                                                <MenuItem
                                                    onClick={handleCloseUserMenu}>Mon profil</MenuItem>
                                            </Link>
                                            <MenuItem onClick={(e) => logout(e)}>Logout</MenuItem>
                                        </div>
                                        :
                                        <>
                                            <Link href="/login" underline="none" color="inherit">
                                                <MenuItem
                                                    onClick={handleCloseUserMenu}>Se connecter</MenuItem>
                                            </Link>
                                            <Link href="/register" underline="none" color="inherit">
                                                <MenuItem onClick={handleCloseUserMenu}>S'inscrire</MenuItem>
                                            </Link>
                                        </>
                                    }

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

export default Navbar;