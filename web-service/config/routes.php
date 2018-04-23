<?php

use app\components\Route;

//Routes are in format: convenient name (random) => [alias, controller@action, http method, get params (optional)]
return [
	'get_all_films' => new Route('/api/films', 'FilmController@getFilms', 'get'),
	'add_a_film' => new Route('/api/films', 'FilmController@addFilms', 'post'),
	'delete_a_film' => new Route('/api/film/{id}', 'FilmController@deleteFilm', 'delete', array('id' => '[0-9]+')),
];