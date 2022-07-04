/** @module Pexels */

const API_KEY = process.env.REACT_APP_PEXELS_API_KEY;

/**
 * Get the photo object from the Pexels API
 * 
 * @example getPhotos(1) - returns the photo object with the id of 1
 * 
 * @param {int} id - The id of the Pexels photo
 * 
 * @returns {JSON} The JSON object of the photo
 */
async function getPhotos(id) {
    // fetch a photos with the given id from the API using fetch
    const response = await fetch(`https://api.pexels.com/v1/photos/${id}`, {
        headers: {
            Authorization: `${API_KEY}`
        }
    });
    // return the photo object
    return await response.json();
}

/**
 * Get the video object from the Pexels API
 * 
 * @example getVideos(1) - returns the video object with the id of 1
 * 
 * @param {int} id - The id of the Pexels video
 * 
 * @returns {JSON} The JSON object of the video
 */
async function getVideos(id) {
    // fetch a videos with the given id from the API using fetch
    const response = await fetch(`https://api.pexels.com/videos/videos/${id}`, {
        headers: {
            Authorization: `${API_KEY}`
        }
    });
    // return the photo object
    return await response.json();
}

/* Exporting the functions `getPhotos` and `getVideos` so that they can be used in other files. */
export { getPhotos, getVideos };