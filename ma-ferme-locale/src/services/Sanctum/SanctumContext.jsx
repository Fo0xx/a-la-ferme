import React from 'react';

const SanctumContext = React.createContext({
    user: null,
    token: '',
    isAuthenticated: null | false,
    signIn: (email, password) => Object, //signIn function returning a promise, want a boolean
    signOut: () => Object,
    setUser: (user = {}, token = '', isAuthenticated) => Object,
    checkAuthentication: () => Object,
});

export default SanctumContext;