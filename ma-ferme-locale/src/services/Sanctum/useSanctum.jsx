import React from 'react';

import SanctumContext from './SanctumContext';

/**
 * UseSanctum() is a React hook that returns the SanctumContext object.
 * It is used to pass data to the Sanctum component, but also retrieves the data from the Sanctum component.
 * 
 * @returns The context object.
 */
const useSanctum = () => {
    const context = React.useContext(SanctumContext);
    if (!context) {
        throw new Error('useSanctum doit seulement être utilisé dans un contexte <Sanctum />');
    }
    return context;
}

export default useSanctum;