<?php

use app\components\Route;

//Routes are in format: convenient name (random) => [alias, controller@action, http method, get params (optional)]
return [
	'get_all_films' => new Route('/api/films', 'FilmController@getFilms', 'GET'),
	'add_a_film' => new Route('/api/films', 'FilmController@addFilms', 'POST'),
	'delete_all_film' => new Route('/api/films', 'FilmController@deleteFilms', 'DELETE'),
	'get_a_film' => new Route('/api/film/{id}', 'FilmController@getFilm', 'GET', array('id' => '[0-9]+')),
	'delete_a_film' => new Route('/api/film/{id}', 'FilmController@deleteFilm', 'DELETE', array('id' => '[0-9]+')),
];