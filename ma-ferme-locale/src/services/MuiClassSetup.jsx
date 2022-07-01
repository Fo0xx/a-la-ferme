import { unstable_ClassNameGenerator as ClassNameGenerator } from '@mui/material/className';

/**
 * Replacing the name of the default class generator with a custom one
 * 
 * @see https://mui.com/material-ui/experimental-api/classname-generator/ for more info
 */
ClassNameGenerator.configure((componentName) =>
    'MFL-' + componentName.replace('Mui', '')
);