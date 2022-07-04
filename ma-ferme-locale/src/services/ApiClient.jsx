import axios from 'axios';

/* Creating an axios instance with the baseURL, timeout, headers, and withCredentials. */
export const ApiClient = axios.create({
    baseURL: `${process.env.REACT_APP_API_URL}`,
    timeout: 3000,
    headers: {
        'Accept': 'application/json'
    },
    withCredentials: true
});