import React, { Component } from 'react'
import './styles.css'
import movieImage from './movie-projector.png'
import {API_ADDRESS} from "../../../config";

class Film extends Component {

    constructor(props) {
        super(props);

        this.state = {
            sorted: false,
        }
    }

    deleteFilm = (id) => {
        if (!window.confirm('Delete movie?'))
            return;

        fetch(`${API_ADDRESS}/api/film/${id}`, {method: 'DELETE'})
            .then(res => res.json())
            .then(
                (result) => {
                    console.log(result);
                },
                (error) => console.log(error)
            ).then(() => this.props.filmFetch());
    };

    render() {
        const {film} = this.props;

        return (
            <div className="col-6 col-md-4">
                <div className="film">
                    <div className="film__image">
                        <img src={movieImage} className="img-fluid" alt="movie"/>
                    </div>
                    <div className="film__title">Title: <b>{film.title}</b></div>
                    <div className="film__release-date">Release date: {film.release_date}</div>
                    <div className="film__format">Format: {film.format}</div>
                    <div className="film__actors">Actors: <b>{film.actors}</b></div>
                    <button
                        onClick={() => this.deleteFilm(film.id)}
                        className="film__delete btn btn-danger"
                    >Delete</button>
                </div>
            </div>
        )
    }
}

export default Film;