import React from 'react';

const SanctumContext = React.createContext({
    user: null,
    token: '',
    isAuthenticated: null | false,
    signIn: (email, password) => Promise(), //signIn function returning a promise, want a boolean
    signOut: () => Promise(),
    setUser: (user = {}, token = '', isAuthenticated) => Promise(),
    checkAuthentication: () => Promise,
});

export default SanctumContext;