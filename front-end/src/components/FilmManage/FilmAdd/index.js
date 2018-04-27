import React, { Component } from 'react'
import './styles.css'

class FilmAdd extends Component {

    constructor() {
        super();

        this.fields = {
            title: 'asd',
            releaseDate: '',
            format: '',
            actors: ''
        };
        this.state = {
            showForm: false,
        };
    }

    addFilm = (e) => {
        e.preventDefault();

        this.setState({ showForm: false });

        let film = [{
            title: this.fields.title.trim(),
            release_date: this.fields.releaseDate.trim(),
            format: this.fields.format.trim(),
            stars: this.separateActors(this.fields.actors),
        }];

        this.props.saveFilms(film);
    };

    showForm = () => this.setState({ showForm: true });

    close = () => this.setState({ showForm: false });

    separateActors = (actors) => {
        return actors.split(',').map(function(actor) {
            return actor.trim();
        });
    };

    render() {
        return (
            <div>
                <div className="shadow" style={this.state.showForm ? {display: 'block'} : {display: 'none'}}>
                    <div className="file-add">
                        <button
                            onClick={this.close}
                            type="button"
                            className="close"
                            data-dismiss="alert"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form>
                            <div className="form-group text-left">
                                <label htmlFor="title">Title</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    onChange={(e) => this.fields.title = e.target.value}
                                    id="title"
                                    name="title"
                                    placeholder="Title"
                                />
                            </div>
                            <div className="form-group text-left">
                                <label htmlFor="release_date">Release date (year in 4-digit format)</label>
                                <input type="text"
                                       className="form-control"
                                       onChange={(e) => this.fields.releaseDate = e.target.value}
                                       id="release_date"
                                       name="release_date"
                                       placeholder="Release date" />
                            </div>
                            <div className="form-group text-left">
                                <label htmlFor="format">Format</label>
                                <input type="text"
                                       className="form-control"
                                       onChange={(e) => this.fields.format = e.target.value}
                                       id="format"
                                       name="format"
                                       placeholder="Format" />
                            </div>
                            <div className="form-group text-left">
                                <label htmlFor="actors">Actors (separate actors with ",")</label>
                                <input type="text"
                                       className="form-control"
                                       onChange={(e) => this.fields.actors = e.target.value}
                                       id="actors"
                                       name="actors"
                                       placeholder="Actors" />
                            </div>
                            <button onClick={this.addFilm}>Add</button>
                        </form>
                    </div>
                </div>
                <button onClick={this.showForm} className="btn btn-success">+ Add a film</button>
            </div>
        )
    }
}

export default FilmAdd;