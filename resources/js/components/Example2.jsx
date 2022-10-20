import * as React from 'react';
import Button from '@mui/material/Button';
import ReactDOM from 'react-dom';

export default function Example2() {
    return <Button variant="contained">Hello World</Button>;
}

if (document.getElementById('user')) {
    ReactDOM.render(<Example2 />, document.getElementById('user'));
}
