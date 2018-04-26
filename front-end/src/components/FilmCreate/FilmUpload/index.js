import React, { Component } from 'react'
import './styles.css'
import {API_ADDRESS} from "../../../config";

class FilmCreate extends Component {

    constructor(props) {
        super(props);

        this.fieldsName = {
            title: 'title',
            releaseDate: 'release_date',
            format: 'format',
            stars: 'stars'
        };
        this.films = '';
        this.allowedFileType = 'text/plain';
    }

    addFilm = (e) => {
        e.preventDefault();
        if (!this.films) {
            alert('upload a file');
            return false;
        }

        if (!this.films.length) {
            alert('Incorrect films in file');
            return false;
        }

        this.props.saveFilms(this.films);
    };

    readFile = (e) => {
        let fr = new FileReader();
        let file = e.target.files[0];
        if (!file) {
            this.films = '';
            return false;
        }

        if ((file.type !== this.allowedFileType) ) {
            alert(`file type must be ${this.allowedFileType}`);
            return false;
        }

        fr.onload = (e) => {
            this.films = this.parseFile(e.target.result);
            console.log(this.films);
        };

        fr.readAsText(file);
    };

    parseFile = (text) => {
        let filmsList = [];
        let films = text.split('\n\n');
        for (let film of films) {
            let filmObject = {};

            film.split('\n').forEach((item) => {
                let field = item.split(': ');
                let fieldName = field.shift();
                let fieldValue = field.join(': ');
                this.fillFilmObject(filmObject, fieldName, fieldValue);
            });

            if (this.filmCheck(filmObject))
                filmsList.push(filmObject);
        }

        return filmsList;
    };

    fillFilmObject = (filmObject, field, value) => {
        if (field === 'Title') {
            filmObject[this.fieldsName.title] = value.trim();
        } else if (field === 'Release Year') {
            filmObject[this.fieldsName.releaseDate] = value.trim();
        } else if (field === 'Format') {
            filmObject[this.fieldsName.format] = value.trim();
        } else if (field === 'Stars') {
            filmObject[this.fieldsName.stars] = value.split(', ').map((actor) => actor.trim());
        }
    };

    filmCheck = (film) => {
        return  film.hasOwnProperty(this.fieldsName.title) &&
                film.hasOwnProperty(this.fieldsName.releaseDate) &&
                film.hasOwnProperty(this.fieldsName.format) &&
                film.hasOwnProperty(this.fieldsName.stars)
    };

    render() {
        return (
            <form id="film-add__add-from-file">
                <input onChange={this.readFile} type="file" id="file" />
                <button onClick={this.addFilm} className="add-btn btn btn-success">Add from the file</button>
            </form>
        )
    }
}

export default FilmCreate;