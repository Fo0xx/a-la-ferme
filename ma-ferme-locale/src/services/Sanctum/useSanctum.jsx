import React from 'react';

import SanctumContext from './SanctumContext';

const useSanctum = () => {
    const context = React.useContext(SanctumContext);
    if (!context) {
        throw new Error('useSanctum doit seulement être utilisé dans un contexte <Sanctum />');
    }
    return context;
}

export default useSanctum;