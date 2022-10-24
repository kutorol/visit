import React from "react";
import {Provider} from 'react-redux'
import store from './store'
import { createRoot } from 'react-dom/client';
import App from "./components/app";

if (document.getElementById('app')) {
    createRoot(document.getElementById('app')).render(
        <React.StrictMode>
            <Provider store={store}>
                <App/>
            </Provider>
        </React.StrictMode>
    );
}
