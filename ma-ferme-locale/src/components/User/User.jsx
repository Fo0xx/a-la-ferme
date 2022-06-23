import { ApiClient } from "../../services/ApiClient"

class User {

    constructor() {
        this.init()
    }

    init() {
        this.token = localStorage.getItem('userToken')
        this.loggedIn = false;
    }

    csrf = () => {
        return ApiClient.get(`sanctum/csrf-cookie`);
    };

    signIn = (email, password, remember) => {
        return new Promise(async (resolve, reject) => {
            try {

                await this.csrf();

                const { data: signInData } = await ApiClient.post(`api/login`, {
                    email,
                    password,
                });

                const user = await this.revalidate(signInData.data.token);

                localStorage.setItem('userToken', signInData.data.token)

                return resolve(user);
            } catch (error) {
                return reject(error);
            }
        });
    };

    revalidate = (token) => {

        return new Promise(async (resolve, reject) => {

            try {
                const { data: userData } = await ApiClient.get(`api/user`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    });
                resolve(userData.data);
            } catch (error) {
                return reject(error);
            }
        });
    }

    signOut = () => {
        return new Promise(async (resolve, reject) => {

            const token = localStorage.getItem('userToken');

            try {
                // post to the sign out route with the token as a bearer token
                await ApiClient.post(`api/logout`, [],
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    });
                this.clearStorage();
                resolve();
            } catch (error) {
                return reject(error);
            }
        });
    };

    checkAuthentication() {
        return new Promise(async (resolve, reject) => {
            try {
                if (this.loggedIn === false || this.loggedIn === null) {

                    try {
                        await this.revalidate();
                        return resolve(true);
                    } catch (error) {
                        if (error.response && error.response.status === 401) {
                            // If there's a 401 error the user is not signed in.
                            this.clearStorage();
                            return resolve(false);
                        } else {
                            // If there's any other error, something has gone wrong.
                            return reject(error);
                        }
                    }
                } else {
                    return resolve(this.loggedIn);
                }
            } catch (error) {
                return reject(error);
            }
        });
    }

    clearStorage() {
        localStorage.removeItem('userToken')
    }

    /**
     *
     * @return {boolean}
     */
    isLoggedIn() {
        return localStorage.getItem('userToken') ? true : false;
    }
}

export default new User()