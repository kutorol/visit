import { createSlice } from '@reduxjs/toolkit'
import {cloneDeep, toNumber} from "lodash";

export const defaultDurationMS = 5000

export const createErrMgs = (listErrs, duration) => {
    let errs = []
    if (typeof listErrs === "string") {
        errs.push(listErrs)
    } else if (Array.isArray(listErrs)) {
        errs = cloneDeep(listErrs)
    } else {
        errs = null
    }

    return {
        errors: errs,
        duration: toNumber(duration)
    }
}

export const errSnackbar = createSlice({
    name: 'errSnackbar',
    initialState: {
        errors: null,
        duration: defaultDurationMS
    },
    reducers: {
        set: (state, action) => {
            const {errors, duration} = action.payload

            state.errors = errors
            const dur = toNumber(duration)
            if (dur > 0) {
                state.duration = dur
            }
        },
        clear: (state) => {
            state.errors = null
            state.duration = defaultDurationMS
        },
    },
})

// Action creators are generated for each case reducer function
export const { set, clear } = errSnackbar.actions

export default errSnackbar.reducer
