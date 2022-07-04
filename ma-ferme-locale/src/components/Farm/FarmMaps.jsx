import React, { useEffect, useRef, useState } from "react";
import mapboxgl from '!mapbox-gl'; // eslint-disable-line import/no-webpack-loader-syntax
import 'mapbox-gl/dist/mapbox-gl.css';
import { Divider, Grid, Typography } from "@mui/material";

const FarmListMap = ({ geoJSON, lng, lat }) => {

    const mapContainer = useRef(null);
    const map = useRef(null);
    const [zoom, setZoom] = useState(13);

    if (!process.env.REACT_APP_MAPBOX_API_KEY) {
        throw new Error('Mapbox token not found');
    } else {
        mapboxgl.accessToken = "pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4M29iazA2Z2gycXA4N2pmbDZmangifQ.-g_vE53SD2WrJ6tFX7QHmA";
    }

    geoJSON.features.forEach(function (farm, i) {
        farm.properties.id = i;
    });

    useEffect(() => {
        if (map.current) return; // initialize map only once

        map.current = new mapboxgl.Map({
            container: mapContainer.current,
            style: 'mapbox://styles/valodes/cl52x54yg000615pjctwdji7s',
            center: [lng, lat],
            zoom: zoom,
            scrollZoom: false
        });

        map.current.on('load', () => {

            map.current.addSource('geojson', {
                type: 'geojson',
                data: geoJSON
                });


            buildLocationList(geoJSON);
            addMarkers();
        });

        return function cleanup() {
            map.current.remove();
            map.current = null;
        }
    }, [geoJSON]);

    /**
    * Add a marker to the map for every store listing.
    **/
    function addMarkers() {
        /* For each feature in the GeoJSON object above: */
        for (const marker of geoJSON.features) {
            /* Create a div element for the marker. */
            const el = document.createElement('div');
            /* Assign a unique `id` to the marker. */
            el.id = `marker-${marker.properties.id}`;
            /* Assign the `marker` class to each marker for styling. */
            el.className = 'marker';
            el.style.backgroundImage = `url('./img/farm_marker.png')`;

            /**
            * Create a marker using the div element
            * defined above and add it to the map.
            **/
            new mapboxgl.Marker(el, { offset: [0, -23] })
                .setLngLat(marker.geometry.coordinates)
                .addTo(map.current);

            /**
            * Listen to the element and when it is clicked, do three things:
            * 1. Fly to the point
            * 2. Close all other popups and display popup for clicked store
            * 3. Highlight listing in sidebar (and remove highlight for all other listings)
            **/
            el.addEventListener('click', (e) => {
                /* Fly to the point */
                flyToFarm(marker);
                /* Close all other popups and display popup for clicked store */
                createPopUp(marker);
                /* Highlight listing in sidebar */
                const activeItem = document.getElementsByClassName('active');
                e.stopPropagation();
                if (activeItem[0]) {
                    activeItem[0].classList.remove('active');
                }
                const listing = document.getElementById(
                    `listing-${marker.properties.id}`
                );
                listing.classList.add('active');
            });
        }
    }

    /**
    * Add a listing for each store to the sidebar.
    **/
    function buildLocationList(farms) {
        for (const farm of farms.features) {
            /* Add a new listing section to the sidebar. */
            const listings = document.getElementById('listings');
            const listing = listings.appendChild(document.createElement('div'));
            /* Assign a unique `id` to the listing. */
            listing.id = `listing-${farm.properties.id}`;
            /* Assign the `item` class to each listing for styling. */
            listing.className = 'item';

            /* Add the link to the individual listing created above. */
            const link = listing.appendChild(document.createElement('a'));
            link.href = '#';
            link.className = 'title';
            link.id = `link-${farm.properties.id}`;
            link.textContent = `${farm.properties.address}`;

            /* Add details to the individual listing. */
            const details = listing.appendChild(document.createElement('div'));
            details.textContent = `${farm.properties.city}`;

            /**
            * Listen to the element and when it is clicked, do four things:
            * 1. Update the `currentFeature` to the store associated with the clicked link
            * 2. Fly to the point
            * 3. Close all other popups and display popup for clicked store
            * 4. Highlight listing in sidebar (and remove highlight for all other listings)
            **/
            link.addEventListener('click', function () {
                for (const feature of geoJSON.features) {
                    if (this.id === `link-${feature.properties.id}`) {
                        flyToFarm(feature);
                        createPopUp(feature);
                    }
                }
                const activeItem = document.getElementsByClassName('active');
                if (activeItem[0]) {
                    activeItem[0].classList.remove('active');
                }
                this.parentNode.classList.add('active');
            });
        }
    }

    /**
    * Use Mapbox GL JS's `flyTo` to move the camera smoothly
    * a given center point.
    **/
    function flyToFarm(currentFeature) {
        map.current.flyTo({
            center: currentFeature.geometry.coordinates,
            zoom: 15
        });
    }

    /**
    * Create a Mapbox GL JS `Popup`.
    **/
    function createPopUp(currentFeature) {
        const popUps = document.getElementsByClassName('mapboxgl-popup');
        if (popUps[0]) popUps[0].remove();
        const popup = new mapboxgl.Popup({ closeOnClick: false })
            .setLngLat(currentFeature.geometry.coordinates)
            .setHTML(
                `<h3>Ma Ferme Locale</h3><h4>${currentFeature.properties.address}</h4>`
            )
            .addTo(map.current);
    }

    return (
        <Grid container spacing={3} minHeight="30vh">
            <Grid className="sidebar" item xs={4}>
                <Typography variant="h6">Les fermes de la région</Typography>
                <Divider />
                <div className="listings" id="listings"></div>
            </Grid>
            <Grid className="sidebar" item xs={8}>
                <div className="map-container" ref={mapContainer} style={{ width: "100%", height: "100%" }} />
            </Grid>
        </Grid>
    );

}


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

export { FarmListMap, FarmMap };