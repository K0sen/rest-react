import React, { Component } from 'react'
import FilmAdd from './FilmAdd'
import FilmUpload from './FilmUpload'
import './styles.css'

class FilmCreate extends Component {

    constructor(props) {
        super(props);

    }

    render() {
        return (
            <div className="film-add col-12 col-sm-8 text-right">
                <h3 className="text-center">Film Create</h3>
                <FilmAdd loader={this.props.loader} filmFetch={this.props.filmFetch} />
                <FilmUpload loader={this.props.loader} filmFetch={this.props.filmFetch} />
            </div>
        )
    }
}

export default FilmCreate;