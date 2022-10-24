import {BrowserRouter as Router, Route, Routes} from "react-router-dom";
import SignIn from "./auth/SignIn";
import {ProtectedRoute} from "./ProtectedRoute/ProtectedRoute";
import Dashboard from "./Dashboard/Dashboard";
import React from "react";

export default function App() {
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
