import { ApiClient } from "../../services/ApiClient"

class User {

    /**
     * The constructor function is a special function that is called when a new object is created.
     */
    constructor() {
        this.token = localStorage.getItem('userToken')
    }

    /**
     * Return the csrf token from Sanctum
     * 
     * @returns {Promise<AxiosResponse<any, any>>}
     */
    csrf = () => {
        return ApiClient.get(`sanctum/csrf-cookie`);
    };

    /**
     * Sign in the user to the API and store the token in local storage
     * 
     * @param {string} email The email of the user
     * @param {string} password The password of the user
     * 
     * @returns {Promise<AxiosResponse<any, any>>}
     */
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

    /**
     * Revalidate the token with the API and return the user
     * 
     * @param {string} token 
     * @returns {Promise<AxiosResponse<any, any>>} The user object if the token is valid
     */
    revalidate = (token) => {

        return new Promise(async (resolve, reject) => {

            try {
                const { data: userData } = await ApiClient.get(`api/user`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        }
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
        const token = localStorage.getItem('userToken');

        if (token) {
            try {
                this.revalidate(token).then(() => {
                    return true;
                })
            } catch (error) {
                this.clearStorage();
                return false;
            }
        }
        return false;
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