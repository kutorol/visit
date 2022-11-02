import {useSelector} from "react-redux";
import Snackbar from './Snackbar';
import {clear} from "../../../reducers/snackbar/info-snackbar"
import MuiAlert from "@mui/material/Alert";
import React from "react";

const InfoSnackbar = () => {
    const messageObj = useSelector(state => state.infoSnackbar)

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
                severity="info"
            >
                {messageObj.value}
            </MuiAlert>
        </Snackbar>
    );
}

export default InfoSnackbar
