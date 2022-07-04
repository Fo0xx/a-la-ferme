import React from 'react';

/* Creating a context object that will be used to pass data down the component tree without having to
pass props down manually at every level. */
const SanctumContext = React.createContext({
    user: null,
    token: '',
    authenticated: false,
    signIn: (email, password, remember) => Promise, //signIn function returning a promise, want a boolean
    signOut: () => Promise,
    setUser: (user = {}, token = '', authenticated) => {},
    checkAuthentication: () => Promise,
});

export default SanctumContext;