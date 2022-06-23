import React, { lazy, Suspense } from 'react';
import { setDefaultBreakpoints, setDefaultWidth } from 'react-socks';
import {
	BrowserRouter as Router,
	Routes,
	Route,
} from "react-router-dom";

import ProtectedRoute from './services/ProtectedRoutes';
import FarmsList from './components/Farm/FarmsList';
import MyAccount from './components/User/MyAccount';
import Navbar from './components/Navbar';
import Forms from './components/User/Accounts/Forms';
import toast, { Toaster } from 'react-hot-toast';
import Footer from './components/Footer';
import Error404Page from './components/Error404';
import ShowFarm from './components/Farm/ShowFarm';

const Home = lazy(() => import('./components/Home'));
const notify = () => toast('Here is your toast.');



// We set the default breakpoints for react-socks according to the Material Design spec
setDefaultBreakpoints([
	{ xs: 0 },
	{ sm: 600 },
	{ md: 900 },
	{ lg: 1200 },
	{ xl: 1536 }
]);

setDefaultWidth(992); //render desktop version of the app first

function App() {
	return (
		<Router>
			<Toaster />
			<Navbar />
			<Suspense fallback={<div onLoad={notify}>Chargement...</div>}>
				<Routes>
					<Route exact path="/" element={<Home />} />
					<Route exact path="/farms" element={<FarmsList />} />
					<Route path="/farms/:farmId" element={<ShowFarm />} />
					<Route path="/dashboard" element={<ProtectedRoute />}>
						<Route path="" element={<MyAccount />} />
					</Route>
					<Route path="/login" element={<Forms login={true} />} />
					<Route path="/register" element={<Forms login={false} />} />
					<Route
						path="*"
						element={
							<Error404Page />
						}
					/>
				</Routes>
			</Suspense>
			<Footer />
		</Router >
	);
}

export default App;
