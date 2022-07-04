import React, { useEffect } from "react";
import { ApiClient } from "../ApiClient";
import SanctumContext from "./SanctumContext";

const Sanctum = (
    {
        children,
        checkOnInit = true,
        config = {
            csrfCookieRoute: '',
            signInRoute: '',
            signOutRoute: '',
            userObjectRoute: '',
        }
    }
) => {

    /* Setting the initial state of the Sanctum component. */
    const [sanctumState, setSanctumState] = React.useState({
        user: null,
        token: '',
        authenticated: false,
    });

    const user = sanctumState.user;
    const token = sanctumState.token;
    const authenticated = sanctumState.authenticated;

    useEffect(() => {
        if (checkOnInit) {
            checkAuthentication();
        }
    }, [checkOnInit]);

    /**
     * This function returns a promise that resolves to the value of the csrf token.
     * 
     * @returns The promise that resolves to the value of the csrf token.
     */
    const csrf = () => {
        const { csrfCookieRoute } = config;
        return ApiClient.get(`${csrfCookieRoute}`);
    };

    /**
     * The function returns a promise that resolves to an object with a signedIn property, a user
     * property, and a token property.
     * 
     * @param {string} email - The user's email.
     * @param {string} password - The password of the user.
     * @param {string} remember - Whether to remember the user or not
     * 
     * @returns a promise.
     */
    const signIn = (email, password, remember = false) => {

        const { signInRoute } = config;

        return new Promise(async (resolve, reject) => {
            try {

                await csrf();

                const { data: signInData } = await ApiClient.post(`${signInRoute}`, {
                    headers: {
                        Accept: 'application/json'
                    },
                    email: email,
                    password: password,
                });

                const user = await revalidate();

                return resolve({ signedIn: true, user, token: signInData.data.token });
            } catch (error) {
                return reject(error);
            }
        });
    };

    /**
     * SignOut() is a function that returns a promise that resolves to a post request to the sign out
     * route with the token as a bearer token, and rejects if there is an error.
     * 
     * @returns {Promise<void>} A promise that resolves to a post request to the sign out route with the token as a bearer token, and rejects if there is an error.
     */
    const signOut = () => {

        const { signOutRoute } = config;

        return new Promise(async (resolve, reject) => {
            try {
                // post to the sign out route with the token as a bearer token
                await ApiClient.post(`${signOutRoute}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
                // Only sign out after the server has successfully responded.
                setSanctumState({ user: null, token: null, authenticated: false });
                resolve();
            } catch (error) {
                return reject(error);
            }
        });
    };

    /**
     * The setUser function takes three arguments, user, token, and authenticated, and sets the state
     * of the Sanctum component to the values of those arguments.
     * 
     * @param {Object} user The user object to set the state to.
     * @param {String} token The token to set the state to.
     * @param {Boolean} authenticated The authenticated value to set the state to.
     * 
     * @returns {void}
     */
    const setUser = (user, token, authenticated = true) => {
        setSanctumState({ user, token, authenticated });
    };

    /**
     * Revalidate is a function that returns a promise that resolves to the user data if the token is
     * valid, otherwise it rejects the error.
     * 
     * @param {String} token The token to validate.
     * 
     * @returns The userData.data object.
     */
    const revalidate = () => {
        return new Promise(async (resolve, reject) => {

            const { userObjectRoute } = config;

            try {
                const { data: userData } = await ApiClient.get(`${userObjectRoute}`,
                    {
                        headers: {
                            Authorization: `Bearer ${sanctumState.token}`,
                        },
                    });

                setUser(userData.data, sanctumState.token, true);
                resolve(userData.data);
            } catch (error) {
                if (error.response && error.response.status === 401) {
                    // If there's a 401 error the user is not signed in.
                    setUser(null, null, false);
                    setSanctumState({ user: null, token: null, authenticated: false });
                    return resolve(false);
                } else {
                    // If there's any other error, something has gone wrong.
                    return reject(error);
                }
            }
        });
    }

    /**
     * If the user is authenticated, return true, else return false.
     * 
     * @returns an object with a property of signedIn.
     */
    const checkAuthentication = () => {
        return new Promise(async (resolve, reject) => {
            if (authenticated === null || authenticated === false) {
                // The status is null if we haven't checked it, so we have to make a request.
                try {
                    await revalidate();
                    return resolve(true);
                } catch (error) {
                    if (error.response && error.response.status === 401) {
                        // If there's a 401 error the user is not signed in.

                        setSanctumState({ user: null, authenticated: false });
                        return resolve(false);
                    } else {
                        // If there's any other error, something has gone wrong.
                        return reject(error);
                    }
                }
            } else {
                // If it has been checked with the server before, we can just return the state.
                return resolve(authenticated);
            }
        });
    };

    /* Returning the SanctumContext.Provider component with the children prop set to the children prop
    passed to the Sanctum component, and the value prop set to an object with the user, token,
    authenticated, signIn, signOut, setUser, and checkAuthentication properties. */
    return (
        <SanctumContext.Provider
            children={children}
            value={{
                user,
                token,
                authenticated,
                signIn,
                signOut,
                setUser,
                checkAuthentication,
            }}
        />
    );

}

export default Sanctum;