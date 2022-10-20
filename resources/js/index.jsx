import React from "react";
import ReactDOM from "react-dom";
import SignIn from "./components/auth/SignIn";
import Dashboard from "./components/Dashboard/Dashboard";
import {ProtectedRoute} from "./components/ProtectedRoute/ProtectedRoute";
import {BrowserRouter as Router, Routes, Route} from "react-router-dom";

function App() {
    return (
        <Router>
            <Routes>
                <Route path={'/'} element={<SignIn/>}/>

                <Route exact path='/app/dashboard' element={<ProtectedRoute/>}>
                    <Route exact path='/app/dashboard' element={<Dashboard/>}/>
                </Route>

                <Route
                    path="*"
                    element={
                        <div>
                            <h2>404 Page not found etc</h2>
                        </div>
                    }
                />
            </Routes>
        </Router>
    );
}

if (document.getElementById('app')) {
    ReactDOM.render(<App/>, document.getElementById('app'));
}
