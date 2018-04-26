import React, { Component } from 'react'
import './styles.css'

class Alert extends Component {
    constructor(props) {
        super(props);

        this.className = {
            ok: 'alert-info',
            error: 'alert-danger'
        };
        this.state = {
            show: false,
            status: 'ok',
            body: 'Empty body',
        };
    }

    componentDidMount() {
        this.props.onRef(this);
    }

    showAlert = (status, body) => {
        this.setState({
            show: true,
            status: status,
            body: body
        });
    };

    close = () => this.setState({show: false});

    render() {
        let statusName = this.state.status;
        let alertClass = `alert ${this.className[statusName]} alert-dismissible`;
        let display = { display: this.state.show ? 'block' : 'none' };

        return (
            <div style={display} className={alertClass} role="alert">
                <button type="button"
                        className="close"
                        data-dismiss="alert"
                        aria-label="Close"
                        onClick={this.close}
                >
                    <span aria-hidden="true">&times;</span>
                </button>
                <div className="body">{this.state.body}</div>
            </div>
        )
    }
}

export default Alert;