<?php

namespace app\controllers;

use app\components\Controller;
use app\components\RestException;
use app\components\Request;
use app\components\Response;
use app\models\Actor;
use app\models\Film;
use app\models\FilmActor;

class FilmController extends Controller
{
	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function getFilms(Request $request)
	{
		$filmModel = new Film();
		$films = $filmModel->findAll();
		return $this->response(compact('films'));
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function getFilm(Request $request)
	{
		$filmModel = new Film();
		$film = $filmModel->findById($request->get('id'));
		if($film)
			return $this->response(['film' => $film]);

		return $this->response(
			'Bad film id',
			Response::NOT_FOUND,
			'error'
		);
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 * @throws RestException
	 */
	public function addFilms(Request $request)
	{
		$jsonList = json_decode($request->post('json_film'), true);
		$count = 0;
		foreach ($jsonList as $film) {
			$filmModel = new Film();
			$actorModel = new Actor();
			$filmActorModel = new FilmActor();
			if ($filmModel->findByName(['title' => $film['title']]))
				continue;

			$filmModel->title = $film['title'];
			$filmModel->release_date = $film['release_date'];;
			$filmModel->format = $film['format'];
			if (!$filmModel->validate()) {
				$errorMessage = json_encode(['Film was not added. Incorrect fields' => $filmModel->getErrors()]);
				throw new RestException($errorMessage, Response::BAD_REQUEST);
			}

			$filmId = $filmModel->save();
			$actorsId = $actorModel->saveActors($film['stars']);
			$filmActorModel->saveRelations($filmId, $actorsId);
			$count++;
		}

		if ($count > 0)
			return $this->response("{$count} film(s) added");
		else
			return $this->response("No new film added", Response::ALREADY_EXISTS);
	}

	/**
	 * @param Request $request
	 *
	 * @return string
	 */
	public function deleteFilm(Request $request)
	{
		$id = $request->get('id');
		$filmModel = new Film();
		$filmActorModel = new FilmActor();
		$film = $filmModel->findById($id);
		if ($film) {
			$filmActorModel->deleteFilmConnections($id);
			$filmModel->deleteById($id);
			return $this->response('Film was removed');
		}

		return $this->response(
			'Bad film id',
			Response::NOT_FOUND,
			'error'
		);
	}
}
