import React, { Component } from 'react'
import './styles.css'

class FilmSearch extends Component {

    render() {
        return (
            <div className="col-12 col-sm-4">
                <h3 className="text-center">Search engine</h3>
                <label htmlFor="title-search" className="small">By film title</label>
                <input
                    id="title-search"
                    className="form-control"
                    type="text" placeholder="Film title"
                    onChange={(e) => this.props.updateFilterFilm(e.target.value)}
                />
                <label htmlFor="actor-search" className="small">By actor</label>
                <input
                    id="actor-search"
                    className="form-control"
                    type="text"
                    placeholder="Actor name"
                    onChange={(e) => this.props.updateFilterActor(e.target.value)}
                />
            </div>
        )
    }

}

export default FilmSearch;