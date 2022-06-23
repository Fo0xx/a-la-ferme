import { createTheme } from '@mui/material/styles';

const farmTheme = createTheme({
    palette: {
        type: 'light',
        primary: {
            main: '#012840',
            contrastText: '#fff'
        },
        secondary: {
            main: '#315955',
        },
        thirdary: {
            main: '#788C64',
        },
        fourthary: {
            main: '#D1D99A',
        },
        fifthary: {
            main: '#BFB063',
            contrastText: '#ffffff'
        },
        black: {
            main: '#000000',
            contrastText: '#ffffff',
        },
        white: {
            main: '#ffffff'
        }
    },
    typography: {
        h1: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1.5rem, 8vw - 2rem, 5rem)',
            fontWeight: 'bold',
        },
        h2: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1.6rem, 2vw + 0.5rem, 2rem)',
            fontWeight: 400
        },
        h3: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1.4rem, 2vw + 0.5rem, 1.7rem)',
        },
        h4: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1.2rem, 2vw + 0.5rem, 1.4rem)',
            fontWeight: 500
        },
        h5: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1rem, 2vw + 0.5rem, 1.2rem)',
        },
        body1: {
            fontFamily: '"Karla", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(0.8rem, 2vw + 0.5rem, 1rem)',
            fontWeight: 400
        },
        body2: {
            fontFamily: '"Karla", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(0.7rem, 2vw + 0.5rem, 0.9rem)',
            fontWeight: 300
        },
        404: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(10rem, 8vw - 2rem, 10rem)',
        }
    },
});

export default farmTheme;