import React from 'react';
import ReactDOM from 'react-dom';

export default function Example2() {
    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Example fas</div>

                        <div className="card-body">I'm an 232323example component2!</div>
                    </div>
                </div>
            </div>
        </div>
    );
}

if (document.getElementById('user')) {
    ReactDOM.render(<Example2 />, document.getElementById('user'));
}
