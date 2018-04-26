import React, { Component } from 'react'
import FilmAdd from './FilmAdd'
import FilmUpload from './FilmUpload'
import './styles.css'
import {API_ADDRESS} from "../../config";

class FilmCreate extends Component {

    constructor(props) {
        super(props);

        this.state = {
            loading: false,
            alert: false
        }
    }

    saveFilms = (films) => {

        this.loading();

        fetch(`${API_ADDRESS}/api/films`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
                // 'Content-Type': 'application/json'
            },
            body: 'json_film='+ encodeURIComponent(JSON.stringify(films))
        }).then(res => res.json())
            .then(
                (result) => {
                    this.props.showAlert(result.status, result.body)
                },
                (error) => {
                    console.log(error);
                }
            )
            .then(() => {
                this.loading();
                this.props.filmFetch();
            })
    };

    loading = () => this.setState({loading: !this.state.loading});

    showAlert = () => {

    };

    render() {
        return (
            <div className="film-add col-12 col-sm-8 text-right">
                <div className="loader text-center align-content-center" style={this.state.loading ? {display: 'block'} : {display: 'none'}}>
                    <div className="loader__text h2">Loading...</div>
                </div>
                <h3 className="text-center">Film Create</h3>
                <FilmAdd saveFilms={this.saveFilms} />
                <FilmUpload saveFilms={this.saveFilms} />
            </div>
        )
    }
}

export default FilmCreate;