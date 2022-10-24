import {useSelector} from "react-redux";
import Snackbar from '@mui/material/Snackbar';
import MuiAlert from '@mui/material/Alert';
import {useDispatch} from "react-redux";
import {clear} from "../../../reducers/snackbar/warning-snackbar"

const WarningSnackbar = () => {
    const dispatch = useDispatch()
    const messageObj = useSelector(state => state.warningSnackbar)

    const isOpen = messageObj.value.trim() !== ""
    const autoHideMs = messageObj.duration || 5000

    const muiAlert = {elevation: 6, variant: "filled", severity: "warning"}
    const onClose = () => dispatch(clear())

    return (
        <Snackbar
            open={isOpen}
            autoHideDuration={autoHideMs}
            onClose={onClose}
        >
            <MuiAlert
                elevation={muiAlert.elevation}
                variant={muiAlert.variant}
                severity={muiAlert.severity}
            >
                {messageObj.value}
            </MuiAlert>
        </Snackbar>
    );
}

export default WarningSnackbar
