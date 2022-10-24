import React from "react";
import user from "../Auth/user";
import {Container, Grid, Typography} from "@mui/material";

function Dashboard() {
    return (
        <React.Fragment>
            <Container>
                <Grid container justifyContent={"center"}>
                    <Grid item md={12}>
                        <Typography variant={"h5"}>
                            Hello {user.name}, you're logged in!
                        </Typography>
                    </Grid>
                </Grid>
            </Container>
        </React.Fragment>
    )
}

export default Dashboard
