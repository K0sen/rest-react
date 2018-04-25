import React, { Component } from 'react'
import FilmAdd from './FilmAdd'
import FilmUpload from './FilmUpload'
import './styles.css'

class FilmCreate extends Component {

    constructor(props) {
        super(props);

        this.state = {
            loading: false
        }
    }

    loading = () => this.setState({loading: !this.state.loading});

    render() {
        return (
            <div className="film-add col-12 col-sm-8 text-right">
                <div className="loader text-center align-content-center" style={this.state.loading ? {display: 'block'} : {display: 'none'}}>
                    <div className="loader__text h2">Loading...</div>
                </div>
                <h3 className="text-center">Film Create</h3>
                <FilmAdd loading={this.loading} filmFetch={this.props.filmFetch} />
                <FilmUpload loading={this.loading} filmFetch={this.props.filmFetch} />
            </div>
        )
    }
}

export default FilmCreate;