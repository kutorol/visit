import React from 'react'
import { useDispatch } from "react-redux";
import { Snackbar as MUISnackbar } from '@mui/material';

export default function Snackbar({ isOpen, autoHideMs, children, onClose }) {
    const dispatch = useDispatch()
    const position = {
        vertical: "top",
        horizontal: "right"
    }

    const _onClose = () => {
        if (typeof onClose === "function") {
            dispatch(onClose())
        }
    };

    return (
        <MUISnackbar
            anchorOrigin={position}
            open={isOpen}
            autoHideDuration={autoHideMs}
            onClose={_onClose}
        >
            {children}
        </MUISnackbar>
    );
}
