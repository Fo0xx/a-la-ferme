import { AppBar, IconButton, Toolbar, Grid, Link } from "@mui/material";
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import SearchOutlinedIcon from '@mui/icons-material/SearchOutlined';
import PersonOutlineIcon from '@mui/icons-material/PersonOutline';
import React from "react";
import { LogoutOutlined, QuestionMarkOutlined } from "@mui/icons-material";

import user from "../User/User";

export default function Mobile() {

    /* A React hook that is used to set the state of the component. */
    const [clickHex, setClickHex] = React.useState(false);

    return (
        <AppBar position="fixed" color="white" sx={{ top: 'auto', bottom: 0 }}>
            <Toolbar>
                <Grid container justifyContent='space-between'>
                    <Grid item alignSelf='center' >
                        <Link href="/" underline="none" color="inherit">
                            <IconButton color="inherit" aria-label="open drawer">
                                <HomeOutlinedIcon />
                            </IconButton>
                        </Link>
                    </Grid>
                    <Grid item alignSelf='center'>
                        <Link href="/farms" underline="none" color="inherit">
                            <IconButton color="inherit" aria-label="open drawer">
                                <SearchOutlinedIcon />
                            </IconButton>
                        </Link>
                    </Grid>
                    {/*<Grid item sx={{ filter: 'drop-shadow(0px 5px 4px #ccc)' }}>
                        <div class="hexagon" onClick={() => setClickHex(!clickHex)} className={clickHex ? 'hexagon turning' : 'hexagon'}>
                            <AddIcon id="search-icon" color="white" sx={{ display: 'block', margin: 'auto', transform: 'translateY(80%)' }} />
                        </div>
                    </Grid>*/}
                    <Grid item alignSelf='center'>
                        <Link href="/dashboard" underline="none" color="inherit">
                            <IconButton color="inherit" aria-label="open drawer">
                                <PersonOutlineIcon />
                            </IconButton>
                        </Link>
                    </Grid>
                    <Grid item alignSelf='center'>
                        <Link href="/help" underline="none" color="inherit">
                            <IconButton color="inherit" aria-label="open drawer">
                                <QuestionMarkOutlined />
                            </IconButton>
                        </Link>
                    </Grid>
                    <Grid item alignSelf='center'>
                        <IconButton color="inherit" aria-label="open drawer" onClick={() => user.logout()}>
                            <LogoutOutlined />
                        </IconButton>
                    </Grid>
                </Grid>


            </Toolbar>
        </AppBar>
    );
}