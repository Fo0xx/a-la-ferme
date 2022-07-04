import { CircularProgress } from '@mui/material';
import { Box } from '@mui/system';
import React from 'react';
import { useEffect } from 'react';
import { Navigate, Outlet } from 'react-router-dom';

import { useSanctum } from './Sanctum';

/**
 * If the user is authenticated, render the component, otherwise redirect to the login page
 * 
 * @param {Object} props The props passed to the component.
 * 
 * @returns A function that returns a component.
 */
const ProtectedRoute = (props) => {

    const { checkAuthentication } = useSanctum();

    const [authentication, setAuthentication] = React.useState(null);

    useEffect(() => {
        checkAuthentication()
            .then(authentication => {
                setAuthentication(authentication);
            })
            .catch(error => {
                console.log(error);
            })
    }, []);

    if (!authentication) return (
        //Grid with centered content
        <Box display="grid" justifyContent="center" alignItems="center" height="100vh">
            <CircularProgress color="secondary" />
        </Box>
    );

    return authentication ? <Outlet {...props} /> : <Navigate to="/login" state={{ from: props.location }} />;

};

export default ProtectedRoute;