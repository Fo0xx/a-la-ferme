import React, { useEffect } from "react";
import { ApiClient } from "../ApiClient";
import SanctumContext from "./SanctumContext";

const Sanctum = (
    {
        children,
        config = {
            csrfCookieRoute: '',
            signInRoute: '',
            signOutRoute: '',
            userRoute: '',
        } 
    }
) => {

    const [sanctumState, setSanctumState] = React.useState({
        user: null,
        token: localStorage.getItem('token'),
        isAuthenticated: localStorage.getItem('token') ? true : false,
    });

    const user = sanctumState.user;
    const token = sanctumState.token;
    const isAuthenticated = sanctumState.isAuthenticated;

    useEffect(() => {
        checkAuthentication();
    });

    const csrf = () => {
        return ApiClient.get(`${config.csrfCookieRoute}`);
    };

    //create a singin function returning a promise
    const signIn = (email, password, remember) => {

        return new Promise(async (resolve, reject) => {
            try {

                await csrf();

                const { data: signInData } = await ApiClient.post(`${config.signInRoute}`, {
                    headers: {
                        Accept: 'application/json'
                    },
                    email: email,
                    password: password,
                })

                const user = await revalidate(signInData.data.token);

                return resolve({ signedIn: true, user, token: signInData.data.token });
            } catch (error) {
                return reject(error);
            }
        });
    };

    const signOut = () => {

        return new Promise(async (resolve, reject) => {
            try {
                // post to the sign out route with the token as a bearer token
                await ApiClient.post(`${config.signOutRoute}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
                // Only sign out after the server has successfully responded.
                setSanctumState({ user: null, token: '', isAuthenticated: false });
                resolve();
            } catch (error) {
                return reject(error);
            }
        });
    };

    const setUser = (user, token, isAuthenticated = true) => {
        setSanctumState({ user, token, isAuthenticated });
    };

    const revalidate = (token) => {

        return new Promise(async (resolve, reject) => {

            try {
                const { data: userData } = await ApiClient.get(`${config.userRoute}`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    });
                setUser(userData.data, token, true);
                resolve(userData.data);
            } catch (error) {
                return reject(error);
            }
        });
    }

    //recreate the checkAuthentication function to return an object
    const checkAuthentication = () => {
        try {
            if(isAuthenticated === null) {
                try {
                    revalidate();
                    return { signedIn: true };
                } catch (error) {
                    if (error.response && error.response.status === 401) {
                        // If there's a 401 error the user is not signed in.
                        setSanctumState({ user: null, token: '', authenticated: false });
                        return { signedIn: false };
                    } else {
                        // If there's any other error, something has gone wrong.
                        return { error };
                    }
                }
            } else {
                return { signedIn: isAuthenticated };
            }
        } catch (error) {
            return { error };
        }
    }

    return (
        <SanctumContext.Provider
            children={children}
            value={{
                user,
                token,
                isAuthenticated,
                signIn,
                signOut,
                setUser,
                checkAuthentication,
            }}
        />
    );

}

export default Sanctum;