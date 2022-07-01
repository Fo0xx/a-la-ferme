import React, { useEffect, useRef, useState } from "react";
import mapboxgl from '!mapbox-gl'; // eslint-disable-line import/no-webpack-loader-syntax
import 'mapbox-gl/dist/mapbox-gl.css';

/**
 * 
 * 
 * @param {*} props 
 * @returns 
 */
const FarmMap = props => {

    const mapContainer = useRef(null);
    const map = useRef(null);
    const [lng] = useState(2.3522219);
    const [lat] = useState(48.856614);
    const [zoom] = useState(9);

    /**
     * Getting the mapbox token from the environment variables
     * 
     * @external mapboxgl
     * 
     * @throws {Error} If the token is not found
     */
    if (!process.env.REACT_APP_MAPBOX_API_KEY) {
        throw new Error('Mapbox token not found');
    } else {
        mapboxgl.accessToken = process.env.REACT_APP_MAPBOX_API_KEY;
    }

    /**
     * On component mount, create the map and add the marker to the map
     * 
     * @param {*} props
     * 
     * @returns {void}
     */
    useEffect(() => {
        if (map.current) return; // initialize map only once

        map.current = new mapboxgl.Map({
            container: mapContainer.current,
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [lng, lat],
            zoom: zoom
        });

        map.current.on('load', () => {
            map.current.resize();

            map.current.flyTo({
                center: [props.longitude, props.latitude],
                zoom: props.zoom
            });

            new mapboxgl.Marker({
                draggable: true,
                color: '#ff0000'
            }).setLngLat([props.longitude, props.latitude]).addTo(map.current);

            //add a popup to the farm location with the farm name
            new mapboxgl.Popup({ offset: 25, closeButton: false })
                .setLngLat([props.longitude, props.latitude])
                .setHTML(props.farmName)
                .addTo(map.current);
        });


        map.current.addControl(new mapboxgl.FullscreenControl());

        /**
         * On component unmount, remove the map and its markers
         */
        return function cleanup() {
            // clean up to avoid memory leaks
            map.current.remove();
            map.current = null;
        }
    });

    return (
        <div className="map-container" ref={mapContainer} style={{ width: "100%", height: "100%" }} />
    );
}

export default FarmMap;