import React from 'react';
import ReactDOM from 'react-dom';
import './services/MuiClassSetup';
import App from './App';
import * as serviceWorkerRegistration from './serviceWorkerRegistration';
import reportWebVitals from './reportWebVitals';

import { BreakpointProvider } from 'react-socks';
import { ThemeProvider } from '@emotion/react';
import farmTheme from './FarmTheme';
import { Sanctum } from "./services/Sanctum";

const sanctumConfig = {
  csrfCookieRoute: "sanctum/csrf-cookie",
  signInRoute: "/api/login",
  signOutRoute: "/api/logout",
  userObjectRoute: "/api/user",
};

ReactDOM.render(
  <React.StrictMode>
    <Sanctum config={sanctumConfig} checkOnInit={true}>
      <BreakpointProvider>
        <ThemeProvider theme={farmTheme}>
          <App />
        </ThemeProvider>
      </BreakpointProvider>
    </Sanctum>
  </React.StrictMode>,
  document.getElementById('root')
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://cra.link/PWA
serviceWorkerRegistration.register();

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
