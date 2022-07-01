import React from 'react';
import { Navigate, Outlet } from 'react-router-dom';

import User from '../components/User/User';

const ProtectedRoute = (props) => {

    if (User.checkAuthentication()) {
        return <Outlet {...props} />;
    } else {
        return <Navigate to="/login" state={ {from: props.location} } />;
    }
};

export default ProtectedRoute;