import React, { Component } from 'react'
import Film from './Film';

class FilmList extends Component {

    constructor(props) {
        super(props);

        this.state = {
            sorted: false
        }
    }

    sort = () => this.setState({ sorted: true });

    render() {
        let {films} = this.props;
        if (this.state.sorted)
                films = films.sort((a, b) => a.title.localeCompare(b.title));

        let greenClass = this.state.sorted ? 'text-success' : null;

        if (!films.length) {
            return (
                <div>No films found</div>
            )
        }
        return (
            <div className="film-list">
                {/*<Alert status={status} /> */}
                <div className={`film-list__sort text-right ${greenClass}`}>
                    <a
                        onClick={this.state.sorted ? null : this.sort} href={null}
                        style={this.state.sorted ? null : {cursor : 'pointer'}}
                    >Sort by title</a>
                </div>
                <div className="row">
                    {films.map((film) => (
                        <Film filmFetch={this.props.filmFetch} key={film.id} film={film} />
                    ))}
                </div>
            </div>
        );
    }
}

export default FilmList;