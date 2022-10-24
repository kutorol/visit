import React, {StrictMode} from "react";
import {Provider} from 'react-redux'
import store from './store'
import { createRoot } from 'react-dom/client';
import App from "./Components/App";
import ErrorSnackbar from "./Components/General/Snackbar/ErrorSnackbar";
import SuccessSnackbar from "./Components/General/Snackbar/OkSnackbar";
import WarningSnackbar from "./Components/General/Snackbar/WarningSnackbar";
import InfoSnackbar from "./Components/General/Snackbar/InfoSnackbar";

if (document.getElementById('app')) {
    createRoot(document.getElementById('app')).render(
        <StrictMode>
            <Provider store={store}>
                <>
                    <ErrorSnackbar/>
                    <InfoSnackbar/>
                    <WarningSnackbar/>
                    <SuccessSnackbar/>

                    <App/>
                </>
            </Provider>
        </StrictMode>
    );
}
