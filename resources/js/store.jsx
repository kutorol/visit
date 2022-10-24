import { configureStore } from '@reduxjs/toolkit'
import errSnackbar from "./reducers/snackbar/error-snackbar";
import successSnackbar from "./reducers/snackbar/ok-snackbar";
import warningSnackbar from "./reducers/snackbar/warning-snackbar";
import infoSnackbar from "./reducers/snackbar/info-snackbar";

export default configureStore({
    reducer: {
        successSnackbar: successSnackbar,
        errSnackbar: errSnackbar,
        infoSnackbar: infoSnackbar,
        warningSnackbar: warningSnackbar,
    },
})
