import React, { useEffect } from 'react';
import { Navigate, Outlet } from 'react-router-dom';

import User from '../components/User/User';

const ProtectedRoute = (props) => {

    useEffect(() => {
        User.checkAuthentication();
    });

    return User.isLoggedIn() ? <Outlet /> : <Navigate to="/login" state={ {from: props.location}} />;
};

export default ProtectedRoute;