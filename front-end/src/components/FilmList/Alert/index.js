import React, { Component } from 'react'
import './styles.css'

class Alert extends Component {
    constructor(props) {
        super(props);

        this.state = {
            status: props.status,
            className: {
                ok: 'alert-info',
                error: 'alert-error'
            }
        };
    }

    render() {
        let statusName = this.state.status;
        let alertClass = `alert ${this.state.className[statusName]} alert-dismissible fade show`;

        return (
            <div className={alertClass} role="alert">
                <button type="button" className="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {this.state.status}
            </div>
        )
    }
}

export default Alert;