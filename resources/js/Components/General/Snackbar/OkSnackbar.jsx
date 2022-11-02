import {useSelector} from "react-redux";
import Snackbar from './Snackbar';
import {clear} from "../../../reducers/snackbar/ok-snackbar"
import MuiAlert from "@mui/material/Alert";
import React from "react";

const SuccessSnackbar = () => {
    const messageObj = useSelector(state => state.successSnackbar)

    const isOpen = messageObj.value.trim() !== ""
    const autoHideMs = messageObj.duration || 5000
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
                severity="success"
            >
                {messageObj.value}
            </MuiAlert>
        </Snackbar>
    );
}

export default SuccessSnackbar
