import React, { Component } from 'react';
import 'bootstrap/dist/css/bootstrap.css'
import './styles.css'
import Header from './components/Header'
import FilmList from './components/FilmList'
import FilmSearch from './components/FilmSearch';
import FilmCreate from './components/FilmCreate';
import {API_ADDRESS} from "./config";

class App extends Component {

    constructor() {
        super();

        this.state = {
            filterFilm: '',
            filterActor: '',
            error: null,
            status: '',
            code: 0,
            isLoaded: false,
            films: []
        }
    }

    filmFetch = () => {
        fetch(`${API_ADDRESS}/api/films`)
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({
                        isLoaded: true,
                        status: result.status,
                        films: result.body.films,
                        code: result.code
                    });
                },
                // Note: it's important to handle errors here
                // instead of a catch() block so that we don't swallow
                // exceptions from actual bugs in components.
                (error) => {
                    console.log(error);
                    this.setState({
                        isLoaded: true,
                        error
                    });
                }
            )
    };

    componentWillMount() {
        this.filmFetch();
    }

    updateFilterFilm = (text) => this.setState({ filterFilm: text });

    updateFilterActor = (text) => this.setState({ filterActor: text });

    filterFilms = (films) => films.filter(
        (film) => {
            let filmSearch = this.state.filterFilm.toLowerCase();
            let actorSearch = this.state.filterActor.toLowerCase();
            let actorCheck = film.actors.split(', ').some(function(actor) {
                return actor.toLowerCase().indexOf(actorSearch) !== -1;
            });
            let filmCheck = film.title.toLowerCase().indexOf(filmSearch) !== -1;

            return actorCheck && filmCheck;
        }
    );

    loader = () => this.setState({isLoaded: false});

    render() {
        let content = '';
        if (!this.state.isLoaded) {
            content = <div className="loader">Loading...</div>;
        } else if (this.state.status === 'error') {
            content = <div>Error :(</div>
        } else if (!this.state.films || !this.state.films.length) {
            content = <div>No films. Add some.</div>;
        } else {
            content = <FilmList filmFetch={this.filmFetch.bind(this)} films={this.filterFilms(this.state.films)} />;
        }

        return (
            <div className="wrapper">
                <Header />
                <div className="container">
                    <h1 className="text-center">Film Archive</h1>
                    <div className="managing row justify-content-between">
                        <FilmSearch updateFilterFilm={this.updateFilterFilm.bind(this)}
                                    updateFilterActor={this.updateFilterActor.bind(this)} />
                        <FilmCreate loader={this.loader} filmFetch={this.filmFetch.bind(this)} />
                    </div>
                    <hr />
                    <main className="main">
                        {content}
                    </main>
                </div>
            </div>
        )
    }
}

export default App;