import React from "react";
import {Navigate, Outlet, useLocation} from "react-router-dom";
import user from "../auth/user";

export const ProtectedRoute = () => {

    const location = useLocation()

    if (user.isLoggedIn()) {
        return <Outlet/>
    }

    return (
        <Navigate
            to="/"
            state={{from: `${location.pathname}${location.search}`}}
            replace
        />
    )
}
