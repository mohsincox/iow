import React from 'react';
import ReactDOM from 'react-dom';

export default class Example extends React.Component {
    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-body">I'm an example component!</div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

if (document.getElementById('examplea')) {
    ReactDOM.render(<Example />, document.getElementById('examplea'));
}
