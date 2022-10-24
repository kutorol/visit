import {useDispatch, useSelector} from "react-redux";
import Snackbar from '@mui/material/Snackbar';
import MuiAlert from '@mui/material/Alert';
import {clear} from "../../../reducers/snackbar/error-snackbar";

const ErrorSnackbar = () => {
    const errorsObj = useSelector(state => state.errSnackbar)

    const isOpen = Array.isArray(errorsObj.errors)
    const autoHideMs = errorsObj.duration || 5000
    const muiAlert = {elevation: 6, variant: "filled", severity: "error"}
    console.log(isOpen, autoHideMs, errorsObj)

    const dispatch = useDispatch()
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
