import {useSelector} from "react-redux";
import {clear} from "../../../reducers/snackbar/error-snackbar";
import Snackbar from "./Snackbar";
import MuiAlert from "@mui/material/Alert";
import React from "react";

const ErrorSnackbar = () => {
    const errorsObj = useSelector(state => state.errSnackbar)

    const isOpen = Array.isArray(errorsObj.errors)
    const autoHideMs = errorsObj.duration || 5000
    const elevation = 6;

    return (
        <Snackbar
            isOpen={isOpen}
            autoHideMs={autoHideMs}
            onClose={clear}
        >
            <MuiAlert
                elevation={elevation}
                variant="filled"
                severity="error"
            >
                <div>
                    <div>Ошибка</div>

                    <ul>
                        {errorsObj.errors && errorsObj.errors.map((error, i) => (
                            <li key={i}>{error}</li>
                        ))}
                    </ul>
                </div>
            </MuiAlert>
        </Snackbar>
    );
}

export default ErrorSnackbar
