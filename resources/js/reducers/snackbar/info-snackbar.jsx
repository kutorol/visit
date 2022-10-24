import {toNumber} from "lodash";
import {createSnackbarReduce} from "./ok-snackbar";

export const createInfoMgs = (msg, duration) => {
    return {
        msg,
        duration: toNumber(duration),
    }
}
export const infoSnackbar = createSnackbarReduce('infoSnackbar')

// Action creators are generated for each case reducer function
export const { set, clear } = infoSnackbar.actions

export default infoSnackbar.reducer
